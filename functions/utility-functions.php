<?php
// Create an excerpt function
function create_excerpt($trim_thing, $trim_length){
	$trimmed = $trim_thing;
	$count = strlen($trim_thing);
	
	if($count >= $trim_length){
		$trimmed = strip_tags($trimmed);
		$trimmed = substr( $trimmed, 0, $trim_length);
		$trimmed = preg_replace( '/\W\w+\s*(\W*)$/', '$1', $trimmed );
		$trimmed = preg_replace('/[^a-z0-9]+\Z/i', '', $trimmed);
		$trimmed = $trimmed . '...';
	}else{
		$trimmed = strip_tags($trim_thing);
	}

	return $trimmed;
}

?>