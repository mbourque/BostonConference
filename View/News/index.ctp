<?php

$this->set('title_for_layout', '');

if ( count( $news ) > 0 )
{
	foreach ($news as $news)
	{
?>
<article>
	<h2><?php echo $this->Html->link($news['News']['title'], array('action'=>$news['News']['path'],'plugin'=>null)); ?></h2>
	<p><?php echo $this->Html->clean($news['News']['body']); ?>&nbsp;</p>
	<time datetime="<?php echo date('Y-m-d', strtotime($news['News']['created']));?>">Posted on <?php echo date(Configure::read('BostonConference.dateFormat'),strtotime($news['News']['created'])); ?></time>
</article>
<?php
	}
?>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
<?php
}
else
{
?>
<p>Please check back later for the latest news and updates.</p>
<?php
}
?>
