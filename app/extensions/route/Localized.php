<?php

namespace app\extensions\route;

use lithium\core\Environment;

class Localized extends \lithium\net\http\Route {

	protected function _init() {
		$this->_config['template'] = '/{:locale:[a-z]+[a-z]+}' . $this->_config['template'];
		$this->_config['params'] += array('locale' => null);
		parent::_init();
	}

	public function match(array $options = array(), $context = null) {
		$locale = Environment::get('locale');
		return parent::match($options + compact('locale'), $context);
	}
}

?>