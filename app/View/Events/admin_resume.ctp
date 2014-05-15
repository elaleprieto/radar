<?php 
// debug($events, $showHtml = null, $showFrom = true)
?>

<div class="row">
	<div class="col-sm-12">
		<p><em><?php echo __('Only events that have not yet finish are listed') ?></em></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<table class="table">
			<thead>
				<tr>
					<th><?php echo __('Date Start') ?></th>
					<th><?php echo __('Date End') ?></th>
					<th><?php echo __('Title') ?></th>
					<th><?php echo __('Address') ?></th>
					<th><?php echo __('User') ?></th>
					<th><?php echo __('Actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($events as $key => $event) : ?>
					<tr>
						<td><?php echo $event['Event']['date_start'] ?></td>
						<td><?php echo $event['Event']['date_end'] ?></td>
						<td><?php echo $event['Event']['title'] ?></td>
						<td><?php echo $event['Event']['address'] ?></td>
						<td><?php echo $this->Html->link($event['User']['username'], array('controller'=>'user', 'action'=>'view', $event['User']['id'])) ?></td>
						<td>
							<?php echo $this->Html->link(__('Edit'), array('action'=>'edit', $event['Event']['id'])) ?>
							<?php echo $this->Html->link(__('Delete')
								, array('action'=>'delete', $event['Event']['id']), null, __('Are you sure you want to delete the event')) ?>
						</td>

					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>