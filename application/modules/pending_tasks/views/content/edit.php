<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('pending_tasks_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($pending_tasks->id) ? $pending_tasks->id : '';

?>
<div class='admin-box'>
    <h3>Pending Tasks</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            <div class="control-group<?php echo form_error('title') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pending_tasks_field_title') . lang('bf_form_label_required'), 'title', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='title' type='text' required='required' name='title' maxlength='256' value="<?php echo set_value('title', isset($pending_tasks->title) ? $pending_tasks->title : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('title'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('content') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pending_tasks_field_content'), 'content', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo form_textarea(array('name' => 'content', 'id' => 'content', 'rows' => '5', 'cols' => '80', 'value' => set_value('content', isset($pending_tasks->content) ? $pending_tasks->content : ''))); ?>
                    <span class='help-inline'><?php echo form_error('content'); ?></span>
                </div>
            </div>

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    0 => "Pending",
                    1  => "Done"
                );
                echo form_dropdown(array('name' => 'status', 'required' => 'required'), $options, set_value('status', isset($pending_tasks->status) ? $pending_tasks->status : ''), lang('pending_tasks_field_status') . lang('bf_form_label_required'));
            ?>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('pending_tasks_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/content/pending_tasks', lang('pending_tasks_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Pending_Tasks.Content.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('pending_tasks_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('pending_tasks_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>