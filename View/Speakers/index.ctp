<?php
if( $this->action == 'view' ) :
	$title = 'Speaker : ' . $speakers[0]['Speaker']['display_name'];
else :
	$title = __('Speakers');
endif;

// Set title
$this->set('title_for_layout',  $title );

?>
<?php $this->append('header'); ?>
<div class="talks index">
	<h2><?php echo $title;?></h2>
</div>
<?php $this->end(); ?>

<div class="speakers index">
	<table>
		<tbody>
			<?php foreach( $speakers AS $speaker ) : ?>
			<tr>
				<td><?php
					$speakerLink = array( 'controller'=>'speakers','action'=>'view', $speaker['Speaker']['id'] );
					if( !empty( $speaker['Speaker']['portrait_url'] ) ) {
						$gravatar = $this->Html->image( $speaker['Speaker']['portrait_url'], array('url'=>$speakerLink, 'style'=>'width:100px') );
					} elseif( isset( $speaker['Speaker']['email'] ) ) {
						$gravatar = $this->Gravatar->image($speaker['Speaker']['email'], 100, array('url'=>$speakerLink));
					} else {
						$gravatar = $this->Gravatar->image( null, 100, array('url'=>$speakerLink) ); // Gets a default Gravatar
					}
					echo $gravatar;
					?>
				</td>
				<td>
				<?php if( sizeof( $speakers ) >= 1 ) : ?>
					<h3><?php echo $this->Html->link($speaker['Speaker']['display_name'], $speakerLink);?></h3>
				<?php endif; ?>

				<? if( !empty( $speaker['Talk'] ) ) : ?>
					<?php
						$talks = array();
						foreach( $speaker['Talk'] as $talk ) {
							//debug( $talk );
							if( $talk['approved'] == false ) continue;
							$talks[] = $this->Html->link($talk['topic'], array('controller'=>'talks','action'=>'view', $talk['id']));
						}
					?>
				<p class='talk-details'><?php echo __n('Talk:','Talks:', count($talks));?>&nbsp;<?php echo implode(', ', $talks); ?></p>
				<? endif; ?>

				<p class='speaker-bio'><?php echo $this->Html->clean($speaker['Speaker']['bio']);?></p>

				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php

// More about...
if( $this->action == 'view' &&
   (!empty( $speakers[0]['Speaker']['website'] ) || !empty( $speakers[0]['Speaker']['twitter'] ) ) ) {

	$this->append('after-sidebar'); ?>
<div class='sidebar-box'>
	<h3>More about <?php echo $speakers[0]['Speaker']['display_name'];?></h3>
	<ul>
		<?php echo (!empty($speakers[0]['Speaker']['website'])) ? $this->Html->tag('li', $this->Html->link('Website',$speakers[0]['Speaker']['website'])) : null;?>
		<?php echo (!empty($speakers[0]['Speaker']['twitter'])) ? $this->Html->tag('li', 'Follow ' . $this->Html->link('@'.$speakers[0]['Speaker']['twitter'],'http://twitter.com/'.$speakers[0]['Speaker']['twitter'])) : null;?>
	</ul>
</div>
	<?php $this->end();
}

?>
