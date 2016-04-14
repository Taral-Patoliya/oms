<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/pending_tasks';

?>
<ul class='nav nav-pills'>
	<li<?php echo $checkSegment == '' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl); ?>" id='list'>
            <?php echo lang('pending_tasks_list'); ?>
        </a>
	</li>
	<?php if ($this->auth->has_permission('Pending_Tasks.Content.Create')) : ?>
	<li<?php echo $checkSegment == 'create' ? ' class="active"' : ''; ?>>
		<a href="<?php echo site_url($areaUrl . '/create'); ?>" id='create_new'>
            <?php echo lang('pending_tasks_new'); ?>
        </a>
	</li>
	<?php endif; ?>
</ul>