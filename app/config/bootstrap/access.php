<?php

use li3_access\security\Access;

# MantisBT Roles: Viewer, Reporter, Updater, Developer, Manager, Administrator

Access::config( array(
	'auth_rbac' => array(
		'adapter' => 'AuthRbac',
		'roles' => array(
#			array(
#				'requesters' => '*',
#				'match' => '*::*'
#			),
#			array(
#				'message' => 'No panel for you!',
#				'redirect' => array('library' => 'admin', 'Sessions::add'),
#				'requesters' => 'admin',
#				'match' => array('library' => 'admin', '*::*')
#			),
#			array(
#				'requesters' => '*',
#				'match' => array('library' => 'admin', 'Sessions::add')
#			),
			array(
				'requesters' => '*',
				'match' => array('library' => 'admin', 'Users::logout')
			)
		)
	)));

?>