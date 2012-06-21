<?php
$this->append('header');
?>
<div class="talks listing">
	<h2><?php echo ( $this->action == 'view' ) ? __('Talk Abstract') : __('Talks');?></h2>
</div>
<?php
$this->end();
?>
<div class="talks listing">
	<table cellpadding='0' cellspacing='0'>
		<tbody>
			<?php foreach( $talks AS $talk ) : ?>
			<tr>
				<td><?php
					$speakerLink = array( 'controller'=>'speakers','action'=>'view', $talk['Speaker']['id'] );
					$talkLink = array( 'action'=>'view', $talk['Talk']['id'] );
					if( !empty( $talk['Speaker']['portrait_url'] ) ) {
						echo $this->Html->image( $talk['Speaker']['portrait_url'], array('url'=>$speakerLink) );
					} elseif( isset( $talk['Speaker']['email'] ) ) {
						echo $this->Gravatar->image($talk['Speaker']['email'], null, array('url'=>$speakerLink));
					} else {
						echo $this->Gravatar->image( 'someone@example.com', null, array('url'=>$speakerLink) ); // Gets a default Gravatar
					}
					?>
				</td>
				<td><h3><?php echo $this->Html->link( $talk['Talk']['topic'], $talkLink );?></h3>
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
