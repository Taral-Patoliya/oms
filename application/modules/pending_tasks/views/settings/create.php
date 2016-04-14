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
            

            <?php // Change the values in this array to populate your dropdown as required
                $options = array(
                    11 => 11,
                );
                echo form_dropdown(array('name' => 'created_by', 'required' => 'required'), $options, set_value('created_by', isset($pending_tasks->created_by) ? $pending_tasks->created_by : ''), lang('pending_tasks_field_created_by') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('created_on') ? ' error' : ''; ?>">
                <?php echo form_label(lang('pending_tasks_field_created_on'), 'created_on', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='created_on' type='text' name='created_on'  value="<?php echo set_value('created_on', isset($pending_tasks->created_on) ? $pending_tasks->created_on : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('created_on'); ?></span>
                </div>
            </div>

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
                );
                echo form_dropdown(array('name' => 'status', 'required' => 'required'), $options, set_value('status', isset($pending_tasks->status) ? $pending_tasks->status : ''), lang('pending_tasks_field_status') . lang('bf_form_label_required'));
            ?>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('pending_tasks_action_create'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/settings/pending_tasks', lang('pending_tasks_cancel'), 'class="btn btn-warning"'); ?>
            
        </fieldset>
    <?php echo form_close(); ?>
</div>