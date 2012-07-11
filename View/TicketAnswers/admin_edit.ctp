<div class="ticketAnswers form">
<?php echo $this->Form->create('TicketAnswer');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Ticket Answer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ticket_id');
		echo $this->Form->input('ticket_question_id');
		echo $this->Form->input('answer');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TicketAnswer.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TicketAnswer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Ticket Answers'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ticket Questions'), array('controller' => 'ticket_questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket Question'), array('controller' => 'ticket_questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
