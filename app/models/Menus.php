<?php

namespace app\models;

class Menus extends \lithium\core\StaticObject {
	public $access;
/*
	private static $availableItems = array(
		# main links
		'view_issues'=>array('url'=>Router::match('Issues::index')),
		'print_issues'=>array('url'=>''),
		'report_issue'=>array('url'=>Router::match('Issues::report')),

		'home'=>array('url'=>''),
		'dashboard'=>array('url'=>Router::match('Dashboards::index')), # my view
		'changelog'=>array('url'=>''),
		'roadmap'=>array('url'=>''),
		'summary'=>array('url'=>''),
		'docs'=>array('url'=>''),
		'wiki'=>array('url'=>''),
		'manage'=>array('url'=>''),
		'time_tracking'=>array('url'=>''),
		'logout'=>array('url'=>''),

		# manage links
		'users'=>array('url'=>Router::match('Users::index')),
		'projects'=>array('url'=>Router::match('Projects::index')),
		'tags'=>array('url'=>Router::match('Tags::index')),
		'custom_fields'=>array('url'=>Router::match('CustomFields::index')),
		'profiles'=>array('url'=>Router::match('Profiles::index')),
		'plugins'=>array('url'=>Router::match('Plugins::index')),
		'settings_report'=>array('title'=>'Settings overview menu link','url'=>Router::match('Settings::index')),

		# account links
		'account'=>array('title'=>'Account menu link','url'=>Router::match('Account::index')),
		'preferences'=>array('url'=>Router::match('Preferences::edit')),
		'columns'=>array('url'=>Router::match('Columns::edit')),
		'profiles'=>array('url'=>Router::match('Profiles::index')),
		'sponsorship'=>array('url'=>Router::match('Account::sponsor')),

		# manage config links
		'settings_permissions'=>array('url'=>'Settings::permissions'),
		'settings_thresholds'=>array('url'=>'Settings::thresholds'),
		'settings_workflow'=>array('url'=>'Settings::workflow'),
		'settings_workflow_graph'=>array('url'=>'Settings::workflow_graph'),
		'settings_email'=>array('url'=>'Settings::email'),
		'settings_columns'=>array('url'=>'Settings::columns'),

		# doc links
		'manual'=>array('url'=>''),
		'user_docs'=>array('url'=>''),
		'project_docs'=>array('url'=>''),
		'project_add_docs'=>array('url'=>''),

#		'summary'=>array('url'=>''),

	);*/

	public static function getMenu($name, $options) {
		static $validInserts = array(MENU_FILTER_FRONT, MENU_FILTER_MIDDLE, MENU_FILTER_END);
		$menu = self::menuFilter($name, $options);
		$items = $menu['list'];

		$list = array();
		foreach($items AS $item) {
			if(in_array($item, $validInserts)) {
				$insertItems = self::insertItems( $name, $item, $options);
				if( !empty( $insertItems ) ) {
					$list = array_merge($list, $insertItems);
				}
			} else {
				$list[] = $item;
			}
		}

		$menu['list'] = $list;

		# sort parent menu items by key name
#		ksort($menu['list']);
		return $menu;
	}

	/**
	 * @filter
	 */
	protected static function menuFilter($name, $options) {
		$defaults = array();
		$list = array();
		$options += $defaults;

		$params = compact('name', 'options', 'list');

		return static::_filter(__FUNCTION__, $params, function($self, $params) {
			return $params;
		});
	}

	/**
	 * @filter
	 */
	public static function insertItems($name, $location, $options) {
		$defaults = array();
		$list = array();
		$options += $defaults;
		$params = compact('name', 'location', 'list', 'options');

		$filter = function($self, $params) {
			return $params['list'];
		};

		return static::_filter(__FUNCTION__, $params, $filter);
	}

	public static function removeDisabled($menu) {
		foreach($menu AS $key=>$option) {
			switch($key) {
				case 'docs':
					if(OFF == $settings->enable_project_documentation) {
						unset($menu[$key]);
					}
				break;
				case 'wiki':
					if(OFF == $settings->wiki_enable) {
						unset($menu[$key]);
					}
				break;
			}
		}
	}
}

?>