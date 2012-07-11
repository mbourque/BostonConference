<?php
App::uses('BostonConferenceAppController', 'BostonConference.Controller');
/**
 * TicketQuestions Controller
 *
 * @property TicketQuestion $TicketQuestion
 */
class TicketQuestionsController extends BostonConferenceAppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->TicketQuestion->recursive = 0;
		$this->set('ticketQuestions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->TicketQuestion->id = $id;
		if (!$this->TicketQuestion->exists()) {
			throw new NotFoundException(__('Invalid ticket question'));
		}
		$this->set('ticketQuestion', $this->TicketQuestion->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->TicketQuestion->create();
			if ($this->TicketQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket question could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->TicketQuestion->id = $id;
		if (!$this->TicketQuestion->exists()) {
			throw new NotFoundException(__('Invalid ticket question'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TicketQuestion->save($this->request->data)) {
				$this->Session->setFlash(__('The ticket question has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticket question could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TicketQuestion->read(null, $id);
		}
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
		$this->TicketQuestion->id = $id;
		if (!$this->TicketQuestion->exists()) {
			throw new NotFoundException(__('Invalid ticket question'));
		}
		if ($this->TicketQuestion->delete()) {
			$this->Session->setFlash(__('Ticket question deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ticket question was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
