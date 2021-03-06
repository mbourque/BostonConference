<?php
App::uses('BostonConferenceAppController', 'BostonConference.Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 */
class TicketsController extends BostonConferenceAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Session','BostonConference.Payments');

/**
 * Before filter
 *
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->allow(array('checkout', 'print_tickets', 'sales', 'preferences'));
		return parent::beforeFilter();
	}

	public function sales() {

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {

		if ( !$this->Auth->loggedIn() ) {
			$this->redirect('/pages/tickets'); // Important place to go
		}

		if ($this->request->is('post')) {
			$items = array();

			foreach( $this->data['quantity'] as $k => $quantity ) {
				if ( $quantity > 0 ) {
					$items[$k] = $quantity;
				}
			}

			if ( count($items) > 0 ) {
				$this->Session->write('Ticket',array('quantity' => $items));
				$this->redirect(array('action' => 'checkout'));
			} else {
				$this->Session->setFlash(__('Please select a valid quantity of tickets before continuing'));
			}
		}

		// Conditions to return TicketOptions that are within the specified start & end dates,
		// or that have no start date, or no end date, or disabled=>true
		$conditions = array(
			array( 'OR' =>
				array(
					'TicketOption.sale_start < NOW()',
					'TicketOption.sale_start IS NULL',
				)
			),
			array( 'OR' =>
				array(
					'TicketOption.sale_end > NOW()',
					'TicketOption.sale_end IS NULL'
				)
			),
			array( 'AND' =>
				array(
					'TicketOption.disabled' => 0
				)
			)
		);

		$this->set('ticketOptions', $this->Ticket->TicketOption->find('all',
			array('order'=>array('price', 'label'),
			'conditions' => $conditions
		)));


		$this->set('tickets', $this->Ticket->find('all',array(
			'order'=>array('Ticket.badge_name','Ticket.id'),
			'conditions'=>array('user_id' => $this->Auth->user('id'))
		)));
	}

/**
 * Print tickets order
 *
 * @return void
 */
	public function print_tickets() {

		if ( !$this->Auth->loggedIn() ) {
			$this->redirect(array('contoller'=>'news'));
		}

		$tickets = $this->Ticket->find('all',array(
			'order'=>array('Ticket.badge_name','Ticket.id'),
			'conditions'=>array('Ticket.user_id' => $this->Auth->user('id')),
			'recursive' => 1
		));
		
		if( count( $tickets ) == 0 ) { // No tickets
			$this->redirect(array('controller'=>'news'));
		}

		$event = $this->Ticket->TicketOption->Event->current(array('contain'=>true));
		$user = array_shift(Set::extract('/User/.[:first]', $tickets));
		$sale['subtotal'] = array_sum(Set::extract('/TicketOption/price', $tickets));
		$sale['count'] = count(Set::extract('/Ticket/id', $tickets));
		$sale['date'] = max(Set::extract('/Ticket/created', $tickets));

		$this->set( compact( 'event', 'user', 'sale', 'tickets' ) );

	}

	public function preferences() {
		if ( $this->Auth->loggedIn() ) {
			$id = $this->Auth->user('id');
		} else {
			$this->Session->setFlash(__('Not logged in'));
			$this->redirect($this->Auth->logout());
		}

		if ($this->request->is('post')) {
			if ($this->Ticket->TicketAnswer->saveAll($this->request->data['TicketAnswer'])) {
				$this->Session->setFlash(__('Your preferences have been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The preference could not be saved. Please, try again.'));
			}
		}

		$tickets = $this->Ticket->find('all', array('contain'=>'TicketAnswer','conditions'=>array('Ticket.user_id'=>$id)));
		if( count( $tickets ) == 0 ) { // No tickets
			$this->redirect(array('controller'=>'news'));
		}
		$ticketQuestions = $this->Ticket->TicketAnswer->TicketQuestion->find('all', array('contain'=>true));
		$this->set(compact('tickets', 'ticketQuestions', 'options'));
	}



/**
 * checkout method
 *
 * @return void
 */
	public function checkout() {
		$items = array();

		if ( !$this->Auth->loggedIn() ) {
			$this->Session->setFlash(__('Please register or login'));
			$this->redirect($this->Auth->loginAction);
		}

		$ticket = $this->Session->read('Ticket');
		if ( !$ticket || !array_key_exists('quantity',$ticket) || !is_array($ticket['quantity']) ) {
			$this->Session->delete('Ticket');
			$this->redirect(array('action' => 'index'));
		}

		$options = $this->Ticket->TicketOption->find(
				'all',
				array(
					'order'=>array('label'),
					'conditions' => array( 'TicketOption.id' => array_keys($ticket['quantity']) )
				)
			);

		if ( count($options) != count($ticket['quantity']) ) {
			$this->Session->delete('Ticket');
			$this->Session->setFlash(__('An error occured processing your tickets'));
			$this->redirect(array('action' => 'index'));
		}

		$totalPrice = 0;

		foreach ( $options as $i => $option ) {
			foreach ( $ticket['quantity'] as $id => $quantity ) {
				if ( $option['TicketOption']['id'] == $id ) {
					$options[$i]['TicketOption']['quantity'] = $quantity;
					$totalPrice += $quantity * $option['TicketOption']['price'];

					$items[] = array(
						'name' => $option['TicketOption']['label'],
						'amount' => $option['TicketOption']['price'],
						'quantity' => $quantity
					);
					break;
				}
			}
		}

		if ($this->request->is('post')) {

			$valid = true;
			$ticket['badge_name'] = array();

			$ticket['organization'] = $this->data['Ticket']['organization'];


			foreach( $this->data['Ticket'] as $key => $value ) {
				if ( preg_match('/badge_name_([0-9]+)_([0-9]+)/',$key,$m) == 1 ) {

					$valid = $valid && $this->Ticket->validateBadgeName($key,$value);

					if ( !array_key_exists($m[1],$ticket['badge_name']) )
						$ticket['badge_name'][$m[1]] = array($value);
					else
						$ticket['badge_name'][$m[1]][] = $value;

				}
			}

			if ( $valid ) {
				$this->Session->write('Ticket',$ticket);

				if ( $totalPrice > 0 ) {
					if ( !$this->Payments->process($totalPrice,$items) ) {
						$this->Session->setFlash(__('There was an error processing your tickets'));
						$this->redirect(array('action' => 'index'));
					}
				}

				if ( $this->_completeRegistration() ) {
					$this->Session->setFlash(__('Thank you! You are now registered for the conference!'));
				} else {
					$this->Session->setFlash(__('There was an error processing your tickets'));
				}
				$this->redirect(array('action' => 'index'));
			}
		}

		$this->set('ticketOptions',$options);
		$this->set('totalPrice',$totalPrice);
	}

/**
 * confirm method
 *
 * @return void
 */
	public function confirm() {
		if ( $this->_completeRegistration(array($this->Payments,'confirm')) ) {
			$this->Session->setFlash(__('Thank you! You are now registered for the conference!'));
		} else {
			$this->Session->setFlash(__('There was an error processing your tickets'));
		}

		$this->Session->delete('PayPal');
		$this->Session->delete('Ticket');

		$this->redirect(array('action' => 'index'));
	}

/**
 * cancel method
 *
 * @return void
 */
	public function cancel() {
		$this->Session->delete('PayPal');
		$this->Session->delete('Ticket');

		$this->Session->setFlash(__('Your ticket purchase has been canceled'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_lookup( $field = null ) {

		$search_term = $this->request->data['search_term'];
		$field = $this->request->data['field'];

		switch ($field) {

			default:
			case 'Ticket.badge_name':
			case 'User.name':
			case 'User.email':
			case 'Ticket.organization':
			$this->paginate = array( 'conditions' => array("LOCATE('{$search_term}', {$field})"));
			break;

			case 'Ticket.id':
			$this->paginate = array( 'conditions' => array('Ticket.id'=>$search_term));
			break;

		}

		$this->autoRender = false;
		$this->Ticket->recursive = 0;
		$this->set('tickets', $this->paginate());

		$this->render('admin_index');

	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Ticket->recursive = 0;
		$this->Ticket->order = array('Ticket.created'=>'desc');
		$this->set('tickets', $this->paginate());
	}

/**
 * admin_by_user method
 * Filters the list of tickets by user
 *
 ** @param string $user_id The user ID
 * @return void
 */
	public function admin_by_user( $user_id ) {
		$this->autoRender = false;
		$this->Ticket->recursive = 0;
		$this->paginate = array('conditions'=>array('Ticket.user_id' => $user_id ));
		$this->set('tickets', $this->paginate());
		$this->render('admin_index');
	}


/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		$this->set('ticket', $this->Ticket->read(null, $id));
		$this->set('ticket_questions', $this->Ticket->TicketAnswer->TicketQuestion->find('list'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Ticket->create();
			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		}
		$users = $this->Ticket->User->find('list');
		$ticketOptions = $this->Ticket->TicketOption->find('list');
		$this->set(compact('users', 'ticketOptions'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ticket->read(null, $id);
		}
		$users = $this->Ticket->User->find('list');
		$ticketOptions = $this->Ticket->TicketOption->find('list');
		$this->set(compact('users', 'ticketOptions'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Ticket->id = $id;
		if (!$this->Ticket->exists()) {
			throw new NotFoundException(__('Invalid ticket'));
		}
		if ($this->Ticket->delete()) {
			$this->Session->setFlash(__('Ticket deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ticket was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * Completes registration.
 *
 * @return void
 */
	protected function _completeRegistration( $callback = null ) {

		if ( !($userId = $this->Auth->user('id')) )
			return false;

		$ticket = $this->Session->read('Ticket');

		if ( !$this->Ticket->completeRegistration($userId, $ticket, $callback) ) {
			$this->Session->delete('Ticket');
			$this->Session->setFlash(__('There was an error processing your tickets'));
			$this->redirect(array('action' => 'index'));
			return false;
		}
		return true;
	}
}
