<?php

use app\models\Menus;

$self = $this;

$this->title( $t( 'Manage users page heading title' ) );
$this->styles('<link rel="stylesheet" type="text/css" href="/css/tables.css" />');

$manageMenu = function() use ($self) {
	$manageMenu = Menus::getMenu('manage', array());
	$out = '';
	if( $manageMenu ) {
		$out .= $self->html->htmlMenu($manageMenu['list'], $manageMenu['options']);
	}
	return $out;
};
?>

<?php echo $manageMenu();?>

<div id="manage-user-div" class="form-container">
	<h2><?= $t( 'Heading for managing list of users accounts' ); ?><span>[<?= $users->count() ?>]</span></h2>
	<?=$this->html->link( $t( 'Users list create new account link' ), $this->url(array('Users::create' ))); ?>
	<?=$this->html->link( $t( 'Users list prune accounts link' ), $this->url(array('Users::prune'))); ?>
	<?php #if ( $f_filter === 'UNUSED' ) echo print_button( 'manage_user_prune.php', lang( 'prune_accounts' ) ); ?>
	<?=$this->form->create(null,array('id' => 'manage-user-filter')); ?>
			<?=$this->form->field('sort', array('type'=>'hidden', 'value'=>$sort));?>
			<?=$this->form->field('dir', array('type'=>'hidden', 'value'=>$dir));?>
			<?=$this->form->field('save', array('type'=>'hidden', 'value'=>1));?>
			<?=$this->form->field('filter', array('type'=>'hidden', 'value'=>$filter));?>
			<?=$this->form->field('hide', array('template' => 'plain-field', 'label' => $t( 'Users list hide inactive users link' ), 'type'=>'checkbox', 'value'=>1, 'checked'=>$hide));?>
			<?=$this->form->submit($t('Users list hide inactive users form submit button'), array('template' => 'plain-submit' )); ?>
	<?=$this->form->end(); ?>

	<table cellspacing="1" cellpadding="5" border="1">
		<tr class="row-category">
			<?php
				# @todo determine sort direction and class for each column
				$sortDir = 'sortAsc';
			?>
			<td><?php #@todo don't forget the filter in the sort; ?>
				<?=$this->html->link( $t( 'Users list username field column heading' ), 'users', array('class'=>$sortDir ) ); ?>
			</td>
			<td>
				<?=$this->html->link( $t( 'Users list realname field column heading' ), 'users', array( 'class'=>$sortDir ) ); ?>
			</td>
			<td>
				<?=$this->html->link( $t( 'Users list email field column heading' ), 'users', array( 'class'=>$sortDir ) ); ?>
			</td>
			<td>
				<?=$this->html->link( $t( 'Users list access level field column heading' ), 'users', array( 'class'=>$sortDir ) ); ?>
			</td>
			<td>
				<?=$this->html->link( $t( 'Users list enabled field column heading' ), 'users', array( 'class'=>$sortDir ) ); ?>
			</td>
			<td><?=$this->html->link( $this->html->image('protected.gif', array('alt' => $t('Users list protected field column heading'))), 'users', array('escape'=>false, 'class'=>$sortDir)); ?></td>
			<td>
				<?=$this->html->link( $t( 'Users list date created field column heading' ), 'users', array( 'class'=>$sortDir ) ); ?>
			</td>
			<td>
				<?=$this->html->link( $t( 'Users list last visit field column heading' ), 'users', array( 'class'=>$sortDir ) ); ?>
			</td>
		</tr><?php
        foreach( $users->data() AS $user ) {
//	$t_date_format = config_get( 'normal_date_format' );
//	$t_access_level = array();
//	for ( $i = 0; $i < $t_user_count; $i++ ) {
		# prefix user data with u_
//		$t_user = $t_users[$i];
//		extract( $t_user, EXTR_PREFIX_ALL, 'u' );

//		$u_date_created  = date( $t_date_format, $u_date_created );
//		$u_last_visit    = date( $t_date_format, $u_last_visit );

//		if( !isset( $t_access_level[$u_access_level] ) ) {
//			$t_access_level[$u_access_level] = get_enum_element( 'access_levels', $u_access_level );
//		} ?>
		<tr <?php //echo helper_alternate_class( $i ) ?>>
			<td><?php
//				if ( access_has_global_level( $u_access_level ) ) {
//					<a href="manage_user_edit_page.php?user_id=$u_id">echo string_display_line( $u_username )</a>
//				} else {
					#$user['username'];
//				} ?>
				<?=$this->html->link( $user['username'], $this->url(array('Users::edit', 'id'=>$user['id']))); ?>
			</td>
			<td><?= $user['realname']; ?></td>
			<td>
                <?php //print_email_link( $u_email, $u_email ) ?>
                <?= $user['email']; ?>
            </td>
			<td>
                <?php //echo $t_access_level[$u_access_level] ?>
                <?= $user['access_level']; ?>
            </td>
			<td>
                <?php //echo trans_bool( $u_enabled ) ?>
                <?= $user['enabled'] ?>
            </td>
			<td class="center"><?php
				if ( $user['protected'] ) {
					echo $this->html->image( 'protected.gif', array( 'alt' => $t('Protected user icon alt text')));
				} else {
					echo '&#160;';
				} ?>
			</td>
			<td><?= $user['date_created'] ?></td>
			<td><?= $user['last_visit'] ?></td>
		</tr><?php
	}  # end for ?>
	</table>
	<div class="pager-links">
		<?php
		/* @todo hack - pass in the hide inactive filter via cheating the actual filter value */
//		print_page_links( 'manage_user_page.php', 1, $t_page_count, (int)$f_page_number, $c_filter . $t_hide_filter . "&amp;sort=$c_sort&amp;dir=$c_dir");
		?>
	</div>
</div>

<div id="manage-user-edit-div" class="form-container">
	<?=$this->form->create(null,array('id' => 'manage-user-edit-form')); ?>
		<fieldset>
			<?=$this->form->field( 'username', array(
				'label' => $t('Manage user search form username field label'),
				'maxlength' => DB_FIELD_SIZE_USERNAME));?>
			<?=$this->form->submit($t('Add new user account submit button')); ?>
		</fieldset>
	<?=$this->form->end(); ?>
</div>