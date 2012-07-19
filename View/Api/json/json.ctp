<?php

	$response = json_encode($response);

	if (isset($callback)) {
		echo $callback . '(' . $response . ');';
	} else {
		echo $response;
	}

