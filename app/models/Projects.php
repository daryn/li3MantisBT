<?php

namespace app\models;
use ArrayObject;
use app\models\Enum;

class Projects extends \lithium\data\Model {
	public $access = array(
		'index' => array(),
		'create' => array(),
		'update' => array(),
		'delete' => array(),
	);

	public $hasMany = array(
		'Categories' => array(
			'keys'=>array( 'id'=>'project_id' ),
		),
		'Children' => array(
			'to' => 'app\models\Projects',
			'from' => 'app\models\Projects',
			'keys' => array( 'id'=>'parent_id' ),
		)
	);

	public $validates = array();

	public static function getProjects($parent_id=0) {
		$projects = new ArrayObject;

		# get the top level projects and their children
		$projectsResult = self::find('all', (array('conditions'=>array('Projects.parent_id'=>$parent_id))));

		foreach($projectsResult AS $project) {
			#$project = $row->to('array');
			$children = self::getProjects($project->id);
			if($children && $children->count()){
				$project->children = $children;
			}
			$projects->append($project);
		}
		return ($projects->count() ? $projects : false);
	}

	public function status($record) {
		return Enum::getLocalizedLabel( 'project_status_enum_string', $record->status);
	}

	public function viewState($record) {
		return Enum::getLocalizedLabel( 'project_view_state_enum_string', $record->view_state);
	}
}

?>