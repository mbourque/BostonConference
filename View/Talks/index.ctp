<?php
	$this->Html->script('BostonConference.jquery_1.7.2.min', array('inline'=>false));
	$this->Html->script('//joind.in/widget/widget.php', array('inline'=>false));
	//$this->Html->scriptBlock("var disqus_identifier = '{$this->here}';var disqus_developer = 1; var disqus_shortname = 'nephp';(function () {var s = document.createElement('script'); s.async = true;s.type = 'text/javascript';s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);}());", array('inline'=>false));

//	$disqusIdentifier[] = $this->params['controller'];
//	$disqusIdentifier[] = ( isset($this->params['action']) ) ? $this->params['action'] : null;
//	$disqusIdentifier[] = ( isset($this->params['pass'][0]) ) ? $this->params['pass'][0] : null;
//	$disqusIdentifier = implode(DS, array_filter($disqusIdentifier));
//
//$disqusCommentCode = <<<EOD
//	var disqus_developer = 1;
//	var disqus_shortname = 'nephp';
//	var disqus_category_id = '1555478';
//	var disqus_identifier = '{$disqusIdentifier}';
//    /* * * DON'T EDIT BELOW THIS LINE * * */
//    (function() {
//        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
//        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
//        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
//    })();
//EOD;
//
//$disqusCommentCountCode = <<<EOD
//	var disqus_developer = 1;
//	var disqus_shortname = 'nephp';
//	var disqus_category_id = '1555478';
//	var disqus_identifier = '{$disqusIdentifier}';
//    /* * * DON'T EDIT BELOW THIS LINE * * */
//	(function () {
//		var s = document.createElement('script');
//		s.async = true;
//		s.type = 'text/javascript';
//		s.src = '//' + disqus_shortname + '.disqus.com/count.js';
//		(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
//	}());
//EOD;
//
//	$disqusCode = ( $this->action == 'view' ) ? $disqusCommentCode : $disqusCommentCountCode ;
//
//	$this->Html->scriptBlock($disqusCode, array('inline'=>false));
//
?>
<?php
if( $this->action == 'by_keyword' && isset($keyword) ) :
	$title = $keyword . ' ' .  __('Talks');
elseif( $this->action == 'by_track' && isset($track) ) :
	$title = 'Track : ' . $track;
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


<?php $this->append('after-sidebar'); ?>
<div class='sidebar-box'>
	<h3>Tracks</h3>
<?php
foreach( $tracks AS $key => $track ) {
	$talkLinks[] = $this->Html->link($track, array('action'=>'by_track', $key) );
}
?>
<?php echo $this->Html->nestedList( $talkLinks, array( 'class'=>'track-list' ) ); ?>
</div>
<?php $this->end();?>

