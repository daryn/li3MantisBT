<?php

namespace app\models;

class Profiles extends \lithium\data\Model {
	public $belongsTo = array('Users'=>array('keys' => array('user_id' => 'id')));
	public $validates = array();

	public static function getOptionsList($profiles) {
		$profilesList = array();
		foreach( $profiles AS $profile ) {
			$profilesList[$profile->id] = $profile->platform . ' ' . $profile->os . ' ' . $profile->os_build;
		}
		return $profilesList;
	}
}

?>