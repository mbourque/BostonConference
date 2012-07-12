<div class="tickets view">
<h2><?php  echo __('Ticket');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['User']['last_name'], array('controller' => 'users', 'action' => 'view', $ticket['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket Option'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['TicketOption']['id'], array('controller' => 'ticket_options', 'action' => 'view', $ticket['TicketOption']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Badge Name'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['badge_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Organization'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['organization']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paid'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['paid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>


<div class="related">
	<h3><?php echo __('Ticket Answers');?></h3>
	<?php if (!empty($ticket['TicketAnswer'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ticket Question Id'); ?></th>
		<th><?php echo __('Answer'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ticket['TicketAnswer'] as $ticketAnswer): ?>
		<tr>
			<td><?php echo $ticketAnswer['id'];?></td>
			<td><?php echo $ticket_questions[$ticketAnswer['ticket_question_id']];?></td>
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
</div>

<?php
$this->start('sidebar');
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ticket'), array('action' => 'edit', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ticket'), array('action' => 'delete', $ticket['Ticket']['id']), null, __('Are you sure you want to delete # %s?', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ticket Options'), array('controller' => 'ticket_options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket Option'), array('controller' => 'ticket_options', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php
$this->end();
?>
