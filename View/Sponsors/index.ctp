<?php
if ( $sponsorshipRequests ) {
	$this->append('sidebar');
?>
<div class="actions">
	<p>We're still looking for sponsors at all budget levels.</p>
	<ul>
		<li><?php echo $this->Html->link( __('Request Information'), array('action'=>'request'));?></li>
	</ul>
</div>
<?php
$this->end();
}

$this->append('header');
?>
<div class="sponsors index">
	<h2><?php echo __('Sponsors');?></h2>
</div>
<?php
$this->end();
?>
<div class="sponsors index">

	<?php
	$classes = array(
			array('diamond',2,1),
			array('gold',3,1),
			array('silver',4,2)
		  );

	foreach( $sponsorshipLevels as $level )
	{
		if( !$sponsorshipRequests && empty($level['Sponsor'] ) ) continue; // Skip if $requestSponsor is false

		list( $class, $perRow, $minRows ) = array_shift($classes);
		if ( !$class ) $class='basic';

		echo '<h3>'.$level['SponsorshipLevel']['label'].'</h3>';

		foreach ( $level['Sponsor'] as $sponsor ) {
			echo '<a href="'.$sponsor['website'].'" class="sponsor-box '.$class.'" target="_blank">';
			if ( $sponsor['logo_url'] )
				echo '<img src="'.$sponsor['logo_url'].'" title="'.$sponsor['organization'].'" alt="Logo: '.$sponsor['organization'].'" />';
			else
				echo $sponsor['organization'];
			echo '</a>';
		}

		if( $sponsorshipRequests ) {

			$sponsorAd = $this->Html->link(__('Become a Sponsor'), array('action'=>'request'), array('class'=>"sponsor-box looking {$class}"));
			$c = count($level['Sponsor']);

			if ( $perRow && $c%$perRow != 0 ) {
				echo $sponsorAd;
			}

			if ( $perRow && ($rowCount = ceil($c/$perRow)) < $minRows ) {
				for ( $i = $rowCount; $i<$minRows; $i++ ) {
					for ( $j=0; $j<$perRow; $j++ )
						echo $sponsorAd;
				}

			}
			if ( !$perRow )
				echo $sponsorAd;

		} // endif $sponsorshipRequests


	}
	?>


</div>
