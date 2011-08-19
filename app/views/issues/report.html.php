<div>
<?=$this->form->create(null, $reportFormOptions); ?>
<?php
# don't index bug report page
#html_robots_noindex();
#print_recently_visited();
?>
<?=$this->security->requestToken(array('id' => 'bug-report'));?>
<?=$this->form->field( 'm_id', array( 'type' => 'hidden', 'value' => $parentId));?>
<?=$this->form->field( 'project_id', array( 'type' => 'hidden', 'value' => $projectId));?>

<?=$t('Issue report form title');?>
<?php #	event_signal( 'EVENT_REPORT_BUG_FORM_TOP', array( $t_project_id ) ); ?>
<?php if ( in_array( 'category_id', $fields ) ) { ?>
		<?php $class = ( $settings->allow_no_category ? 'autofocus' : 'autofocus required' ); ?>
		<?=$this->form->field( 'category_id', array(
			'type' => 'select',
			'class' => $class,
			# the label needs a filter to print documentation link
			'label' => $t('Issue report category id field label'),
			#print_category_option_list( $f_category_id );
			'list' => array(),
			'value' => $issue->category_id));?>
		<?php
		#if ( $t_changed_project ) {
			#echo "[" . project_get_field( $t_bug->project_id, 'name' ) . "] ";
		#}
		?>
<?php } ?>

<?php if ( in_array( 'reproducibility', $fields ) ) { ?>
<?=$this->form->field( 'reproducibility', array(
	'type' => 'select',
	# the label needs a filter to print documentation link
	'label' => $t('Issue report reproducibility field label'),
	#print_enum_string_option_list('reproducibility', $f_reproducibility );
	'list' => array(),
	'value' => $issue->reproducibility));?>
<?php } ?>

<?php if ( in_array( 'severity', $fields ) ) { ?>
<?=$this->form->field( 'severity', array(
	'type' => 'select',
	# the label needs a filter to print documentation link
	'label' => $t('Issue report severity field label'),
	#print_enum_string_option_list( 'severity', $f_severity )
	'list' => array(),
	'value' => $issue->severity));?>
<?php } ?>

<?php if(in_array('priority', $fields)) { ?>
<?=$this->form->field( 'priority', array(
	'type' => 'select',
	# the label needs a filter to print documentation link
	'label' => $t('Issue report priority field label'),
	#print_enum_string_option_list( 'priority', $f_priority)
	'list' => array(),
	'value' => $issue->priority));?>
<?php } ?>

<?php if(in_array( 'due_date', $fields)) {
	$this->script(array(
		'jscalendar/calendar.js',
		'jscalendar/lang/calendar-en.js',
		'jscalendar/calendar-setup.js'));
	$this->html->style('calendar-blue.css');
?>
<?=$this->form->field( 'due_date', array(
	# the label needs a filter to print documentation link
	'label' => $t('Issue report due date field label'),
	'value' => $issue->due_date));?>
<?php } ?>

<?php if(in_array('platform', $fields) || in_array('os', $fields) || in_array('os_version', $fields)) { ?>
	<?php if($currentUser->profiles->count() > 0) { ?>
		<?=$this->form->field( 'profile_id', array(
			'type' => 'select',
			# the label needs a filter to print documentation link
			'label' => $t('Issue report profile field label'),
			'list' => $profilesList,
			'value' => $issue->profile_id));?>
	<?php } ?>
		<fieldset>
			<legend><?=$t('or_fill_in');?></legend>
			<?php
			# the label needs a filter to print documentation link
			$platformOptions = array('label' => $t('Issue report platform field label'), 'value' => $issue->platform);
			$osOptions = array('label' => $t('Issue report os field label'), 'value' => $issue->os);
			$osOptions = array('label' => $t('Issue report os version field label'), 'value' => $issue->os_version);
			if ( $settings->allow_freetext_in_profile_fields == OFF ) {
				$platformOptions['type'] = 'select';
				$platformOptions['list'] = array();
				# print_platform_option_list( $f_platform );
				$osOptions['type'] = 'select';
				$osOptions['list'] = array();
				#print_os_option_list( $f_os );
				$osVersionOptions['type'] = 'select';
				$osVersionOptions['list'] = array();
				#print_os_build_option_list( $f_os_build );
			} else {
				$platformOptions['class'] = 'autocomplete';
				$platformOptions['size'] = '32';
				$platformOptions['maxlength'] = '32';
				$osOptions['class'] = 'autocomplete';
				$osOptions['size'] = '32';
				$osOptions['maxlength'] = '32';
				$osVersionOptions['class'] = 'autocomplete';
				$osVersionOptions['size'] = '16';
				$osVersionOptions['maxlength'] = '16';
			}
			?>
			<?=$this->form->field( 'platform', $platformOptions );?>
			<?=$this->form->field( 'os', $osOptions );?>
			<?=$this->form->field( 'os_version', $osVersionOptions );?>
		</fieldset>
<?php } ?>

<?php if(in_array( 'product_version', $fields)) { ?>
<?=$this->form->field( 'product_version', array(
	'type' => 'select',
	# the label needs a filter to print documentation link
	'label' => $t('Issue report product version field label'),
	#print_version_option_list( $f_product_version, $t_project_id, $t_product_version_released_mask )
	'list' => array(),
	'value' => $issue->product_version));?>
<?php } ?>

<?php if(in_array( 'build', $fields)) { ?>
<?=$this->form->field( 'build', array(
	# the label needs a filter to print documentation link
	'label' => $t('Issue report build field label'),
	'size' => 32,
	'maxlength' => 32,
	'value' => $issue->build));?>
<?php } ?>

