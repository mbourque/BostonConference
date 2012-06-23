<?php
if( $this->action == 'index' ) {
	$this->append('header'); ?>
<div class="talks index">
	<h2><?php echo __('Talks');?></h2>
</div>
<?php $this->end();
} else {
	$this->set('title_for_layout', $talks[0]['Talk']['topic'] );
}
?>
<div class="talks listing">
	<table>
		<tbody>
			<?php foreach( $talks AS $talk ) : ?>
			<tr>
				<td><?php
					$speakerLink = array( 'controller'=>'speakers','action'=>'view', $talk['Speaker']['id'] );
					$talkLink = array( 'action'=>'view', $talk['Talk']['id'] );
					if( !empty( $talk['Speaker']['portrait_url'] ) ) {
						echo $this->Html->image( $talk['Speaker']['portrait_url'], array('url'=>$speakerLink, 'style'=>'width:80px') );
					} elseif( isset( $talk['Speaker']['email'] ) ) {
						echo $this->Gravatar->image($talk['Speaker']['email'], 80, array('url'=>$speakerLink));
					} else {
						echo $this->Gravatar->image( null, 80, array('url'=>$speakerLink) ); // Gets a default Gravatar
					}
					?>
				</td>
				<td><?php echo $this->Html->link( $talk['Talk']['topic'], $talkLink , array('class'=>'talk-topic'));?>
				<span class='talk-details'><?php echo $this->Html->link($talk['Speaker']['display_name'], $speakerLink); ?>, Track: <?php echo $talk['Track']['name']; ?></span>
				<?php
					$abstract = $talk['Talk']['abstract'];
					$abstract = $this->Html->clean( $abstract );
				?>
				<div class='talk-abstract'><?php echo $abstract;?></div>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
