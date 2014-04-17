<?php
App::uses('BostonConferenceAppController', 'BostonConference.Controller');
App::uses('Sanitize', 'Utility');
/**
 * Workshops Controller
 *
 * @property Workshop $Workshop
 */
class WorkshopsController extends BostonConferenceAppController {
	
	
	public function index( $options = array() ) {
		
		
				
		//if( !is_array($options) ) $options = array();
		//
		//$default_options['conditions'][] = array('Workshop.speaker_id not' => null);
		//$default_options['conditions'][] = array('Workshop.duration' => '120');
		//$default_options['conditions'][] = array('Workshop.approved' => '1' );
		//$default_options['order'] = array('Workshop.start_time'=>'asc','Track.position','Talk.topic');
		//
		//$options = array_merge_recursive( $default_options, $options );
		//
		$talks = $this->Workshop->find('all');
		//$talks = $this->Workshop->forCurrentEvent( true, $options );
		////$all_keywords = $this->Talk->keywords( $talks );
		//$tracks = $this->Workshop->Track->find( 'list' );
		//
		//$this->set( compact('talks', 'tracks') );
		$this->render('../talks/index');
		//
		
	}
	

}
