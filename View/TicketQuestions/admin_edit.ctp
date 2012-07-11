<div class="ticketQuestions form">
<?php echo $this->Form->create('TicketQuestion');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Ticket Question'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('label');
		echo $this->Form->input('description');
		echo $this->Form->input('options');
		echo $this->Form->input('required');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TicketQuestion.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('TicketQuestion.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Ticket Questions'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Ticket Answers'), array('controller' => 'ticket_answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket Answer'), array('controller' => 'ticket_answers', 'action' => 'add')); ?> </li>
	</ul>
</div>
