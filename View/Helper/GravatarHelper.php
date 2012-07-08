<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Gravatar helper
 *
 */
class GravatarHelper extends AppHelper {

/**
 * Array of helpers needed
 *
 * @var array
 */
	public $helpers = array('Html');

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param array $options Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 */
	public function image( $email, $s = 80, $options = array() ) {

		$defaultOptions['class'] = 'gravatar';

		$options = array_merge_recursive( $defaultOptions, $options );

		$url = ($this->request->is('ssl')) ? 'https://secure.gravatar.com/avatar/' : 'http://www.gravatar.com/avatar/';
		$url .= (!empty($email)) ? md5( strtolower( trim( $email ) ) ) : '00000000000000000000000000000000';
		$url .= htmlentities("?s=".$s."&d=mm");
		$output = $this->Html->image( $url, $options );
		return $output;
	}
}
