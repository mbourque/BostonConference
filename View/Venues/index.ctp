<h2>Venue</h2>

<?php

if ( $venue ) {

	$address = $venue['Venue']['address'];

	$this->start('sidebar');

	if ( $address ) {
		$flatAddress = htmlentities(urlencode(str_replace("\n",',',$address)));
		echo '<a href="http://maps.google.com/maps?q='.$flatAddress.'&iwloc=A">';
		echo '<img src="http://maps.google.com/maps/api/staticmap?center='.$flatAddress.'&size=266x266&sensor=false&zoom=13&markers='.
		     $flatAddress.'" style="border: 1px solid #301e14; border-radius: 5px;" width="266" height="266" />';
		echo '</a>';
	}
	$this->end();

	echo '<p><strong>'.$this->Html->clean($venue['Venue']['name']).'</strong><br />'.( $address ? $this->Html->clean(str_replace("\n","\n<br />",$address)) : '' ).'</p>';

	if ( !empty($venue['Venue']['website']) && preg_match('#^https?://([^/]+)#',$venue['Venue']['website'],$m) ) {
		echo '<p>'.$this->Html->link($m[1],$venue['Venue']['website']).'</p>';
	}

	if ( $venue['Venue']['transportation_instructions'] ) {
		echo '<h3>Transportation</h3>';
		echo '<p>'.$this->Html->clean(str_replace("\n","\n<br />",$venue['Venue']['transportation_instructions'])).'</p>';
	}

} else {
?>

<p>Venue to be determined. Please check back later.</p>

<?php
}
?>