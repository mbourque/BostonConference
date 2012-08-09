<?php
App::uses('BostonConferenceAppController', 'BostonConference.Controller');

/**
 * Speakers Controller
 *
 * @property Speaker $Speaker
 */
class ApiController extends BostonConferenceAppController {

	public function beforeRender() {

		if( isset( $this->params->query['callback'] ) ) {
			$this->set('callback', $this->params->query['callback'] );
		}

		//debug( $this->viewVars );


	}

/**
 * Before filter
 *
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->allow(array('talks','speakers'));
		return parent::beforeFilter();
	}

	public function speakers( $id = false, $options = array() ) {

		$this->loadModel('BostonConference.Speaker');

		$default_options['contain'] = array('Talk.id', 'Talk.topic', 'Talk.abstract', 'Talk.talk_like_count');
		$default_options['fields'] = array('Speaker.id',
										   'Speaker.first_name',
										   'Speaker.last_name',
										   );

		if( $id ) {
			$default_options['conditions'][] = array('Speaker.id' => $id);
		}

		if( isset($this->params->query['sort'] ) ) {
			$sort = $this->params->query['sort'];

			if( $sort == 'id' ) $default_options['order'] = array('Speaker.id');
			if( $sort == 'alpha' ) $default_options['order'] = array('Speaker.last_name');

		} else {
			$default_options['order'] = array('Speaker.last_name');
		}


		$options = array_merge_recursive( $default_options, $options );

		$speakers = $this->Speaker->find( 'all', $options );

		// Rest
		$this->set(array('speakers'=>$speakers, '_serialize' => array('speakers')));

	}

	public function talks( $id = false, $options = array() ) {

		$this->loadModel('BostonConference.Talk');

		$default_options['contain'] = array('Speaker.first_name', 'Speaker.last_name', 'Track.name');
		$default_options['fields'] = array('Talk.id',
										   'Talk.topic',
										   'Talk.abstract',
										   'Talk.room',
										   'Talk.start_time',
										   'Talk.duration',
										   'Talk.talk_like_count'
										   );

		if( $id ) {
			$default_options['conditions'][] = array('Talk.id' => $id);
		}

		$default_options['conditions'][] = array('Talk.speaker_id not' => null);

		if( isset($this->params->query['sort'] ) ) {
			$sort = $this->params->query['sort'];

			if( $sort == 'id' ) $default_options['order'] = array('Talk.id');
			if( $sort == 'alpha' ) $default_options['order'] = array('Talk.id');
			if( $sort == 'likes' ) $default_options['order'] = array('Talk.talk_like_count DESC');
			if( $sort == 'speaker' ) $default_options['order'] = array('Speaker.last_name');
			if( $sort == 'time' ) {
				$default_options['order'] = array('Talk.start_time');
				$default_options['conditions'][] = array('Talk.start_time >=' => date('Y-m-d H:i:s', strtotime('-1 hour')));
			}

		} else {
			$default_options['order'] = array('Talk.topic');
		}

		$options = array_merge_recursive( $default_options, $options );

		$talks = $this->Talk->forCurrentEvent( true, $options );

		$this->set('response', compact('talks'));
		$this->layout = false;
		$this->render( 'json' );


	}


}
