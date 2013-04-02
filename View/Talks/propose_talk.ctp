<?php
		$durationOptions = array(
			'options' => array(
				50  => '50 Minute Talk (Aug 17-18th)',
			),
			'value' => 50,
			'label'=>__('What sort of Talk is this?')
		);

		$userdefined1Options = array(
			'options' => array(
				'all' => 'All Skill Levels',
				'beginner'  => 'Beginner',
				'intermediate'  => 'Intermediate',
				'advanced' => 'Advanced',
			),
			'value' => 'all',
			'label'=>__('Which skill level is this Talk most appropriate for?')
		);

		$userdefined2Options = array(
		'after' => 'Example: <i>Larry is a writer, Web and software developer, trainer, instructor, speaker, and consultant.</i>',
			'label'=>__('Describe yourself in 140 characters or less.'),
			'limit'=>'140',
			'type'=>'textarea',
			'field'=>'Talk.userdefined2',
				'after' => '<span><span class="counter">no</span> characters so far</span>',
			'class' => 'word_count'
		);

		$userdefined3Options = array(
		'after' => 'Example: <i>Join me as I show you the tricks of the trade on "How to become a PHP Web Developer"!</i>',
		'class'=>'word_count',				
			'label'=>__('Describe your Talk in 140 characters or less.'),
			'limit'=>'140',
				'after' => '<span><span class="counter">no</span> characters so far</span>',
		);

		$userdefined4Options = array(
			'label'=>__('Photo or Glamor Shot URL'),
			'placeholder'=>null,
			'type'=>'http://',
			'after' => 'Provide us a URL to your photo, or an EMAIL address associated with your <a target="blank" href="http://gravatar.com">Gravatar</a>. Please make sure it is square 100px x 100px PNG file.',
		);
		
?>
<div class="talks form">
<?php echo $this->Form->create('Talk');?>

<h2><?php echo __('Propose a Talk'); ?></h2>
<p>We feel everyone has something to say. No matter what it is, we want to hear about it. Thank you for offering to speak at our conference.
We look forward to receiving your propopsal.</p>


	<?php	
		echo $this->Form->hidden('Talk.event_id');
		echo $this->Form->hidden('Talk.duration',$durationOptions);
		
		echo $this->Form->input('Talk.topic', array(
							    'placeholder'=> NULL,
							    'after'=>'Keep it short and sweet. Example: <i>How to Become a Web Developer</i>',
							    'label'=>__('What is the title of your Talk?')));
		echo $this->Form->input('Talk.abstract', array(
								'class'=>'word_count',				
							       'label' => __('Describe your Talk in approximately 300 characters.'),
								'after' => 'Example: <i>I will provide a blueprint for how one becomes a Web developer considering the current standards, technologies, and business environment of 2012 and ...</i>',
								'after' => '<span><span class="counter">no</span> characters so far</span>',
									   )
				       );
		
				
		echo $this->Form->input('Talk.userdefined1', $userdefined1Options );
		echo $this->Form->input('Talk.userdefined3', $userdefined3Options );
		echo $this->Form->input('Talk.track_id',array('empty'=>false, 'label'=>'Which Track best fits your Talk?'));
		echo $this->Form->input('Talk.keywords', array('label'=>__('What Keywords best describe your Talk?'),'after'=>'Separated by commas. Examples: <i>Javascript, PHP, Cloud, UX, jQuery, ...</i>'));
		echo $this->Form->input('Talk.comments', array('label'=>__('Comments? Questions? Requirements?'),'after'=>''));
				
				

		echo $this->Html->tag('h2', "Tell us a little about yourself");
		
		echo $this->Form->input('Speaker.first_name');
		echo $this->Form->input('Speaker.last_name');
		echo $this->Form->input('Speaker.email', array('after'=>'We may need to email you to ask questions about your proposal or your travel arrangements. We promise not to spam you.'));

		echo $this->Form->input('Speaker.github_username', array('after'=>"Ex: https://github.com/<strong>northeastphp</strong> <<-- Enter this part. <a href='//github.com' target='_blank'>github.com</a> for more information.",'type'=>'text','label'=>__('Enter enter your GitHub Username'),'placeholder'=>null));

		echo $this->Form->input('Talk.userdefined2', $userdefined2Options );
		echo $this->Form->input('Speaker.bio', array('label'=>'Biography', 'after'=>__('Have some fun with this, and don\'t be boring. Tell us who you are, what you do, why and how you do. Be creative! This will be used on our website when your Talk is chosen.')));
		echo $this->Form->input('Speaker.website', array('label'=>__('Do you have a Website or Blog? If so, provide a link so we can publish it!' ),'placeholder'=>null,'after'=>__('Please include http://')));
		echo $this->Form->input('Speaker.twitter', array('label'=>__('Do you tweet? If so, please provide your Twitter handle.'), 'after'=>'Ex: @nephp','placeholder'=>null));
		echo $this->Form->input('Speaker.joindin_id', array('after'=>"Ex: http://joind.in/user/view/<strong>18970</strong> <<-- Enter this code only. Check out <a href='//joind.in' target='_blank'>Joind.in</a> for more information.",'type'=>'text','label'=>__('Please enter your Joind.in User ID'),'placeholder'=>null));

		echo $this->Form->input('Talk.userdefined4', $userdefined4Options );
				
	?>
