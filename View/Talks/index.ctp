<?php
if( $this->action == 'index' ) {
	$this->append('header'); ?>
<div class="talks index">
	<h2><?php echo ($keyword) ? "{$keyword} " : null;?><?php echo __('Talks');?></h2>
</div>
<?php $this->end();
} else {
	$this->set('title_for_layout', $talks[0]['Talk']['topic'] );

	// More about...
	if( !empty( $talks[0]['Speaker']['website'] ) || !empty( $talks[0]['Speaker']['twitter'] ) ) {

	$this->append('after-sidebar'); ?>

	<h3>More about me</h3>
	<ul>
		<?php echo (!empty($talks[0]['Speaker']['website'])) ? $this->Html->tag('li', $this->Html->link('My Website',$talks[0]['Speaker']['website'])) : null;?>
		<?php echo (!empty($talks[0]['Speaker']['twitter'])) ? $this->Html->tag('li', 'Follow me ' . $this->Html->link('@'.$talks[0]['Speaker']['twitter'],'http://twitter.com/'.$talks[0]['Speaker']['twitter'])) : null;?>
	</ul>

	<?php $this->end();
	}

	// Keywords...
	if( !empty( $talks[0]['Talk']['keywords'] ) ) {

	$this->append('after-sidebar'); ?>

	<?php

		$keywords_list = explode( ',', $talks[0]['Talk']['keywords'] );
		foreach ( $keywords_list as $keyword ) {
			$keyword = trim( $keyword );
			$keywords[] = $this->Html->link($keyword, array('action'=>'by_keyword', $keyword ));
		}

	?>
	<h3>Keywords</h3>
	<ul>
		<li><?php echo implode( ', ', $keywords ) ;?></li>
	</ul>

	<?php $this->end();
	}


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
