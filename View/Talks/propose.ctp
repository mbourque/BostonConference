<?php
		$durationOptions = array(
			'options' => array(
				60  => '1 hour talk',
				120 => '2 hour session',
				180 => '3 hour workshop'
			),
			'value' => 60,
			'label'=>__('What sort of talk is this?')
		);

		$userdefined1Options = array(
			'options' => array(
				'none' => 'Beginner & Advanced',
				'beginner'  => 'Beginner',
				'advanced' => 'Advanced',
			),
			'value' => 'begineer',
			'label'=>__('What skill level is this talk?')
		);
		
?>
<div class="talks form">
<?php echo $this->Form->create('Talk');?>

		<h2><?php echo __('Propose Talk'); ?></h2>
		<p>We would love to you have you talk. Please tell us more...</p>
	<?php	
		echo $this->Form->input('Talk.event_id');
		echo $this->Form->input('Speaker.first_name');
		echo $this->Form->input('Speaker.last_name');
		echo $this->Form->input('Speaker.email');

		echo $this->Form->input('Talk.topic', array(
							    'after'=>'Example: PHP In the Cloud',
							    'label'=>__('What is the title of your talk?')));
		echo $this->Form->input('Talk.track_id',array('empty'=>false, 'label'=>'What track best fits your talk?'));
		echo $this->Form->input('Talk.duration',$durationOptions);
		echo $this->Form->input('Talk.abstract', array(
							       'label' => __('Describe your talk, what you will cover, why attendees should attend, etc.'),
									   'after' => 'Examples of good ones are ' . $this->Html->link('here','http://2012.northeastphp.org')
									   )
				       );
		echo $this->Form->input('Talk.keywords', array('label'=>__('What keywords best describe your talk?'),'after'=>'Example: Javascript, PHP, Cloud'));
				
		echo $this->Form->input('Talk.userdefined1', $userdefined1Options );
				
		echo $this->Form->input('Speaker.bio', array('label'=>__('Tell us who you are, what you do, why you do. Be creative!')));
		echo $this->Form->input('Speaker.website', array('label'=>__('Do you have a website? Let us know.'),'after'=>__('Must include http://')));
		echo $this->Form->input('Speaker.twitter', array('label'=>__('Do you tweet?'),'after'=>__('Do not include the @')));
				
	?>
<?php echo $this->Form->end(__('Submit'));?>
</div>
