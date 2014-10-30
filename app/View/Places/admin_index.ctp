<?php //debug($places) ?>

<?php echo $this->Html->css('places/admin_index'); ?>

<div class="places index">
	<h2>
		<?php echo __('Places'); ?>
		<?php echo $this->Html->link(__('New Place'), array('action' => 'add'), array('class' => 'btn btn-verde pull-right')); ?>
	</h2>
	
	<table class="table">
		<thead>
			<tr>
				<!-- <th><?php echo $this->Paginator->sort('id'); ?></th> -->
				<th class="text-center"><?php echo $this->Paginator->sort('classification'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<!-- <th><?php echo $this->Paginator->sort('sort'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('lat'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('long'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('created'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('modified'); ?></th> -->
				<th><?php echo $this->Paginator->sort('description'); ?></th>
				<th><?php echo $this->Paginator->sort('address'); ?></th>
				<!-- <th><?php echo $this->Paginator->sort('phone'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('email'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('website'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('image'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('accessibility_parking'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('accessibility_ramp'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('accessibility_equipment'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('accessibility_signage'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('accessibility_braille'); ?></th> -->
				<!-- <th><?php echo $this->Paginator->sort('user_id'); ?></th> -->
				<th><?php echo $this->Paginator->sort('User.name', __('Created by')); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($places as $place): ?>
				<tr>
					<!-- <td><?php echo h($place['Place']['id']); ?>&nbsp;</td> -->
					<td>
						<?php
							foreach ($place['Classification'] as $classification) :
								echo $this->Html->div('classification classification-center', '&nbsp;', array(
									'style' => 'background-color:' . $classification['color'],
									'title' => $classification['name']
								));
							endforeach;
						?>
						&nbsp;
					</td>
					<td><?php echo h($place['Place']['name']); ?>&nbsp;</td>
					<!-- <td><?php echo h($place['Place']['sort']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['lat']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['long']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['created']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['modified']); ?>&nbsp;</td> -->
					<td><?php echo h($place['Place']['description']); ?>&nbsp;</td>
					<td><?php echo h($place['Place']['address']); ?>&nbsp;</td>
					<!-- <td><?php echo h($place['Place']['phone']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['email']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['website']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['image']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['accessibility_parking']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['accessibility_ramp']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['accessibility_equipment']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['accessibility_signage']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['accessibility_braille']); ?>&nbsp;</td> -->
					<!-- <td><?php echo h($place['Place']['user_id']); ?>&nbsp;</td> -->
					<td><?php echo h($place['User']['name']); ?>&nbsp;</td>
					<td class="actions">
						<?php 
						 echo $this->Html->link(__('View'), array(
							 'action' => 'view',
							 $place['Place']['id']
						 ));
						?>
						<?php echo $this->Html->link(__('Edit'), array(
								'action' => 'edit',
								$place['Place']['id']
							));
						?>
						<?php echo $this->Form->postLink(__('Delete'), array(
								'action' => 'delete',
								$place['Place']['id']
							), null, __('Are you sure you want to delete %s?', $place['Place']['name']));
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<p class="text-center">
		<?php
			echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
		?>
	</p>
	<div class="paging text-center">
		<?php
			echo $this->Paginator->prev('< ' . __('previous') . ' ', array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ' | '));
			echo $this->Paginator->next(' ' . __('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
</div>
