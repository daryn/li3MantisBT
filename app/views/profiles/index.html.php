
<div id="profile-actions-div" class="form-container">
	<?=$this->form->create(null, array('id' => $actionFormId, 'action'=>'profile/edit'));?>
		<?=$this->security->requestToken(array('id' => $actionFormId));?>
		<fieldset>
			<legend><span><?= $t($actionFormTitle); ?></span></legend>

			<?=$this->form->field( 'actions', array(
				'type' => 'radio',
				'label' => $t('Profile action form edit field label'),
				'value' => 'edit'));?>

			<?=$this->form->field( 'actions', array(
				'type' => 'radio',
				'label' => $t('Profile action form default field label'),
				'value' => 'default'));?>

			<?=$this->form->field( 'actions', array(
				'type' => 'radio',
				'label' => $t('Profile action form delete field label'),
				'value' => 'delete'));?>

			<?=$this->form->field( 'profile_id', array(
				'type' => 'select',
				'list' => $profiles,
				'label' => $t('Profile action form profile id field label'),
				'value' => $profile->description));?>
			<?=$this->form->submit( $t($actionFormSubmitButton) ); ?>
		</fieldset>
	<?=$this->form->end(); ?>
</div>