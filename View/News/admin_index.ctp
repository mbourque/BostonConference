<?php
$this->append('header')
?>
<div class="news index">
	<h2><?php echo __('News');?></h2>
</div>
<?php
$this->end();
?>
<div class="news index">
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('path');?></th>
			<th><?php echo $this->Paginator->sort('sidebar');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($news as $news): ?>
	<tr>
		<td><strong><?php echo $this->Html->link($news['News']['title'], array('action' => 'view', $news['News']['id'],'admin'=>false)); ?></strong>
			<br/><?php echo strip_tags($this->Text->truncate($news['News']['body'],100,array('html'=>false)));?></td>
		
		<td><?php echo h($news['News']['path']); ?></td>
		<td><?php echo h($news['News']['sidebar']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $news['News']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $news['News']['id']), null, __('Are you sure you want to delete # %s?', $news['News']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<?php
$this->append('sidebar');
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Article'), array('action' => 'add')); ?></li>
	</ul>
</div>
<?php
$this->end();
?>
