
<div id="manage-user-create-div" class="form-container">
<?=$this->form->create(null, array('id' => $formId));?>
	<?=$this->security->requestToken(array('id' => $formId));?>
	<fieldset>
		<legend><span><?= $t( $formTitle ); ?></span></legend>
		<?=$this->form->field( 'username', array(
			'label' => $t('User account form username field label'),
			'maxlength' => DB_FIELD_SIZE_USERNAME,
			'value' => $user->username));?>
		<?php
		if ((LDAP != $settings->login_method) || $settings->use_ldap_realname == OFF) { ?>
		<?=$this->form->field( 'realname', array(
			'label' => $t('User account form realname field label'),
			'maxlength' => DB_FIELD_SIZE_REALNAME,
			'value' => $user->realname));?>
		<?php
		}
		$size = ( $settings->limit_email_domain ? '20' : '32' );
		$limitDomain = '';
		if ( ( LDAP != $settings->login_method ) || $settings->use_ldap_email == OFF ) {
			$limitDomain = ( $settings->limit_email_domain ? '@' . $settings->limit_email_domain : '' );
		?>
		<?=$this->form->field( 'email', array(
			'label' => $t('User account form email field label'),
			'maxlength' => '64',
			'size' => $size,
			'value' => $user->email));?>
		<?=$limitDomain;?>
		<?php
		}

		if ( OFF == $settings->send_reset_password )  { ?>
			<?=$this->form->field( 'password', array(
				'type'=>'password',
				'label' => $t('User account form password field label'),
				'maxlength' => DB_FIELD_SIZE_PASSWORD,
				'size' => 32 ));?>
			<?=$this->form->field( 'verify-password', array(
				'type'=>'password',
				'label' => $t('User account form verify password label'),
				'maxlength' => DB_FIELD_SIZE_PASSWORD,
				'size' => 32 ));?>
		<?php
		} ?>
		<?=$this->form->field( 'access-level', array(
			'type' => 'select',
			'label' => $t('User account form access level field label'),
			'list' => array(),
			'value' => $user->access_level));?>
		<?php #print_project_access_levels_option_list( config_get( 'default_new_account_access_level' ) ) ?>

		<?=$this->form->field(
			'enabled',
			array(
				'type' => 'checkbox',
				'label' => $t( 'User account form enabled field label' ),
				'checked' => 'checked'
			));?>
		<?=$this->form->field(
			'protected',
			array(
				'type' => 'checkbox',
				'label' => $t( 'User account form protected field label' )
			));?>
		<?=$this->form->submit( $t($formSubmitButton) ); ?>
	</fieldset>
<?=$this->form->end(); ?>
</div>