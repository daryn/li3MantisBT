<?php

namespace app\models;
use app\models\Settings;
use app\models\Enum;
use lithium\g11n\Message;

class Users extends \lithium\data\Model {
	public $hasMany = array('Profiles' => array('keys' => array( 'id'=>'user_id')));
#	public $hasMany = array('Issues' => array('keys' => array( 'id'=>'reporter_id')));
	public $validates = array();

	public function name() {

	}

	public function isAnonymous() {
		return false;
	}

	public function accessLevel($record) {
		return Enum::getLocalizedLabel( 'access_levels_enum_string', $record->access_level);
	}

	public function accessLevelCss($record) {
		$settings = Settings::all();
		return Enum::getLabel( $settings->access_levels_enum_string, $record->access_level);
	}
}

?>