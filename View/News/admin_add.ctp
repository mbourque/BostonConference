<div class="news form">
<?php echo $this->Form->create('News');?>
	<fieldset>
		<legend><?php echo __('Admin Add News'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('path', array('label'=>'URL', 'after'=>'Examples: food, food/allergies, food/menu'));
		echo $this->Form->input('sidebar', array('label'=>'Sidebar URL', 'after'=>'Examples: food/sidebar'));
		echo $this->Form->input('sticky');
		echo $this->Form->input('hide');		
		echo $this->ContentManagement->richtext('News.body');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php
$this->append('sidebar');
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List News'), array('action' => 'index'));?></li>
	</ul>
</div>
<?php
$this->end();
?>
