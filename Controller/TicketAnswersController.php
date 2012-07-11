<?php
App::uses('BostonConferenceAppController', 'BostonConference.Controller');
/**
 * TicketAnswers Controller
 *
 * @property TicketAnswer $TicketAnswer
 */
class TicketAnswersController extends BostonConferenceAppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->TicketAnswer->recursive = 0;
		$this->set('ticketAnswers', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->TicketAnswer->id = $id;
		if (!$this->TicketAnswer->exists()) {
			throw new NotFoundException(__('Invalid ticket answer'));
		}
		$this->set('ticketAnswer', $this->TicketAnswer->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->TicketAnswer->create();
			if ($this->TicketAnswer->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket answer has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket answer could not be saved. Please, try again.'));
			}
		}
		$tickets = $this->TicketAnswer->Ticket->find('list');
		$ticketQuestions = $this->TicketAnswer->TicketQuestion->find('list');
		$this->set(compact('tickets', 'ticketQuestions'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->TicketAnswer->id = $id;
		if (!$this->TicketAnswer->exists()) {
			throw new NotFoundException(__('Invalid ticket answer'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TicketAnswer->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket answer has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket answer could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TicketAnswer->read(null, $id);
		}
		$tickets = $this->TicketAnswer->Ticket->find('list');
		$ticketQuestions = $this->TicketAnswer->TicketQuestion->find('list');
		$this->set(compact('tickets', 'ticketQuestions'));
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
		$this->TicketAnswer->id = $id;
		if (!$this->TicketAnswer->exists()) {
			throw new NotFoundException(__('Invalid ticket answer'));
		}
		if ($this->TicketAnswer->delete()) {
			$this->Session->setFlash(__('Ticket answer deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ticket answer was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