<?php if(in_array( 'handler_id', $fields)) { ?>
<?=$this->form->field( 'handler_id', array(
	'type' => 'select',
	# the label needs a filter to print documentation link
	'label' => $t('Issue report handler id field label'),
	#php print_assign_to_option_list( $f_handler_id )
	'list' => array(),
	'value' => $issue->handler_id));?>
<?php } ?>

<?php if(in_array( 'target_version', $fields)) { ?>
<?=$this->form->field( 'target_version', array(
	'type' => 'select',
	# the label needs a filter to print documentation link
	'label' => $t('Issue report target version field label'),
	#print_version_option_list()
	'list' => array(),
	'value' => $issue->target_version));?>
<?php } ?>

<?php #event_signal( 'EVENT_REPORT_BUG_FORM', array( $t_project_id ) ) ?>

<?=$this->form->field( 'summary', array(
	# the label needs a filter to print documentation link
	'type' => 'textarea',
	'class' => 'required',
	'size' => '105',
	'maxlength' => '128',
	'label' => $t('Issue report summary field label'),
	'value' => $issue->summary));?>

<?=$this->form->field( 'description', array(
	# the label needs a filter to print documentation link
	'type' => 'textarea',
	'class' => 'required',
	'rows' => '10',
	'cols' => '80',
	'label' => $t('Issue report description field label'),
	'value' => $issue->description));?>

<?php if(in_array( 'steps_to_reproduce', $fields)) { ?>
<?=$this->form->field( 'steps_to_reproduce', array(
	# the label needs a filter to print documentation link
	'type' => 'textarea',
	'rows' => '10',
	'cols' => '80',
	'label' => $t('Issue report steps to reproduce field label'),
	'value' => $issue->steps_to_reproduce));?>
<?php } ?>

<?php if(in_array( 'additional_info', $fields)) { ?>
<?=$this->form->field( 'additional_info', array(
	# the label needs a filter to print documentation link
	'type' => 'textarea',
	'rows' => '10',
	'cols' => '80',
	'label' => $t('Issue report additional info field label'),
	'value' => $issue->additional_info));?>
<?php }
/*
	$t_custom_fields_found = false;
	$t_related_custom_field_ids = custom_field_get_linked_ids( $t_project_id );

	foreach( $t_related_custom_field_ids as $t_id ) {
		$t_def = custom_field_get_definition( $t_id );
		if( ( $t_def['display_report'] || $t_def['require_report']) && custom_field_has_write_access_to_project( $t_id, $t_project_id ) ) {
			$t_custom_fields_found = true;
?>
			<?php if($t_def['require_report']) {?><span class="required">*</span><?php } ?>
			<?php if ( $t_def['type'] != CUSTOM_FIELD_TYPE_RADIO && $t_def['type'] != CUSTOM_FIELD_TYPE_CHECKBOX ) { ?>
			<label for="custom_field_<?php echo string_attribute( $t_def['id'] ) ?>"><?php echo string_display( lang_get_defaulted( $t_def['name'] ) ) ?></label>
			<?php } else echo string_display( lang_get_defaulted( $t_def['name'] ) ) ?>
			<?php print_custom_field_input( $t_def, ( $f_master_bug_id === 0 ) ? null : $f_master_bug_id ) ?>
<?php
		}
	} # foreach( $t_related_custom_field_ids as $t_id )

?>
<?php if ( $tpl_show_attachments ) { // File Upload (if enabled)
	$maxFileSize = (int)min( ini_get_number( 'upload_max_filesize' ), ini_get_number( 'post_max_size' ), config_get( 'max_file_size' ) );
?>
	<label for="file"><?=$t('upload_file');?></label><br />
	<span class="small"><?=$t('max_file_size_label');?><?=$t('word_separator');?><?=number_format( $t_max_file_size/1000 );?>k</span>

	<input type="hidden" name="max_file_size" value="<?=$maxFileSize;?>" />
	<input id="file" name="file" type="file" size="60" />
<?php }*/ ?>

<?php if(in_array( 'view_state', $fields)) { ?>
<?=$this->form->field( 'view_state', array(
	# the label needs a filter to print documentation link
	'type' => 'radio',
	'label' => $t('Issue report view state public field label'),
	'value' => VS_PUBLIC));?>
<?=$this->form->field( 'view_state', array(
	# the label needs a filter to print documentation link
	'type' => 'radio',
	'label' => $t('Issue report view state private field label'),
	'value' => VS_PRIVATE));?>
<?php }

# Relationship (in case of cloned bug creation...)
if( $masterBugId > 0 ) { ?>
	<?=$t('relationship_with_parent');?>
	<?php relationship_list_box( /* none */ -2, "rel_type", false, true ) ?>
	<strong><?=$t('bug');?> <?=bug_format_id( $masterBugId );?></strong>

	<?=$t('copy_from_parent');?>
	<label><input type="checkbox" id="copy_notes_from_parent" name="copy_notes_from_parent" /><?=$t('copy_notes_from_parent');?></label>
	<label><input type="checkbox" id="copy_attachments_from_parent" name="copy_attachments_from_parent" /> <?=$t('copy_attachments_from_parent');?></label>
<?php } ?>
<?php #print_documentation_link( 'report_stay' ) ?>
<?=$this->form->field(
	'report_stay',
	array(
		'type' => 'checkbox',
		'label' => $t( 'Issue report form report stay field label' ),
	));?>

	<span class="required"> * <?=$t('required');?></span>
	<?=$this->form->submit( $t('Issue report submit button label') ); ?>
	<?=$this->form->end(); ?>
</div>