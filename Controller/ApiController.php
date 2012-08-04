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

		$this->Speaker->virtualFields = array_merge_recursive(
			$this->Speaker->virtualFields,
			array(
				'gravatar' => "md5('Speaker.email')",
			)
		);

		$default_options['contain'] = array('Talk.id', 'Talk.topic');
		$default_options['fields'] = array('Speaker.display_name',
										   'Speaker.gravatar',
										   );

		if( $id ) {
			$default_options['conditions'][] = array('Speaker.id' => $id);
		}

		$options = array_merge_recursive( $default_options, $options );

		$speakers = $this->Speaker->find( 'all', $options );

		// Rest
		$this->set(array('speakers'=>$speakers, '_serialize' => array('speakers')));

	}

	public function talks( $id = false, $options = array() ) {

		$this->loadModel('BostonConference.Talk');

		$default_options['contain'] = array('Speaker.first_name', 'Speaker.last_name');
		$default_options['fields'] = array('Talk.id',
										   'Talk.topic',
										   'Talk.abstract',
										   'Talk.talk_like_count'
										   );

		if( $id ) {
			$default_options['conditions'][] = array('Talk.id' => $id);
		}

		$default_options['conditions'][] = array('Talk.speaker_id not' => null);
		$default_options['order'] = array('Talk.topic');

		$options = array_merge_recursive( $default_options, $options );

		$talks = $this->Talk->forCurrentEvent( true, $options );

		$this->set('response', compact('talks'));
		$this->layout = false;
		$this->render( 'json' );


	}


}
