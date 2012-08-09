<?php

//debug( $response );

	$options = array(
		'encode' => true,
		'odd_spaces' => false,
		'remove_html' => false,
		'encode' => false,
		'dollar' => false,
		'carriage' => false,
		'unicode' => false,
		'escape' => false,
		'backslash' => false
	);

	function mystriptag( &$item ) {
		$item = strip_tags($item, '<br><ul><li><ol><p><a>');
		// $item = htmlspecialchars_decode($item);
	}

	array_walk_recursive($response, 'mystriptag');
	//$response = array_map('strip_tags', $response );
	//die();
	//$response = $this->Html->clean($response, $options);
	$response = json_encode($response);

	if (isset($callback)) {
		echo $callback . '(' . $response . ');';
	} else {
		echo $response;
	}
