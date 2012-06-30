<?php if ( count( $tickets ) > 0 ) : ?>
<h2><?php echo __('Your Tickets');?></h2>
<p><?php echo __('You are registered for the conference. Your tickets are below.');?></p>
<table>
	<thead>
		<tr>
			<th><?php echo __('Badge Name');?></th>
			<th><?php echo __('Organization');?></th>
			<th><?php echo __('Package'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $tickets as $ticket ) : ?>
		<tr>
			<td><?php echo $ticket['Ticket']['badge_name']; ?></td>
			<td><?php echo $ticket['Ticket']['organization']; ?></td>
			<td><span class='ticket-option'><?php echo $ticket['TicketOption']['label']; ?></span>
			<span class='ticket-description'><?php echo h($ticket['TicketOption']['description']); ?></span></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>


<?php if ( count( $ticketOptions ) > 0 ) { ?>
<?php
	echo $this->Form->create('Ticket');
	$availableToBuy = false;
?>
<h2><?php echo ( count( $tickets ) <= 0 ) ? __('Buy Tickets') : __('Buy More Tickets');?></h2>
<table>
	<thead>
		<tr>
			<th><?php echo __('Package'); ?></th>
			<th><?php echo __('Price');?></th>
			<th><?php echo __('Quantity');?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($ticketOptions as $ticketOption): ?>
		<tr>
			<td><span class='ticket-option'><?php echo h($ticketOption['TicketOption']['label']); ?></span>
			<span class='ticket-description'><?php echo h($ticketOption['TicketOption']['description']); ?></span></td>
			<td><?php
				if ( $ticketOption['TicketOption']['price'] > 0 )
					echo '$'.number_format($ticketOption['TicketOption']['price'],2);
				else
					echo __('Free');
				?>
			</td>
			<td>
			<?php
				if ( $ticketOption['TicketOption']['available'] !== null )
					$canBuy = $ticketOption['TicketOption']['available']-$ticketOption['TicketOption']['ticket_count'];
				else
					$canBuy = 999;

				if ( $ticketOption['Event']['available_tickets'] !== null )
					$canBuy = min($ticketOption['Event']['available_tickets']-$ticketOption['Event']['ticket_count'],$canBuy);

				if ( $canBuy <= 0 ) {
					echo __('Sold Out');
				} else {
					$availableToBuy = true;
					$options = array();
					for ( $i=0; $i <= $canBuy && $i <= 10; $i++ ) {
						$options[] = number_format($i,0);
					}

					echo $this->Form->select('quantity.'.$ticketOption['TicketOption']['id'],$options,array('empty'=>false));
				}
			?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php
	$buttonLabel = ( count( $tickets ) > 0 ) ? __('Buy More Tickets') : __('Continue');

	if( $availableToBuy ) {

		echo $this->Form->submit($buttonLabel, array(
			'after' => $this->Html->image('BostonConference.credit_cards-trans.png')
		));
	}

	echo $this->Form->end();
} else {
?>
<p><?php echo __('There are no ticket options available yet. Please check back later.'); ?></p>
<?php
}
?>
