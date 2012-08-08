<?php

	$times = array_unique( array_filter(Set::extract('{n}/Talk/start_time', $talks) ) );
	foreach( $times AS $time ) {
		$date = date('Ymd', strtotime($time) );
		$days[$date][] = $time;
	}
	$rooms = array_unique( array_filter(Set::extract('{n}/Talk/room', $talks) ) );


?>
<h2>Agenda</h2>

<?php foreach( $days as $day => $times ) : ?>
	<h3><?php echo date( 'l, F jS', strtotime($day)); ?></h3>
	<table>
		<thead>
			<tr>
				<th>Time</th>
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
				if( count( $talk_blocks ) == 1 && empty($talk_blocks[0]['Talk']['room']) ) {
					echo '<td colspan=' . count($rooms) . '><strong>' . $talk_blocks[0]['Talk']['topic'] . '</strong><br/>'.'</td>';
					//echo '<td colspan=' . count($rooms) . '><strong>' . $talk_blocks[0]['Talk']['topic'] . '</strong><br/>'.$talk_blocks[0]['Talk']['abstract'].'</td>';
					continue;
				}
				foreach( $rooms AS $room ) :
					echo '<td>';
					foreach( $talk_blocks AS $talk ) {
						if ( $talk['Talk']['room'] == $room ) {
							echo $talk['Talk']['topic'];
						}
					}
					echo '&nbsp;</td>';
				endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endforeach; ?>
