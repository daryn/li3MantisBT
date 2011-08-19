<?php

namespace app\controllers;

use app\models\Profiles;
use app\models\Settings;
use lithium\action\DispatchException;

class ProfilesController extends \lithium\action\Controller {
	public function index() {
		$userId = ( $this->request->global ? 0 : 4 );

		$conditions = array( 'conditions'=>array('user_id'=>$currentUserId));
		$profiles = Profiles::getOptionsList($conditions);
		$settings = Settings::all();

		$profile = Profiles::create();
		return compact('settings', 'profile', 'profiles', 'userid');
	}

	public function view() {
		$profile = Profiles::first($this->request->id);
		$settings = Settings::all();
		return compact('profile', 'settings');
	}

	public function create() {
		$userId = ( $this->request->global ? 0 : 4 );
		$settings = Settings::all();
		if (!$settings->enable_profiles) {
			#access denied
		}
		$profile = Profiles::create();

		if (($this->request->data) && $profile->save($this->request->data)) {
			$this->redirect(array('Profiles::view', 'args' => array($profile->id)));
		}
		$this->_render['template'] = 'edit';
		return compact('settings', 'profile', 'profiles');
	}

	public function edit() {
		$profile = Profiles::find($this->request->id);
		$settings = Settings::all();
		if (!$settings->enable_profiles) {
			#access denied
		}
		if (!$profile) {
			$this->redirect('Profiles::index');
		}
		if (($this->request->data) && $profile->save($this->request->data)) {
			$this->redirect(array('Profiles::view', 'args' => array($profile->id)));
		}
		if ($this->request->globalProfile) {
			$profiles = Profiles::getOptionsList(array('conditions'=>array('user_id' => 0)));
			$this->set(array(
				'formId' => 'manage-profile-edit-form',
				'formTitle' => 'Manage profile edit form title',
				'formSubmitButton' => 'Manage profile edit form submit button label',
				'actionFormId' => 'manage-profile-action-form',
				'actionFormTitle' => 'Manage profile action form title',
				'actionFormSubmitButton' => 'Manage profile action form submit button label',
				'userId' => 0));
		} else {
			$profiles = Profiles::getOptionsList(array('conditions'=>array('user_id' => $profile->user_id)));
			$this->set(array(
				'formId'=>'account-profile-edit-form',
				'formTitle'=>'Account profile edit form title',
				'formSubmitButton'=>'Account profile edit form submit button label',
				'actionFormId' => 'account-profile-action-form',
				'actionFormTitle' => 'Account profile action form title',
				'actionFormSubmitButton' => 'Account profile action form submit button label',
				'userId' => $profile->user_id));
		}
		return compact('profile', 'settings', 'profiles');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Profiles::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Profiles::find($this->request->id)->delete();
		$this->redirect('Profiles::index');
	}
}

?>