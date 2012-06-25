<?php

class BostonConferenceAppModel extends AppModel {

/**
 * actsAs
 *
 * @var array
 */
	public $actsAs = array( 'Containable' );

	// Unbinds all related models
	function unbindModelAll() {
		foreach( array(
				'hasOne' => array_keys($this->hasOne),
				'hasMany' => array_keys($this->hasMany),
				'belongsTo' => array_keys($this->belongsTo),
				'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany)
		) as $relation => $model) {
				$this->unbindModel(array($relation => $model));
		}
	}

}
