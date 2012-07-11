<?php
App::uses('BostonConferenceAppModel', 'BostonConference.Model');
/**
 * TalkLike Model
 *
 * @property Talk $Talk
 */
class TalkLike extends BostonConferenceAppModel {

	public function likes( $talk_id ) {

		return $this->find('count', array(
										'recursive' => -1,
										'callbacks' => false,
										'conditions'=>array('TalkLike.talk_id'=>$talk_id)
									)
						   );
	}

	public function like( $talk_id, $user_agent = false ) {

		// Check that talk exists
		if (!$this->Talk->exists( $talk_id )) {
			return false;
		}

		// Check if user_agent is set and if already exists
		if( $user_agent ) {
			if( $this->hasAny( array( 'talk_id'=>$talk_id, 'user_agent'=>$user_agent ))) {
				return false;
			} else {
				$this->set('user_agent', $user_agent );
			}
		}

		$this->set('talk_id', $talk_id);
		return( $this->Talk->TalkLike->save( ) );
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Talk' => array(
			'className' => 'BostonConfernece.Talk',
			'foreignKey' => 'talk_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => true
		)
	);
}
