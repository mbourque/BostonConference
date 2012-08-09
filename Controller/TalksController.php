<?php
App::uses('BostonConferenceAppController', 'BostonConference.Controller');
App::uses('Sanitize', 'Utility');
/**
 * Talks Controller
 *
 * @property Talk $Talk
 */
class TalksController extends BostonConferenceAppController {

/**
 * helpers
 *
 * @var array
 */
	public $helpers = array('BostonConference.Schedule');

/**
 * Before filter
 *
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->allow(array('agenda','schedule', 'by_keyword', 'by_track', 'like'));
		return parent::beforeFilter();
	}

	public function agenda() {

		$this->Talk->contain(array('Track', 'Speaker'));
		$talks = $this->Talk->find( 'all', array(
												 'fields'=>array(
																 'Talk.id',
																 'Talk.topic',
																 'Talk.abstract',
																 'Talk.start_time',
																 'Talk.duration',
																 'Talk.room',
																 'Talk.speaker_id',
																 'Track.*',
																 'Speaker.*',
																 ),
												 'order' => array('Talk.start_time', 'Talk.room')
												 )
								   );

		$this->set( 'talks', $talks );

		foreach( $talks as $track ) {
			if ( $track['Track']['id'] )
				$tracks[$track['Track']['id']] = $track['Track'];
		}

		$this->set('tracks', array_values($tracks));


	}

/**
 * index method
 * Return talks that have speakers associated
 * @param array $options Optional. Array of find options
 * @returns void
 */
	public function index( $options = array() ) {

		if( !is_array($options) ) $options = array();

		$default_options['conditions'][] = array('Talk.speaker_id not' => null);
		$default_options['order'] = array('Talk.talk_like_count'=>'desc','Track.position','Talk.topic');

		$options = array_merge_recursive( $default_options, $options );

		$talks = $this->Talk->forCurrentEvent( true, $options );
		$all_keywords = $this->Talk->keywords( $talks );
		$tracks = $this->Talk->Track->find( 'list' );

		$this->set( compact('talks', 'tracks', 'all_keywords') );

	}

/**
 * view method.
 * Displays talk by id.
 *
 * @return void
 */
	public function view( $id ) {

		if (!$this->Talk->exists( $id )) {
			throw new NotFoundException(__('Invalid talk'));
		}

		$talks = $this->Talk->forCurrentEvent( true, array( 'conditions'=>array('Talk.id' => $id )));
		$all_keywords = $this->Talk->keywords( $talks );
		$tracks = $this->Talk->Track->find( 'list' );
		$this->set(compact('talks', 'tracks', 'all_keywords'));

		$this->render('index');

	}


/**
 * schedule method
 *
 * @return void
 */
	public function schedule() {
		$tracks = array();
		$talks = $this->Talk->forCurrentEvent();

		foreach( $talks as $track ) {
			if ( $track['Track']['id'] )
				$tracks[$track['Track']['id']] = $track['Track'];
		}

		$this->set('tracks', array_values($tracks));
		$this->set('talks', $talks);
	}


/**
 * by_keyword method
 *
 * @returns void
 */
	public function by_keyword( $keyword = false ) {

		$options = array();

		if( $keyword ) {
			$keyword = Sanitize::clean( $keyword );
			$options['conditions'] = array( "LOCATE('{$keyword}', Talk.keywords)");
		} else {
			$this->Session->setFlash(__('Missing keyword') );
			$this->redirect(array('action'=>'index'));
		}

		$this->setAction( 'index', $options );
		$this->action = 'by_keyword';
		$this->set( compact( 'talks', 'keyword', 'all_keywords') );

	}

/**
 * by_track method
 *
 * @returns void
 */
	public function by_track( $track_id = null ) {

		if ( !isset($track_id) || !$this->Talk->Track->exists( $track_id )) {
			$this->Session->setFlash(__('Invalid track') );
			$this->redirect(array('action'=>'index'), 301 );
		}

		$options['conditions'] = array( 'Track.id' => $track_id );
		$options['order'] = array('Track.position','Talk.topic');
		$this->setAction( 'index', $options );

		$track = $this->Talk->Track->field('name',array('id'=>$track_id));

		$this->action = 'by_track';
		$this->set( compact( 'talks', 'track') );

	}


