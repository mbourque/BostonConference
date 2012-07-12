<div class="ticketAnswers view">
<h2><?php  echo __('Ticket Answer');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ticketAnswer['TicketAnswer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticketAnswer['Ticket']['badge_name'], array('controller' => 'tickets', 'action' => 'view', $ticketAnswer['Ticket']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticketAnswer['TicketQuestion']['label'], array('controller' => 'ticket_questions', 'action' => 'view', $ticketAnswer['TicketQuestion']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Answer'); ?></dt>
		<dd>
			<?php echo h($ticketAnswer['TicketAnswer']['answer']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php $this->start('sidebar'); ?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Answer'), array('action' => 'edit', $ticketAnswer['TicketAnswer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Answer'), array('action' => 'delete', $ticketAnswer['TicketAnswer']['id']), null, __('Are you sure you want to delete # %s?', $ticketAnswer['TicketAnswer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'ticket_questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'ticket_questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php $this->end(); ?>
