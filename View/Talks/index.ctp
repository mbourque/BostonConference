<?php
if( $this->action == 'by_keyword' && isset($keyword) ) :
	$title = $keyword . ' ' .  __('Talks');
elseif( $this->action == 'view' ) :
	$title = 'Talk : ' . $talks[0]['Talk']['topic'];
else :
	$title = __('Talks');
endif;
	$this->set('title_for_layout',  $title );
?>
<?php $this->append('header'); ?>
<div class="talks index">
	<h2><?php echo $title;?></h2>
</div>
<?php $this->end();?>
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
				<td>
				<?php if( $this->action == 'by_keyword' || sizeof( $talks ) > 1 ) : ?>
					<h3><?php echo $this->Html->link( $talk['Talk']['topic'], $talkLink , array('class'=>'talk-topic'));?></h3>
				<? endif; ?>

				<?php if( !empty($talk['Talk']['keyword'] ) ) : ?>

				<? endif; ?>

				<p class='talk-details'><?php echo $this->Html->link($talk['Speaker']['display_name'], $speakerLink); ?>, Track: <?php echo $talk['Track']['name']; ?></p>
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
<?php

// More about...
if( $this->action == 'view' &&
   (!empty( $talks[0]['Speaker']['website'] ) || !empty( $talks[0]['Speaker']['twitter'] ) ) ) {

	$this->append('after-sidebar'); ?>

	<h3>More about me</h3>
	<ul>
		<?php echo (!empty($talks[0]['Speaker']['website'])) ? $this->Html->tag('li', $this->Html->link('My Website',$talks[0]['Speaker']['website'])) : null;?>
		<?php echo (!empty($talks[0]['Speaker']['twitter'])) ? $this->Html->tag('li', 'Follow me ' . $this->Html->link('@'.$talks[0]['Speaker']['twitter'],'http://twitter.com/'.$talks[0]['Speaker']['twitter'])) : null;?>
	</ul>

	<?php $this->end();
}

// Keywords...
$talk_keywords = array_filter( Set::extract('{n}.Talk.keywords', $talks) );
if( $this->action != 'index' && count( $talk_keywords ) != 0 ) {

	$keywords = _keyword_links( $talk_keywords, $this );

	$this->append('after-sidebar'); ?>

	<h3>Related talks</h3>
	<ul>
		<li><?php echo implode( ', ', $keywords ) ;?></li>
	</ul>

	<?php $this->end();
}


function _keyword_links( $keywords, $view ) {

	$keywords = array_unique( $keywords );

	foreach( $keywords AS $list ) {
		$items = explode( ',', $list );
		foreach( $items AS $keyword ) {
			$keyword = trim( $keyword );
			$ret[$keyword] = $view->Html->link($keyword, array('action'=>'by_keyword', $keyword ));
		}
	}
	return $ret;

}
