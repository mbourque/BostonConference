<?php

echo $this->Form->create('Ticket');

echo '<h3>'.__('Organization (optional)').'</h3>';

echo $this->Form->input('organization',array('label' => false));

echo '<h3>'.__('Name for badges').'</h3>';

foreach( $ticketOptions as $ticketOption )
{
	for ( $i = 0; $i < $ticketOption['TicketOption']['quantity']; $i++ ) {
		echo $this->Form->input(
			'badge_name_'.$ticketOption['TicketOption']['id'].'_'.((int)$i),
			array(
				'type' => 'text',
				'label' => __('Ticket #%d: %s',$i+1,$ticketOption['TicketOption']['label']),
			)
		);
	}
}

echo '<h3>'.__('Total Price').'</h3>';

echo '<p>';

if ( $totalPrice > 0 )
	echo '$'.number_format($totalPrice,2);
else
	echo __('Free');

echo '</p>';

if ( $totalPrice > 0 ) {
	echo $this->Form->submit('Order Now',array(
		'after' => $this->Html->image('credit_cards-trans.png')
	));
} else {
	echo $this->Form->submit('Continue',array(
		'after' => $this->Html->image('BostonConference.credit_cards-trans.png')
	));
}
echo $this->Form->end();

?>
