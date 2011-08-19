<?php

namespace app\controllers;

use app\models\Menus;
use lithium\action\DispatchException;

class MenusController extends \lithium\action\Controller {

	public function index() {
		$menus = Menus::all();
		return compact('menus');
	}

	public function view() {
		$menu = Menus::first($this->request->id);
		return compact('menu');
	}

	public function add() {
		$menu = Menus::create();

		if (($this->request->data) && $menu->save($this->request->data)) {
			$this->redirect(array('Menus::view', 'args' => array($menu->id)));
		}
		return compact('menu');
	}

	public function edit() {
		$menu = Menus::find($this->request->id);

		if (!$menu) {
			$this->redirect('Menus::index');
		}
		if (($this->request->data) && $menu->save($this->request->data)) {
			$this->redirect(array('Menus::view', 'args' => array($menu->id)));
		}
		return compact('menu');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Menus::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Menus::find($this->request->id)->delete();
		$this->redirect('Menus::index');
	}
}

?>