<div class="ticketAnswers form">
<?php echo $this->Form->create('TicketAnswer');?>
	<fieldset>
		<legend><?php echo __('Admin Add Ticket Answer'); ?></legend>
	<?php
		echo $this->Form->input('ticket_id');
		echo $this->Form->input('ticket_question_id');
		echo $this->Form->input('answer');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php $this->start('sidebar'); ?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Answers'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'ticket_questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'ticket_questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<?php $this->end(); ?>