<?php echo $this->Form->end(__('Submit Your Proposal'));?>
</div>

<?php $this->append('sidebar'); ?>
<div>

				
		<h4>What is a Talk?</h4>
		<p>A Talk should be about 45 minutes long and can cover any topic within the tracks we have specified. You can involve the audience as much as you like, but the basic format is lecture-style. Feel free to incorporate time at the end for audience Q&A at the end.</p>
		<?php
			foreach( $tracks AS $key => $track ) {
				$talkLinks[] = $this->Html->link($track, array('action'=>'by_track', $key) );
			}
		
		echo $this->Html->nestedList( $talkLinks, array( 'class'=>'track-list' ) );
		
		?>
		<br />
		<p><a href='http://2012.nephp.org'>Examples of Talks</a> from last years conference.</p>
		<?php // echo $this->Html->image("http://www.ptc.com/images/product/training/instructor-led-training/tab1.png", array('style'=>'width:100%'));?>
		
		<h4>What is the duration of Talk?</h4>
		<p>A Talk is 45 minutes. If you need more time then perhaps you can
		<?php echo $this->Html->link('Propose a Workshop', array('action'=>'propose_workshop')); ?>
		or
		<?php echo $this->Html->link('Propose a Keynote', array('action'=>'propose_keynote')); ?>
		
		<h4>When are submissions due?</h4>
		<p>All submissions are due by <strong>April 30, 2013</strong>.
		
		<h4>When will I know if my Talk has been accepted?</H4>
		<p>Our board will review all proposals from March through May 2013. If you've submitted a proposal, we will let you know either way whether your Talk is accepted by <strong>May 31, 2013</strong>.</li>
		
		<h4>What should I expect if I am selected as a speaker?</h4>
		<p>We will be communicating with you on a semi-regular basis to make sure any questions are answered, you know what is expected of you in terms of your Talk, and you have the most up-to-date information on what is happening for the conference.
				
		<h4>Is there compensation involved for speakers?</h4>
		<p>One of the best things about the Northeast PHP conference is the community that brings the event together, creating a low-cost, high-quality event through fully volunteer effort. As a part of that, we ask our speakers to also volunteer their time.
		
		<p>This year, we hope to be able to cover a portion of travel costs for those who are not local to Boston. We can cover <strong>up to $600</strong> per speaker in approved travel expenses. Once you have been selected, we will explain the process for travel reimbursement.</p>
</div>
<?php $this->end(); ?>

<?php $code = "$(document).ready(function(){

/**
 * Character Counter for inputs and text areas
 */
$('.word_count').each(function(){
	// get current number of characters
	var length = $(this).val().length;
	// get current number of words
	//var length = $(this).val().split(/\b[\s,\.-:;]*/).length;
	// update characters
	$(this).parent().find('.counter').html( length + ' characters');
	// bind on key up event
	$(this).keyup(function(){
		// get new length of characters
		var new_length = $(this).val().length;
		// get new length of words
		//var new_length = $(this).val().split(/\b[\s,\.-:;]*/).length;
		// update
		$(this).parent().find('.counter').html( new_length + ' characters');
	});
});

});
";
						?>
<?php $this->Html->scriptBlock($code, array('inline' => false, 'defer'=>true, 'safe'=>false)); ?>