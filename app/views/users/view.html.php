
<div class="section-container">
	<h2><?= $t( 'View user page account title' ) ?></h2>
	<div class="field-container">
		<span class="display-label"><span><?=$t('User account form username field label'); ?></span></span>
		<span class="display-value"><span><?=$user->username;?></span></span>
		<span class="label-style"></span>
	</div>
	<?php
	# @todo some users may not be able to see the email address
	#	managers should have a mailto link. same thing with realname.
	#	this should be handled in the model.
	if ( ( LDAP != $settings->login_method ) || $settings->use_ldap_email == OFF ) {
	$limitDomain = ( $settings->limit_email_domain ? '@' . $settings->limit_email_domain : '' );
	?>
	<div class="field-container">
		<span class="display-label"><span><?=$t('User account form email field label');?></span></span>
		<span class="display-value"><span><?=$user->email . $limitDomain;?></span></span>
		<span class="label-style"></span>
	</div>
	<?php
	}

	if ((LDAP != $settings->login_method) || $settings->use_ldap_realname == OFF) {
	?>
	<div class="field-container">
		<span class="display-label"><span><?=$t('User account form realname field label');?></span></span>
		<span class="display-value"><span><?=$user->realname;?></span></span>
		<span class="label-style"></span>
	</div>
	<?php
	}
	?>

	<span class="section-links">
		<span id="manage-user-link">
			<?=$this->html->link($t('Manage user edit link'), 'users/edit/' . $user->id);?>
		</span>
	</span>
</div>