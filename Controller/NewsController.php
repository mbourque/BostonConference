<?php
App::uses('BostonConferenceAppController', 'BostonConference.Controller');
/**
 * News Controller
 *
 * @property News $News
 */
class NewsController extends BostonConferenceAppController {

/**
 * Pagination options
 *
 * @var array
 */
	public $paginate = array( 'order' => 'News.created DESC' );
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->News->recursive = 0;
		
		$this->paginate = array('order' => array('News.sticky' => 'desc', 'News.created' => 'desc'),
					'conditions' => array( 'News.hide'=> '0' ),
					);
		$news = $this->paginate();
		
		$this->set(compact('news'));

		//Controller::loadModel('Track');
		Controller::loadModel('Track');
		//$this->Track->uses = array('Track' );
		$this->set('tracks', $this->Track->find('list', array('Track.track_id not null')));
	}

	/**
	 * Displays a view
	 *
	 * @param mixed What page to display
	 * @return void
	 */
		public function display() {
			$path = func_get_args();
	
			$count = count($path); 
			if (!$count) {
				$this->redirect('/');
			}
			$page = $subpage = $title_for_layout = null;
	
			if (!empty($path[0])) {
				$page = $path[0];
			}
			if (!empty($path[1])) {
				$subpage = $path[1];
			}
			if (!empty($path[$count - 1])) {
				$title_for_layout = Inflector::humanize($path[$count - 1]);
			}
			$this->set(compact('page', 'subpage', 'title_for_layout'));
			$this->render(implode('/', $path));
		}
	
	
/**
 * super view method
 *
 * @param string $id
 * @return void
 */
	public function view() {
		
		$path = func_get_args(); // debug( $path ); // Debug
				
		$path = implode( '/', $path );

		if( $this->News->findByPath( $path ) )  {
			$news = $this->News->findByPath($path);
			$this->set(compact('news')); 
		} elseif( $this->News->findById( $path ) )  {
			$news = $this->News->findById($path);
		} else {
			throw new NotFoundException(__('Invalid news'));
		}
				
		$this->set(compact('news')); 

		// Get a sidebar
		if( !empty($news['News']['sidebar'])) {
			$this->set('sidebars', $this->News->findAllByPath($news['News']['sidebar']));			
		}

		
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->News->recursive = 0;
		$this->paginate = array(
					 'order' => array(
							  'News.sticky'=>'desc',
							  'News.created'=>'desc',
							  )
					 );
		$this->set('news', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid news'));
		}
		$this->set('news', $this->News->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->News->create();

			$this->request->data['News']['user_id'] = $this->Auth->user('id');

			if ($this->News->save($this->request->data)) {
				$this->Session->setFlash(__('The news has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.'));
			}
		}
		$users = $this->News->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid news'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->News->save($this->request->data)) {
				$this->Session->setFlash(__('The news has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->News->read(null, $id);
		}
		$users = $this->News->User->find('list');
		$this->set(compact('users'));
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
		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid news'));
		}
		if ($this->News->delete()) {
			$this->Session->setFlash(__('News deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('News was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
