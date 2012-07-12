<div class="ticketAnswers index">
	<h2><?php echo __('Ticket Answers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ticket_id');?></th>
			<th><?php echo $this->Paginator->sort('ticket_question_id');?></th>
			<th><?php echo $this->Paginator->sort('answer');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($ticketAnswers as $ticketAnswer): ?>
	<tr>
		<td><?php echo h($ticketAnswer['TicketAnswer']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ticketAnswer['Ticket']['badge_name'], array('controller' => 'tickets', 'action' => 'view', $ticketAnswer['Ticket']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ticketAnswer['TicketQuestion']['label'], array('controller' => 'ticket_questions', 'action' => 'view', $ticketAnswer['TicketQuestion']['id'])); ?>
		</td>
		<td><?php echo h($ticketAnswer['TicketAnswer']['answer']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ticketAnswer['TicketAnswer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ticketAnswer['TicketAnswer']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ticketAnswer['TicketAnswer']['id']), null, __('Are you sure you want to delete # %s?', $ticketAnswer['TicketAnswer']['id'])); ?>
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
<?php $this->start('sidebar'); ?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Add Answer'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'ticket_questions', 'action' => 'index')); ?> </li>
	</ul>
</div>
<?php $this->end(); ?>