	public function like( $talk_id ) {

		$this->autoRender = false;

		if (!$this->request->is('ajax')) {
			throw new MethodNotAllowedException();
		}

		$this->Talk->TalkLike->like( $talk_id, $this->Session->read('Config.userAgent'));
		return $this->Talk->TalkLike->likes( $talk_id );

	}

	public function search( $term = false, $options = array() ) {

		$term = Sanitize::clean( $term, array('encode'=>true, 'remove_html'=>true) );
		if( empty($term) || strlen( $term ) < 3 ) {
			$this->Session->setFlash(__('Missing search term') );
			$this->redirect(array('action'=>'index'));
		}

		$this->Talk->virtualFields = array(
			'fulltext' => "CONCAT_WS('|',Talk.topic,Talk.abstract,Talk.keywords)"
		);
		$options = array( 'conditions'=>array('fulltext LIKE' => "%{$term}%"));

		$this->autoRender = false;
		$this->Session->setFlash(__("Showing search results for '%s'", $term) );
		$this->setAction('index', $options);
		$this->render('index');

	}


/**
 * admin_add_multiple method
 *
 * @return void
 */
	public function admin_add_multiple() {

		if ($this->request->is('post')) {

			$this->Talk->set($this->request->data);
			if ($this->Talk->validates( )) {

				$originalData = $this->request->data;
				$start = strtotime($this->Talk->deconstruct('start_time', $this->request->data['Talk']['start_of_day']));
				$end = strtotime("-{$this->request->data['Talk']['duration']} minutes",
								 strtotime($this->Talk->deconstruct('start_time', array_merge(
														  $this->request->data['Talk']['start_of_day'],
														  $this->request->data['Talk']['end_of_day']
														  ))));
				$interval = $this->request->data['Talk']['interval'];
				$counter = 0;
				$data = array();

				while( $start <= $end ) {
					$counter++;

					// Set new start time
					$this->Talk->set( 'start_time', date('Y-m-d H:i', $start));

					// Append index to topic name
					$this->Talk->set( 'topic', "{$this->request->data['Talk']['topic']} : {$counter}");

					// Store
					$data[] = $this->Talk->data;

					// Next start time
					$start = strtotime( "+{$interval} minutes", $start );
				}

				// saveMany
				if( $counter && $this->Talk->saveMany( $data ) ) {
					$this->Session->setFlash(__("{$counter} talks have been created"));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The talks could not be created. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The talks could not be created. Please, try again.'));
			}
		}

		$events = $this->Talk->Event->find('list');
		$speakers = $this->Talk->Speaker->find('list');
		$tracks = $this->Talk->Track->find('list');
		$this->set(compact('events', 'speakers', 'tracks'));
	}


/**
 * admin_schedule method
 *
 * @returns void
 */
	public function admin_schedule() {
		$this->setAction('schedule');
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Talk->recursive = 0;
		$this->paginate = array(
			'limit' => 25,
			'order' => array(
				'Talk.start_time' => 'asc'
			)
		);
		$this->set('talks', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Talk->id = $id;
		if (!$this->Talk->exists()) {
			throw new NotFoundException(__('Invalid talk'));
		}
		$this->set('talk', $this->Talk->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Talk->create();
			if ($this->Talk->save($this->request->data)) {
				$this->Session->setFlash(__('The talk has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The talk could not be saved. Please, try again.'));
			}
		}
		$events = $this->Talk->Event->find('list');
		$speakers = $this->Talk->Speaker->find('list');
		$tracks = $this->Talk->Track->find('list');
		$this->set(compact('events', 'speakers', 'tracks'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Talk->id = $id;
		if (!$this->Talk->exists()) {
			throw new NotFoundException(__('Invalid talk'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Talk->save($this->request->data)) {
				$this->Session->setFlash(__('The talk has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The talk could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Talk->read(null, $id);
		}
		$events = $this->Talk->Event->find('list');
		$speakers = $this->Talk->Speaker->find('list');
		$tracks = $this->Talk->Track->find('list');
		$this->set(compact('events', 'speakers', 'tracks'));
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
		$this->Talk->id = $id;
		if (!$this->Talk->exists()) {
			throw new NotFoundException(__('Invalid talk'));
		}
		if ($this->Talk->delete()) {
			$this->Session->setFlash(__('Talk deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Talk was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
