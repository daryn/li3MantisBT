<?php
$this->title( $t('Edit Project page heading title' ) );

?>
<div id="manage-project-edit-div" class="form-container">
<?=$this->form->create(null, array('id' => $formId)); ?>
	<?=$this->security->requestToken(array('id' => $formId));?>
	<fieldset>
		<legend><span><?= $t( $formTitle ); ?></span></legend>
		<?=$this->form->field( 'name', array(
			'label' => $t('Project form name field label'),
			'value' => $project->name));?>
		<?=$this->form->field( 'status', array(
			'type' => 'select',
			'label' => $t('Project form status field label'),
			'list' => array(),
			'value' => $project->status));?>
		<?=$this->form->field(
			'enabled',
			array(
				'type' => 'checkbox',
				'label' => $t( 'Project form enabled field label' ),
				'checked' => 'checked'
			));?>
		<?=$this->form->field(
			'inherit_global',
			array(
				'type' => 'checkbox',
				'label' => $t( 'Project form inherit global field label' ),
				'checked' => $project->inherit_global
			));?>
		<?=$this->form->field( 'view_status', array(
			'type' => 'select',
			'label' => $t('Project form view status field label'),
			'list' => array(),
			'value' => $project->view_status));?>
		<?=$this->form->field('file_path', array(
			'value'=>$project->file_path,
			'label' => $t('Project form file path field label')));?>
		<?=$this->form->field( 'description', array(
			'type' => 'textarea',
			'label' => $t('Project form description field label'),
			'content' => $project->description));?>
		<?=$this->form->submit( $t($formSubmitButton) ); ?>
	</fieldset>
<?=$this->form->end(); ?>
</div>

<div id="manage-project-subprojects-div" class="form-container">
	<h2><?=$t( 'Subprojects section heading title' ) ?></h2>
	<?=$this->html->link($t('Subprojects create new subproject link'), 'projects/create/parent/' . $project->id ); ?>
</div>

<?php if( $categories ) { ?>
<div id="categories" class="form-container">
	<h2><?=$t( 'Project categories list heading title' ) ?></h2>
	<table cellspacing="1" cellpadding="5" border="1"><?php
#		$t_categories = category_get_all_rows( ALL_PROJECTS );
		if ( $categories->count() > 0 ) { ?>
		<tr class="row-category">
			<td><?=$t( 'Project categories category field column heading' ) ?></td>
			<td><?=$t( 'Project categories assigned to field column heading' ) ?></td>
			<td class="center"><?=$t( 'Project categories actions column heading' ) ?></td>
		</tr><?php
		}

	foreach ( $categories as $category ) {
#		$t_id = $t_category['id'];

#		$t_name = $t_category['name'];
#		if ( NO_USER != $t_category['user_id'] && user_exists( $t_category['user_id'] )) {
#			$t_user_name = user_get_name( $t_category['user_id'] );
#		} else {
#			$t_user_name = '';
#		} ?>

		<tr <?php #echo helper_alternate_class() ?>>
			<td><?=$category->id; ?></td>
			<?php #echo string_display( category_full_name( $t_category['id'], false ) )  ?>
			<td><?=$category->user_id; ?></td>
			<?php #echo string_display_line( $t_user_name ) ?>
			<td class="center">
				<?php
#					$t_id = urlencode( $t_id );
#					$t_project_id = urlencode( ALL_PROJECTS );

					#print_button( "manage_proj_cat_edit_page.php?id=$t_id&project_id=$t_project_id", lang_get( 'edit_link' ) );
				?>
					<?=$t('Project categories list action edit link'); ?>
					&#160;
					<?=$t('Project categories list action delete link'); ?>
					<?php #print_button( "manage_proj_cat_delete.php?id=$t_id&project_id=$t_project_id", lang_get( 'delete_link' ) ); ?>
			</td>
		</tr><?php
	} # end for loop ?>
	</table>

	<form method="post" action="project/category/add">
		<fieldset>
			<?php #echo form_security_field( 'manage_proj_cat_add' ) ?>
			<input type="hidden" name="project_id" value="<?php echo ALL_PROJECTS ?>" />
			<input type="text" name="name" size="32" maxlength="128" />
			<input type="submit" class="button" value="<?= $t( 'Project add category form submit button' ) ?>" />
		</fieldset>
	</form>
<?php } ?>
</div>