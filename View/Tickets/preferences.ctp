<div class="ticketAnswers form">
<h2>Ticket Preferences</h2>
<p>Use the form below to specify preferences for all of the tickets you purchased. Note: You can come back here to change these later.</p>
<?php echo $this->Form->create('TicketAnswer');?>
	<?php

	$counter = 0;
	foreach( $tickets AS $ticket ) {

		foreach( $ticketQuestions AS $key => $question ) {

			$options = array();

			if( !empty($question['TicketQuestion']['options']) ) {
				$options['options'] = array_map('trim',explode("\r",$question['TicketQuestion']['options']));
				$options['options'] = array_combine( $options['options'], $options['options'] );
			} else {
				$options['options'] = array();
			}

			//$options['legend'] = false;
			//$options['label'] = $question['TicketQuestion']['label'];
			$options['label'] = false;
			$options['div'] = false;
			$options['value'] = $ticket['TicketAnswer'][$key]['answer'];

			//debug( $options['options'] );
			$map[0] = array('type'=>'textarea');
			$map[1] = array('type'=>'checkbox', 'label'=>key($options['options']));
			$map[2] = array('type'=>'radio','label'=>true, 'value'=>key($options['options']),'legend'=>$options['label']);
			$map[3] = array('type'=>'select');
			$type = $map[(min(sizeof($options['options']),sizeof($map)-1))];
			$options = array_merge( $options, $type );

			$row[$key]['question'] = $this->Html->tag('strong',$question['TicketQuestion']['label']);
			$row[$key]['question'] .= $this->Html->tag('br');
			$row[$key]['question'] .= $question['TicketQuestion']['description'];

			$row[$key]['answer'] = $this->Form->hidden("{$counter}.ticket_id", array('value'=>$ticket['Ticket']['id']));
			$row[$key]['answer'] .= $this->Form->hidden("{$counter}.ticket_question_id", array('value'=>$question['TicketQuestion']['id']));
			$row[$key]['answer'] .= $this->Form->input("{$counter}.answer", $options);

			$counter++;

		}

		echo $this->Html->tag('div', null, array('class'=>'badge'));
		echo $this->Html->tag('h3', $ticket['Ticket']['badge_name']);
		echo $this->Html->tag('table',$this->Html->tableCells( $row ));
		echo $this->Html->tag('/div');

	}
	?>
<?php echo $this->Form->end(__('Save'));?>
</div>
