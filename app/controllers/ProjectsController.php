<?php

namespace app\controllers;

use lithium\security\Auth;
use li3_access\security\Access;
use app\models\Sessions;
use app\models\Settings;
use app\models\Projects;
use app\models\Categories;
use lithium\action\DispatchException;

use app\models\Users;

class ProjectsController extends \lithium\action\Controller {

	public function index() {
#		if (!Auth::check('default')) {
#			return $this->redirect('Sessions::add');
#		}

		$currentUser = Users::first();

		$sort = 'name';
		$dir = 'ASC';

		$settings = Settings::all();
		$projects = Projects::getProjects();

		if( $projects->count() == 0 ) {
			$this->redirect('Projects::create');
		}
		$categories = Categories::find('all', array( 'conditions'=>array('project_id'=>0 )));
		return compact('settings', 'projects', 'categories', 'currentUser');
	}

	public function view() {
		$settings = Settings::all();
		$project = Projects::first($this->request->id);
		return compact('settings', 'project');
	}

	public function create() {
		$project = Projects::create();
		$categories = false;
		$settings = Settings::all();

		$formId = 'manage-project-create-form';
		$formTitle = 'Add new project form title';
		$formSubmitButton = 'Add new project form submit button';

		if (($this->request->data) && $project->save($this->request->data)) {
			$this->redirect(array('Projects::view', 'args' => array($project->id)));
		}
		$this->_render['template'] = 'edit';
		return compact('project', 'categories', 'settings', 'formId', 'formTitle', 'formSubmitButton');
	}

	public function edit() {
		$project = Projects::find($this->request->id);
		$categories = Categories::find('all', array( 'conditions'=>array('project_id'=>$project->id )));
		$settings = Settings::all();

		$formId = 'manage-project-edit-form';
		$formTitle = 'Edit project form title';
		$formSubmitButton = 'Edit project form submit button';

		if (!$project) {
			$this->redirect('Projects::index');
		}
		if (($this->request->data) && $project->save($this->request->data)) {
			$this->redirect(array('Projects::view', 'args' => array($project->id)));
		}
		return compact('project', 'categories', 'settings', 'formId', 'formTitle', 'formSubmitButton');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Projects::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Projects::find($this->request->id)->delete();
		$this->redirect('Projects::index');
	}
}

?>