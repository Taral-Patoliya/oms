<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Pending_Tasks.Settings.Delete');
$can_edit		= $this->auth->has_permission('Pending_Tasks.Settings.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
	<h3>
		<?php echo lang('pending_tasks_area_title'); ?>
	</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th><?php echo lang('pending_tasks_field_created_by'); ?></th>
					<th><?php echo lang('pending_tasks_field_created_on'); ?></th>
					<th><?php echo lang('pending_tasks_field_title'); ?></th>
					<th><?php echo lang('pending_tasks_field_content'); ?></th>
					<th><?php echo lang('pending_tasks_field_status'); ?></th>
					<th><?php echo lang('pending_tasks_column_created'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('pending_tasks_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/settings/pending_tasks/edit/' . $record->id, '<span class="icon-pencil"></span> ' .  $record->created_by); ?></td>
				<?php else : ?>
					<td><?php e($record->created_by); ?></td>
				<?php endif; ?>
					<td><?php e($record->created_on); ?></td>
					<td><?php e($record->title); ?></td>
					<td><?php e($record->content); ?></td>
					<td><?php e($record->status); ?></td>
					<td><?php e($record->created_on); ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('pending_tasks_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>