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
						echo $this->Html->image( $speaker['Speaker']['portrait_url'], array('url'=>$speakerLink, 'style'=>'width:80px') );
					} elseif( isset( $speaker['Speaker']['email'] ) ) {
						echo $this->Gravatar->image($speaker['Speaker']['email'], 80, array('url'=>$speakerLink));
					} else {
						echo $this->Gravatar->image( null, 80, array('url'=>$speakerLink) ); // Gets a default Gravatar
					}
					?>
				</td>
				<td>
				<?php if( sizeof( $speakers ) > 1 ) : ?>
					<h3><?php echo $this->Html->link($speaker['Speaker']['display_name'], $speakerLink);?></h3>
				<?php endif; ?>

				<? if( !empty( $speaker['Talk'] ) ) : ?>
					<?php
						$talks = array();
						foreach( $speaker['Talk'] as $talk ) {
							$talks[] = $this->Html->link($talk['topic'], array('controller'=>'talks','action'=>'view', $talk['id']));
						}
					?>
				<p class='talk-details'><?php echo ( count($talks) >1) ? 'Talks:' : 'Talk:' ;?>&nbsp;<?php echo implode(', ', $talks); ?></p>
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
   !(empty( $speakers[0]['Speaker']['website'] ) || empty( $speakers[0]['Speaker']['twitter'] ) ) ) {

	$this->append('after-sidebar'); ?>

	<h3>More about me</h3>
	<ul>
		<?php echo (!empty($speakers[0]['Speaker']['website'])) ? $this->Html->tag('li', $this->Html->link('My Website',$speakers[0]['Speaker']['website'])) : null;?>
		<?php echo (!empty($speakers[0]['Speaker']['twitter'])) ? $this->Html->tag('li', 'Follow me ' . $this->Html->link('@'.$speakers[0]['Speaker']['twitter'],'http://twitter.com/'.$speakers[0]['Speaker']['twitter'])) : null;?>
	</ul>

	<?php $this->end();
}

?>
