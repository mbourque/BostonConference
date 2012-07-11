<div class="ticketQuestions index">
	<h2><?php echo __('Ticket Questions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('label');?></th>
			<th><?php echo $this->Paginator->sort('options');?></th>
			<th><?php echo $this->Paginator->sort('required');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($ticketQuestions as $ticketQuestion): ?>
	<tr>
		<td><?php echo h($ticketQuestion['TicketQuestion']['id']); ?>&nbsp;</td>
		<td><?php echo h($ticketQuestion['TicketQuestion']['label']); ?>&nbsp;</td>
		<td><?php echo h($ticketQuestion['TicketQuestion']['options']); ?>&nbsp;</td>
		<td><?php echo h($ticketQuestion['TicketQuestion']['required']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ticketQuestion['TicketQuestion']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ticketQuestion['TicketQuestion']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ticketQuestion['TicketQuestion']['id']), null, __('Are you sure you want to delete # %s?', $ticketQuestion['TicketQuestion']['id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Ticket Question'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ticket Answers'), array('controller' => 'ticket_answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket Answer'), array('controller' => 'ticket_answers', 'action' => 'add')); ?> </li>
	</ul>
</div>
