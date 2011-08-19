<?php

namespace app\controllers;

use app\models\Settings;
use lithium\action\DispatchException;

class SettingsController extends \lithium\action\Controller {

	public function index() {
		$settings = Settings::all();
		return compact('settings');
	}

	public function view() {
		$setting = Settings::first($this->request->id);
		return compact('setting');
	}

	public function add() {
		$setting = Settings::create();

		if (($this->request->data) && $setting->save($this->request->data)) {
			$this->redirect(array('Settings::view', 'args' => array($setting->id)));
		}
		return compact('setting');
	}

	public function edit() {
		$setting = Settings::find($this->request->id);

		if (!$setting) {
			$this->redirect('Settings::index');
		}
		if (($this->request->data) && $setting->save($this->request->data)) {
			$this->redirect(array('Settings::view', 'args' => array($setting->id)));
		}
		return compact('setting');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Settings::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Settings::find($this->request->id)->delete();
		$this->redirect('Settings::index');
	}
}

?>