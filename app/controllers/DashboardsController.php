<?php

namespace app\controllers;

use app\models\Dashboards;
use lithium\action\DispatchException;

class DashboardsController extends \lithium\action\Controller {

	public function index() {
		$dashboards = Dashboards::all();
		return compact('dashboards');
	}

	public function view() {
		$dashboard = Dashboards::first($this->request->id);
		return compact('dashboard');
	}

	public function add() {
		$dashboard = Dashboards::create();

		if (($this->request->data) && $dashboard->save($this->request->data)) {
			$this->redirect(array('Dashboards::view', 'args' => array($dashboard->id)));
		}
		return compact('dashboard');
	}

	public function edit() {
		$dashboard = Dashboards::find($this->request->id);

		if (!$dashboard) {
			$this->redirect('Dashboards::index');
		}
		if (($this->request->data) && $dashboard->save($this->request->data)) {
			$this->redirect(array('Dashboards::view', 'args' => array($dashboard->id)));
		}
		return compact('dashboard');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Dashboards::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Dashboards::find($this->request->id)->delete();
		$this->redirect('Dashboards::index');
	}
}

?>