<div class="talks listing">
	<table>
		<tbody>
			<?php foreach( $talks AS $talk ) : ?>
			<?php

				$id = $talk['Talk']['id'];

				$topic = $this->Html->clean( $talk['Talk']['topic'] );
				$abstract = $this->Html->clean( $talk['Talk']['abstract'] );
				$speaker = $this->Html->clean($talk['Speaker']['display_name']);
				$time = $this->Time->format( "D M jS \a\\t g:ia", $talk['Talk']['start_time']);
				$where = $this->Html->clean( $talk['Talk']['room']);


				$talkUrl = array( 'action'=>'view', $id );
				$talkLink = $this->Html->link( $topic, $talkUrl, array('class'=>'talk-topic'));
				$speakerUrl = array( 'controller'=>'speakers', 'action'=>'view', $talk['Speaker']['id'] );
				$speakerLink = $this->Html->link( $speaker, $speakerUrl );

				$likes = $talk['Talk']['talk_like_count'];
				$likes = ($likes==0) ? ($likes||0) : $likes;
				$likesLabel = $this->Html->tag('span',$likes);
				$likesLabel = ($likes > 1) ? $likesLabel . ' Likes' : $likesLabel . ' Like' ;

				//$likeButton = $this->Js->link($likesLabel, array('action'=>'like', $id), array('update' => "#like-{$id} span",'id'=>"like-{$id}",'class'=>'button like', 'style'=>'float:right', 'escape'=>false,'rel'=>'nofollow'));
				//$likeButton = $this->Html->link('Rate', array('action'=>'like', $id), array('update' => "#like-{$id} span",'id'=>"like-{$id}",'class'=>'button like', 'style'=>'float:right', 'escape'=>false,'rel'=>'nofollow'));

				if( strtotime($talk['Talk']['start_time']) <= strtotime('now') ) {
					$feedbackButton = $this->Html->link( 'Rate this talk', 'http://joind.in/talk/view/'.$talk['Talk']['joindin_id'], array('class'=>'button feedback-on', 'style'=>'float:right', 'escape'=>false,'rel'=>'nofollow') );
				} else {
					$feedbackButton = $this->Html->link( 'Rate this talk', 'javascript:void(0)', array('class'=>'button feedback-off', 'target'=>'_blank', 'style'=>'float:right', 'title'=>'You can rate this talk when it starts', 'escape'=>false,'rel'=>'nofollow'),'You can rate this talk when it starts' );
				}

				// $disqusComments = $this->Html->link($topic, array_merge($talkUrl, array('#'=>'disqus_thread')));

				// Track
				if( !empty($talk['Track']['id']) ) {
					$track = $this->Html->clean($talk['Track']['name']);
					$trackLink = $this->Html->link($track, array('action'=>'by_track', $talk['Track']['id']));
				}  else {
					$track = false;
				}

				// Keywords
				if( !empty($talk['Talk']['keywords']) ) {
					$keywords = implode( ', ', _keyword_links( $talk['Talk']['keywords'], $this ) );
				} else {
					$keywords = false;
				}

				// Highlight
				if( isset($highlight) ) {
					$talk = $this->Text->highlight( $talk, $highlight );
					$keywords = $this->Text->highlight( $keywords, $highlight );
				}

				// Avatar
				if( !empty( $talk['Speaker']['portrait_url'] ) ) {
					$gravatarImage = $this->Html->image( $talk['Speaker']['portrait_url'], array('url'=>$speakerUrl, 'style'=>'width:100px') );
				} elseif( isset( $talk['Speaker']['email'] ) ) {
					$gravatarImage = $this->Gravatar->image($talk['Speaker']['email'], 100, array('url'=>$speakerUrl));
				} else {
					$gravatarImage = $this->Gravatar->image( null, 100, array('url'=>$speakerUrl) ); // Gets a default Gravatar
				}

			?>

			<tr>
				<td><?php echo $gravatarImage ;?></td>
				<td>
				<?php echo $feedbackButton; ?>

				<?php if( $this->action == 'by_keyword' || sizeof( $talks ) >= 1 ) echo $this->Html->tag('h3', $talkLink) ;?>

				<p class='talk-details'>By: <?php echo $speakerLink; ?>

				<?php if( $track ) : ?>
					<br/> Track: <?php echo $trackLink; ?>
				<?php endif; ?>
				<?php if( $keywords ) : ?>
					<br/> Keywords:	<?php echo $keywords; ?>
				<?php endif; ?>
					<br/>When:	<?php echo $time; ?>
					<br/>Where:	<?php echo $where; ?>
				</p>
				<div class='talk-abstract'><?php echo $abstract;?></div>
				<?php // echo $disqusComments; ?>
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

	$this->append('before-sidebar'); ?>

<div class='sidebar-box'>
	<h3>More about <?php echo $talks[0]['Speaker']['display_name']?></h3>
	<ul>
		<?php echo (!empty($talks[0]['Speaker']['website'])) ? $this->Html->tag('li', $this->Html->link('Website',$talks[0]['Speaker']['website'], array('target'=>'_new'))) : null;?>
		<?php echo (!empty($talks[0]['Speaker']['twitter'])) ? $this->Html->tag('li', 'Follow ' . $this->Html->link('@'.$talks[0]['Speaker']['twitter'],'http://twitter.com/'.$talks[0]['Speaker']['twitter'])) : null;?>
	</ul>
</div>

	<?php $this->end();
}

// Keywords...


function _keyword_links( $keywords, $view ) {
	$ret = array();

	$keywords = (is_array( $keywords )) ? $keywords : explode(',', $keywords);
	foreach( $keywords AS $keyword) {
		$ret[] = $view->Html->link($keyword, array('action'=>'by_keyword', $keyword ));
	}

	return $ret;

}

echo $this->Js->writeBuffer();
?>

<div id="disqus_thread">
</div>
