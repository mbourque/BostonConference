<?php
	$this->Html->css('/boston_conference/css/print.css', null, array('media'=>'print', 'inline'=>false));
?>
<h2><?php echo __('You are registered for').' '.$event['Event']['name']; ?></h2>

<div class='qr-code'>
	<?php echo $this->Html->image('http://chart.apis.google.com/chart?cht=qr&chs=500x500&choe=UTF-8&chld=H&chl=http://northeastphp.org/tickets/validate/'.$user['hash']);?>
</div>
<dl>
	<dt>Event:</dt>
		<dd><?php echo $event['Event']['name'];?></dd>
	<dt>Dates:</dt>
		<?php

			$event_dates = $this->Time->format('F jS, Y',$event['Event']['start_date'] );
			if( $event['Event']['start_date'] < $event['Event']['end_date'] ) {
				$end_date = $this->Time->format('F jS, Y',$event['Event']['end_date'] );
				$event_dates = "{$event_dates} - {$end_date}";
			}

		?>
		<dd><?php echo $event_dates;?> (Visit the website for schedule and time)</dd>
	<dt>Venue</dt>
		<dd><?php echo $event['Venue']['name'];?>, <?php echo $event['Venue']['address'];?></dd>
</dl>
<dl>
	<dt>Sold to:</dt>
		<dd><?php echo $user['name'];?></dd>
	<dt>Email:</dt>
		<dd><?php echo $user['email'];?></dd>
	<dt>Phone:</dt>
		<dd><?php echo $user['phone'];?></dd>
	<dt>Paid:</dt>
		<dd>Paid $<?php echo $sale['subtotal'];?></dd>
</dl>

<table>
	<thead>
		<tr>
			<th>Qty</th>
			<th>Package</th>
			<th>Organization</th>
			<th>Badge Name</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $tickets as $ticket ) : ?>
		<tr>
			<td><?php echo $ticket['Ticket']['paid'];?></td>
			<td><?php echo $ticket['TicketOption']['label'];?></td>
			<td><?php echo $ticket['Ticket']['badge_name'];?></td>
			<td><?php echo $ticket['Ticket']['organization'];?></td>
			<td><?php echo $ticket['TicketOption']['price'];?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
	<tfoot class='totalRow'>
		<tr>
			<td colspan='2' class='left'><?php echo $sale['count'];?> Tickets</td>
			<td colspan='3' class='right'>Total Paid $<?php echo number_format($sale['subtotal'],2);?></td>
		</tr>
	</tfoot>
</table>
<?php echo $this->Html->link('Print', 'javascript:void(0)', array('class'=>'button','onClick'=>'window.print();return(false)'));?>
