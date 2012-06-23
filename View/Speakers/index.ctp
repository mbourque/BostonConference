<?php
if( $this->action == 'index' ) {
	$this->append('header'); ?>
<div class="speakers index">
	<h2><?php echo __('Speakers');?></h2>
</div>
<?php $this->end();
} else {
	$this->set('title_for_layout', $speakers[0]['Speaker']['display_name'] );
}
?>
<div class="speakers index">
	<table>
		<tbody>
			<?php foreach( $speakers AS $speaker ) : ?>
			<tr>
				<td><?php
					$speakerLink = array( 'controller'=>'speakers','action'=>'view', $speaker['Speaker']['id'] );
					if( !empty( $speaker['Speaker']['portrait_url'] ) ) {
						echo $this->Html->image( $speaker['Speaker']['portrait_url'], array('url'=>$speakerLink, 'style'=>'width:80px') );
					} elseif( isset( $speaker['Speaker']['email'] ) ) {
						echo $this->Gravatar->image($speaker['Speaker']['email'], 80, array('url'=>$speakerLink));
					} else {
						echo $this->Gravatar->image( null, 80, array('url'=>$speakerLink) ); // Gets a default Gravatar
					}
					?>
				</td>
				<td><h3><?php echo $this->Html->link($speaker['Speaker']['display_name'], $speakerLink);?></h3>
				<p class='speaker-bio'><?php echo $this->Html->clean($speaker['Speaker']['bio']);?></p>

				<? if( !empty( $speaker['Talk'] ) ) : ?>
					<?php
						$talks = array();
						foreach( $speaker['Talk'] as $talk ) {
							$talks[] = $this->Html->link($talk['topic'], array('controller'=>'talks','action'=>'view', $talk['id']));
						}
					?>
					<cite><?php echo __('My talks:');?>&nbsp;<?php echo implode(', ', $talks); ?></cite>
				<? endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
