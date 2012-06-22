<?php if ( count( $tickets ) > 0 ) : ?>
<h2><?php echo __('Your Tickets');?></h2>
<p><?php echo __('You are registered for the conference. Your tickets are below.');?></p>
<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th><?php echo __('Package'); ?></th>
			<th><?php echo __('Badge Name');?></th>
			<th><?php echo __('Organization');?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $tickets as $ticket ) : ?>
		<tr>
			<td><?php echo $ticket['TicketOption']['label']; ?></td>
			<td><?php echo $ticket['Ticket']['badge_name']; ?></td>
			<td><?php echo $ticket['Ticket']['organization']; ?></td>
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
<h2><?php echo __('Buy Tickets');?></h2>
<table cellpadding="0" cellspacing="0">
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
			<td><?php echo $ticketOption['TicketOption']['label']; ?></td>
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
	echo $this->Form->end( $availableToBuy ? $buttonLabel : null );
} else {
?>
<p><?php echo __('There are no ticket options available yet. Please check back later.'); ?></p>
<?php
}
?>
