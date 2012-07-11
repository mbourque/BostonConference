<div class="ticketQuestions view">
<h2><?php  echo __('Ticket Question');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ticketQuestion['TicketQuestion']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($ticketQuestion['TicketQuestion']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Options'); ?></dt>
		<dd>
			<?php echo h($ticketQuestion['TicketQuestion']['options']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Required'); ?></dt>
		<dd>
			<?php echo h($ticketQuestion['TicketQuestion']['required']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ticket Question'), array('action' => 'edit', $ticketQuestion['TicketQuestion']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ticket Question'), array('action' => 'delete', $ticketQuestion['TicketQuestion']['id']), null, __('Are you sure you want to delete # %s?', $ticketQuestion['TicketQuestion']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ticket Questions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket Question'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ticket Answers'), array('controller' => 'ticket_answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket Answer'), array('controller' => 'ticket_answers', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Ticket Answers');?></h3>
	<?php if (!empty($ticketQuestion['TicketAnswer'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ticket Id'); ?></th>
		<th><?php echo __('Ticket Question Id'); ?></th>
		<th><?php echo __('Answer'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ticketQuestion['TicketAnswer'] as $ticketAnswer): ?>
		<tr>
			<td><?php echo $ticketAnswer['id'];?></td>
			<td><?php echo $ticketAnswer['ticket_id'];?></td>
			<td><?php echo $ticketAnswer['ticket_question_id'];?></td>
			<td><?php echo $ticketAnswer['answer'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'ticket_answers', 'action' => 'view', $ticketAnswer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'ticket_answers', 'action' => 'edit', $ticketAnswer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'ticket_answers', 'action' => 'delete', $ticketAnswer['id']), null, __('Are you sure you want to delete # %s?', $ticketAnswer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ticket Answer'), array('controller' => 'ticket_answers', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
