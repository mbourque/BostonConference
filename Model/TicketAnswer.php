<?php
App::uses('BostonConferenceAppModel', 'BostonConference.Model');
/**
 * TicketAnswer Model
 *
 * @property Ticket $Ticket
 * @property TicketQuestion $TicketQuestion
 */
class TicketAnswer extends BostonConferenceAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'answer';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ticket' => array(
			'className' => 'BostonConference.Ticket',
			'foreignKey' => 'ticket_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TicketQuestion' => array(
			'className' => 'BostonConference.TicketQuestion',
			'foreignKey' => 'ticket_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
