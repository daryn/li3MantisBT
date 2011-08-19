
<div class="section-container">
	<h2><?= $t( 'View project page account title' ) ?></h2>
	<div class="field-container">
		<span class="display-label"><span><?=$t('Project form name field label'); ?></span></span>
		<span class="display-value"><span><?=$project->name;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('Project form status field label');?></span></span>
		<span class="display-value"><span><?=$project->status;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('Project form enabled field label');?></span></span>
		<span class="display-value"><span><?=$project->enabled;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('Project form inherit global field label');?></span></span>
		<span class="display-value"><span><?=$project->inherit_global;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('Project form view status field label');?></span></span>
		<span class="display-value"><span><?=$project->view_status;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('Project form file path field label');?></span></span>
		<span class="display-value"><span><?=$project->file_path;?></span></span>
		<span class="label-style"></span>
	</div>
	<div class="field-container">
		<span class="display-label"><span><?=$t('Project form description field label');?></span></span>
		<span class="display-value"><span><?=$project->description;?></span></span>
		<span class="label-style"></span>
	</div>

	<span class="section-links">
		<span id="manage-project-link">
			<?=$this->html->link($t('Manage project edit link'), $this->url(array('Projects::edit', 'id' => $project->id))); ?>
		</span>
	</span>
</div>