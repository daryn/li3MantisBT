<?php

namespace app\controllers;

use app\models\Categories;
use lithium\action\DispatchException;

class CategoriesController extends \lithium\action\Controller {

	public function index() {
		$categories = Categories::all();
		return compact('categories');
	}

	public function view() {
		$category = Categories::first($this->request->id);
		return compact('category');
	}

	public function add() {
		$category = Categories::create();

		if (($this->request->data) && $category->save($this->request->data)) {
			$this->redirect(array('Categories::view', 'args' => array($category->id)));
		}
		return compact('category');
	}

	public function edit() {
		$category = Categories::find($this->request->id);

		if (!$category) {
			$this->redirect('Categories::index');
		}
		if (($this->request->data) && $category->save($this->request->data)) {
			$this->redirect(array('Categories::view', 'args' => array($category->id)));
		}
		return compact('category');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Categories::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Categories::find($this->request->id)->delete();
		$this->redirect('Categories::index');
	}
}

?>