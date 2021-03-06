<?php
$this->append('header')
?>
<div class="speakers index">
	<h2><?php echo __('Speakers');?></h2>
</div>
<?php
$this->end();
?>
<div class="speakers index">
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>
			<th><?php echo $this->Paginator->sort('featured');?></th>
			<th><?php echo $this->Paginator->sort('approved_talk_count');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($speakers as $speaker): ?>
	<tr>
		<td><?php echo h($speaker['Speaker']['id']); ?>&nbsp;</td>
		<td><?php echo h($speaker['Speaker']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($speaker['Speaker']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($speaker['Speaker']['featured']); ?>&nbsp;</td>
		<td><?php echo h($speaker['Speaker']['approved_talk_count']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $speaker['Speaker']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $speaker['Speaker']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $speaker['Speaker']['id']), null, __('Are you sure you want to delete # %s?', $speaker['Speaker']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Speaker'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Email Speakers'), array('action' => 'email')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Talks'), array('controller' => 'talks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Talk'), array('controller' => 'talks', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php
$this->end();
?>
