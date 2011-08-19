<?php

namespace app\controllers;

use lithium\security\Auth;
use li3_access\security\Access;
use app\models\Users;
use app\models\Settings;
use lithium\action\DispatchException;

class UsersController extends \lithium\action\Controller {
	public function index() {
#		$access = Access::check('auth_rbac', Auth::check('default'), $this->request);
		$sort = 'username';
		$dir = 'ASC';
		$hide = 1;
		#$filter = utf8_strtoupper( $this->request->filter, $settings->default_manage_user_prefix );
		$filter = $this->request->filter;

#		if(!empty($access)) {
#			$this->redirect($access['redirect']);
#		}
		$users = Users::all();
		$settings = Settings::all();
		return compact('users', 'settings', 'sort', 'dir', 'hide', 'filter');
	}

	public function view() {
		$settings = Settings::all();
		$user = Users::first($this->request->id);
		return compact('settings', 'user');
	}

	public function create() {
		$user = Users::create();
		$settings = Settings::all();
		$formId = 'manage-user-create-form';
		$formTitle = 'Add new user account form title';
		$formSubmitButton = 'Add new user account form submit button';

		if (($this->request->data) && $user->save($this->request->data)) {
			$this->redirect(array('Users::view', 'args' => array($user->id)));
		}
		$this->_render['template'] = 'edit';
		return compact('user', 'settings', 'formId', 'formTitle', 'formSubmitButton');
	}

	public function edit() {
		$settings = Settings::all();
		$user = Users::first($this->request->id);

		$formId = 'manage-user-edit-form';
		$formTitle = 'Edit user account form title';
		$formSubmitButton = 'Edit user account form submit button';

		if (!$user) {
			$this->redirect('Users::index');
		}
		if (($this->request->data) && $user->save($this->request->data)) {
			$this->redirect(array('Users::view', 'args' => array($user->id)));
		}
		return compact('settings', 'user', 'formId', 'formTitle', 'formSubmitButton');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Users::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Users::find($this->request->id)->delete();
		$this->redirect('Users::index');
	}
}

?>