<?php

namespace app\models;

class Issues extends \lithium\data\Model {
	public $belongsTo = array(
		'Projects' => array('keys' => array('project_id' => 'id'),
	));

#	public $hasMany = array(
#		'Notes' => array('keys' => array('id' => 'bug_id')),
#		'History' => array('keys' => array('id' => 'bug_id')),
#	);

	public $hasOne = array(
		'Reporter' => array('to' => 'Users', 'keys' => array('reporter_id' => 'user_id')),
		'Handler' => array('to' => 'Users', 'keys' => array('handler_id' => 'user_id')),
		'Profiles' => array('keys' => array('profile_id' => 'id')),
		'Categories' => array('keys' => array('category_id' => 'id')),
	);
	public $validates = array();

	public function report() {

	}
}

?>