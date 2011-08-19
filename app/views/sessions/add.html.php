<?php
$self = $this;
$errors = function() use ($self, $errors) {
	if( is_array( $errors ) && count($errors) > 0 ) {
		return $self->html->htmlList( $errors, array(
			'block'=>array('class' => 'important-msg' ),
			'list'=>array('id'=>'login-error-list')));
	} else {
		return '';
	}
};
$warnings = function() use ($self, $warnings) {
	if( is_array( $warnings) && count($warnings) > 0 ) {
		return $self->html->htmlList( $warnings, array(
			'block'=>array('class' => 'important-msg' ),
			'list'=>array('id'=>'login-warning-list')));
	} else {
		return '';
	}
};
?>

<?php echo $errors();?>
<?php #=$t('Login page form greeting');?>
<div id="login-div" class="form-container">
<?=$this->form->create(null, array('id' => 'login-form')); ?>
	<fieldset>
		<legend><span><?= $t('Login page form title');?></span></legend>
		<?php if ( $returnUrl ) { ?>
		<?=$this->form->field( 'returnUrl', array( 'type' => 'hidden', 'value' => $returnUrl ));?>
		<?php } ?>

		<?=$this->form->field( 'username', array(
			'label' => $t('Login page form username field label'),
			'maxlength' => DB_FIELD_SIZE_USERNAME,
			'size' => 32));?>

		<?=$this->form->field( 'password', array(
				'type'=>'password',
				'label' => $t('Login page form password field label'),
				'maxlength' => DB_FIELD_SIZE_PASSWORD,
				'size' => 32 ));?>

		<?=$this->form->field( 'perm_login', array(
			'label' => $t('Login page form remember session label'),
			'type' => 'checkbox'));?>

		<?=$this->form->field( 'secure_session', array(
			'label' => $t('Login page form secure session label'),
			'title' => $t('Login page form secure session message'),
			'type' => 'checkbox'));?>

		<?=$this->form->submit($t('Login page form submit button label')); ?>
	</fieldset>
<?=$this->form->end(); ?>
</div>
<?php echo $warnings();?>