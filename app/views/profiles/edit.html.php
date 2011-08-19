<?php
if( $globalProfiles ) {
	$formId = $t('manage-profile-create-form');
	$formTitle = $t('Manage profile create form title');
	$formSubmitButton = $t('Manage profile create form submit button label');
	$actionFormId = $t('manage-profile-action-form');
	$actionFormTitle = $t('Manage profile action form title');
	$actionFormSubmitButton = $t('Manage profile action form submit button label');
} else {
	$formId = $t('account-profile-create-form');
	$formTitle = $t('Account profile create form title');
	$formSubmitButton = $t('Account profile create form submit button label');
	$actionFormId = $t('account-profile-action-form');
	$actionFormTitle = $t('Account profile action form title');
	$actionFormSubmitButton = $t('Account profile action form submit button label');
}
?>

<div id="profile-div" class="form-container">
	<?=$this->form->create(null, array('id' => $formId));?>
		<?=$this->security->requestToken(array('id' => $formId));?>
		<?=$this->form->field('action', array('type' => 'hidden', 'value' => 'update'));?>
		<?=$this->form->field('user_id', array('type' => 'hidden', 'value' => $userId));?>
		<?=$this->form->field('profile_id', array('type' => 'hidden', 'value' => $profile->id));?>
		<fieldset class="has-required">
			<legend><span><?= $t( $formTitle ); ?></span></legend>
			<?=$this->form->field( 'platform', array(
				'label' => array($t('Profile edit form platform field label') => array('class' => 'required')),
				'maxlength' => 32,
				'size' => 32,
				'value' => $profile->platform));?>

			<?=$this->form->field( 'os', array(
				'label' => array($t('Profile edit form os field label') => array('class'=>'required')),
				'maxlength' => 32,
				'size' => 32,
				'value' => $profile->os));?>

			<?=$this->form->field( 'os_build', array(
				'label' => array($t('Profile edit form os build field label')=>array('class'=>'required')),
				'maxlength' => 16,
				'size' => 16,
				'value' => $profile->os_build));?>

			<?=$this->form->field( 'additional_description', array(
				'type' => 'textarea',
				'label' => $t('Profile edit form additional description field label'),
				'cols' => 60,
				'rows' => 8,
				'value' => $profile->description));?>

			<?=$this->form->submit($t($formSubmitButton)); ?>
		</fieldset>
	<?=$this->form->end(); ?>
</div>