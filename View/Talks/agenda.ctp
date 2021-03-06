<?php
$this->set('skinny_sidebar',true);
$this->set('title_for_layout','Agenda');

if ( count( $tracks ) > 0 )
{
	$this->append('sidebar');
?>

<div class='sidebar-box'>
	Download the schedule <?php echo $this->Html->link('here', 'http://2014.northeastphp.org/uploads/pdfs/nephp-agenda.pdf', array('class'=>'red')); ?>.
</div>

<div class='sidebar-box'>
	<h3>Tracks</h3>
	<ul class="tracks">
	<?php

		$trackCss = "";

		foreach( $tracks as $track )
		{
			echo '<li class="track-'.$track['id'].'">'.$track['name'].'</li>';

			if ( !empty($track['color']) ) {
				$trackCss .= '#content .track-'.$track['id'].' { background-color: #'.$track['color'].'; } ';
			}
		}

		if ( !empty($trackCss) )
			$this->append('css',$this->Html->tag('style',$trackCss));
	?>
	</ul>
</div>
<?php
	$this->end();
}


	$times = array_unique( array_filter(Set::extract('{n}/Talk/start_time', $talks) ) );
	foreach( $times AS $time ) {
		$date = date('Ymd', strtotime($time) );
		$days[$date][] = $time;
	}
	$rooms = array_unique( array_filter(Set::extract('{n}/Talk/room', $talks) ) );
	
	$day0 = 20140906;
	$day1 = 20140907;

?>
<div class='agenda'>
<?php $i = 0;?>
<?php foreach( $days as $day => $times ) : ?>
<?php $i++; ?>
	<a name='day<?php echo $i;?>'/></a>
	<h3>Day <?php echo $i;?> - <?php echo date( 'l, F jS', strtotime($day)); ?></h3>
	<table>
		<thead>
			<tr>
				<th>&nbsp;</th>
				<?php foreach( $rooms AS $room ) : ?>
				<th><?php echo $room;?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $times AS $number ) :?>
			<tr>
				<td><nobr><?php echo date('g:i a', strtotime( $number ));?></nobr></td>
				<?php
				
				$talk_blocks = $this->Schedule->getTalksInBlock( strtotime($number), $talks );
				if( count( $talk_blocks ) == 1 && empty($talk_blocks[0]['Talk']['track_id']) ) {
					echo '<td class="" colspan="' . count($rooms) . '">';
					echo '<h4>';
					echo $this->Html->link($talk_blocks[0]['Talk']['topic'], array('action'=>'view', $talk_blocks[0]['Talk']['id']));
					echo '</h4>';
					if ( isset($talk_blocks[0]['Talk']['speaker_id'])) {
						echo $this->Gravatar->image($talk_blocks[0]['Speaker']['email'], 100, array('style'=>'float:left; padding-bottom: 10px; padding-right: 10px;'));
						echo "<p>With ";
						echo $this->Html->link($talk_blocks[0]['Speaker']['first_name'] . " " . $talk_blocks[0]['Speaker']['last_name'], array('controller'=>'speakers','action'=>'view', $talk_blocks[0]['Speaker']['id']));
						echo '</p>';
						echo '<p>';
						echo $talk_blocks[0]['Talk']['abstract'];
						echo '</p>';
					} else {
						echo '<p>';
						echo $talk_blocks[0]['Talk']['abstract'];
						echo '</p>';
					}
					echo '<br/>'.'</td>';
					continue;
				}
				foreach( $rooms AS $key => $room ) :
					echo '<td>';
					foreach( $talk_blocks AS $talk ) {
						if ( $talk['Talk']['room'] == $room ) {
							echo '<div class="talk '.$this->Schedule->getTalkClass($talk,$talks, $key).'"><p>';
							if( $talk['Speaker']['portrait_url'] ) {
								echo $this->Html->image( $talk['Speaker']['portrait_url'], array( 'style'=>'width:70px;float:left;') );
							} else {								
								echo $this->Gravatar->image( $talk['Speaker']['email'], 70, array('style'=>'float:left;'));
							}
							echo $this->Html->link($talk['Talk']['topic'], array('action'=>'view', $talk['Talk']['id']), array('class'=>'agenda-topic'));
							echo "<br/>";
							echo $this->Html->link($talk['Speaker']['first_name'] . " " . $talk['Speaker']['last_name'], array('controller'=>'speakers','action'=>'view', $talk['Speaker']['id']));
							echo '</p>';
							echo $talk['Talk']['room'] . ', ' . ($talk['Talk']['duration']) . ' Minutes';
							echo '</div>';
						}
					}
					echo '&nbsp;</td>';
				endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endforeach; ?>
</div>
