<?php
namespace app\extensions\helper;

use lithium\g11n\Message;

class Html extends \lithium\template\helper\Html {
	/**
»    * Creates an HTML list (`<ul />`)
»    *
»    * @return string Returns an unorder list contained in a block.
»    */
	public function htmlList(array $items, array $options = array()) {
		$defaults = array('escape' => true, 'type' => null);
		list($scope, $options) = $this->_options($defaults, $options);
		$listItemOptions = (array_key_exists('list-item', $options) ? $options['list-item'] : array());
		$listOptions = (array_key_exists('list', $options) ? $options['list'] : array());
		$blockOptions = (array_key_exists('block', $options) ? $options['block'] : array());

		$listItems = '';
		foreach( $items AS $content) {
			$listItems .= $this->_render(
				__METHOD__,
				'list-item', array(
					'options'=>$listItemOptions,
					'content'=>$content),
				$scope);
		}
		$list = $this->_render(
			__METHOD__,
			'list', array(
				'options'=>$listOptions,
				'content'=>$listItems),
			$scope);
		return $this->_render(
			__METHOD__,
			'block', array(
				'options'=>$blockOptions,
				'content'=>$list),
			$scope);
	}

	public function htmlMenu(array $items, array $options = array()) {
		extract(Message::aliases());
		$defaults = array('escape' => true, 'type' => null);
		list($scope, $options) = $this->_options($defaults, $options);

		$listItemOptions = (array_key_exists('list-item', $options) ? $options['list-item'] : array());
		$listOptions = (array_key_exists('list', $options) ? $options['list'] : array());
		$blockOptions = (array_key_exists('block', $options) ? $options['block'] : array());

		$listItems = '';
		foreach($items AS $link) {
			$linkOptions = (array_key_exists('options', $link) ? $link['options'] : array());
			$listItems .= $this->_render(
				__METHOD__,
				'list-item', array(
					'options'=>$listItemOptions,
					'content'=>$this->link($t($link['title']),$link['url'], $linkOptions)),
				$scope);
		}
		$list = $this->_render(
			__METHOD__,
			'list', array(
				'options'=>$listOptions,
				'content'=>$listItems),
			$scope);
		return $this->_render(
			__METHOD__,
			'block', array(
				'options'=>$blockOptions,
				'content'=>$list),
			$scope);
	}

}
?>