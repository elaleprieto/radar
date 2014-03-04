<div class="row">
	<div class="col-sm-12">
		<h2><?php echo __('Users'); ?></h2>
		<table class="table">
			<thead>
				<tr>
						<th><?php echo $this->Paginator->sort('username'); ?></th>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><?php echo $this->Paginator->sort('email'); ?></th>
						<th><?php echo $this->Paginator->sort('created'); ?></th>
						<th><?php echo $this->Paginator->sort('active'); ?></th>
						<th><?php echo $this->Paginator->sort('confirmed'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
						<td class="text-center">
							<?php 
							if($user['User']['active']) echo '<span class="glyphicon glyphicon-ok"></span>';
							?>
							&nbsp;
						</td>
						<td class="text-center">
							<?php 
							if($user['User']['confirmed']) echo '<span class="glyphicon glyphicon-ok"></span>';
							?>
							&nbsp;
						<td class="actions">
							<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
							
							<?php
							if($user['User']['active']):
								echo $this->Form->postLink(__('Inactive')
									, array('action' => 'inactive', $user['User']['id'])
										, null
										, __('Are you sure you want to inactive the user %s?', $user['User']['username']
									)
								);
							else:
								echo $this->Form->postLink(__('Active')
									, array('action' => 'active', $user['User']['id'])
										, null
										, __('Are you sure you want to active the user %s?', $user['User']['username']
									)
								);
							endif;
							?>
							<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 text-center">
		<!-- Paginación -->
		<p>
			<?php
			echo $this->Paginator->counter(array(
			'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
			?>
		</p>
		<div class="paging">
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</div>
	</div>
</div>
