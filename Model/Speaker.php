<?php
App::uses('BostonConferenceAppModel', 'BostonConference.Model');
/**
 * Speaker Model
 *
 * @property User $User
 * @property Talk $Talk
 */
class Speaker extends BostonConferenceAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'last_name';

/**
 * Virtual fields
 *
 * @var array
 */
	var $virtualFields = array(
		'display_name' => 'CONCAT(Speaker.first_name, " ", Speaker.last_name)'
	);


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a first name.',
				'allowEmpty' => false,
				'required' => true,
			),
			'maxlength' => array(
				'rule' => array('maxlength',32),
				'message' => 'First name cannot exceed 32 characters.',
				'allowEmpty' => false,
				'required' => true,
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter a last name.',
				'allowEmpty' => false,
				'required' => true,
			),
			'maxlength' => array(
				'rule' => array('maxlength',32),
				'message' => 'Last name cannot exceed 32 characters.',
				'allowEmpty' => false,
				'required' => true,
			),
		),
		'website' => array(
			'url' => array(
				'rule' => array('url', true),
				'message' => 'Website must be a valid URL.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please supply a valid email address.',
				'allowEmpty' => false,
				'required' => false,
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'That email is already in use.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'twitter' => array(
			'twitter' => array(
				'rule' => '/[a-zA-Z0-9_]{1,20}/',
				'message' => 'Please supply a valid twitter username with the @',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'featured' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'Featured must be boolean.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'portrait_url' => array(
			'url' => array(
				'rule' => array('url'),
				'message' => 'Portrait URL must be a valid URL.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'dependent' => false,
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Talk' => array(
			'className' => 'BostonConference.Talk',
			'foreignKey' => 'speaker_id',
			'dependent' => false,
		)
	);

}
