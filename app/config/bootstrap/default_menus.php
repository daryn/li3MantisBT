<?php

use app\models\Menus;
use app\models\Settings;
use lithium\net\http\Router;

/**
 * This filter sets up the default menus for the application.
 * the `'name'` parameter indicates the which menu is being requested.  The
 * names listed are simply the defaults and may be any alphanumeric value.  See
 * the default layout and views for examples of how to call menus.
 *
 * Any item with a constant of `MENU_FILTER_FRONT`, `MENU_FILTER_MIDDLE`,
 * or `MENU_FILTER_END` generates a call to `Menus::insertItems` and passes the
 * name of the menu as the first parameter and the value of the constant as the
 * second parameter.  Use this function to insert items anywhere in your menu
 * configuration.  The default locations are `'<name>_front'`,
 * `'<name>_middle'`, and `'<name>_end'` but you may use any alphanumeric value
 * which follows the php rules for array indices.

 * Menu items must follow the format:
 *
 * `array(
 *		'title' => 'language key',
 *		'url' => '',
 *		'options' => array()
 *	)`
 *
 * The options array is used for formatting the menu items.
 *
 * Change this code if you wish to modify the structure of the menus or the
 * menus available to the application.  Plugins may inject menu items into
 * various places of each menu by creating a filter in the plugin bootstrap
 * files.  The old custom menu additions may also be added via filter.
 *
 * @see app\models\Menus
 */
$defaultMainMenu = function($self, $params, $chain) {
	$defaults = array('block'=>array('class'=>'main-menu'), 'list'=>array('class'=>'menu'));
	$params['options'] += $defaults;

	$settings = Settings::all();
	$defaultHome = ($settings->default_home_page ? $settings->default_home_page : 'Dashboards::view');
	$list = array(
		MENU_FILTER_FRONT,
		array('title'=>'Home menu link','url'=>Router::match($defaultHome),'options'=>array()),
		array('title'=>'Dashboard menu link','url'=>Router::match('Dashboards::view'),'options'=>array()), # my view
		array('title'=>'View issues list menu link','url'=>Router::match('Issues::index'),'options'=>array()),
		array('title'=>'Report issue menu link','url'=>Router::match('Issues::report'),'options'=>array()),
		array('title'=>'Changelog menu link','url'=>'','options'=>array()),
		array('title'=>'Roadmap menu link','url'=>'','options'=>array()),
		array('title'=>'Summary menu link','url'=>'','options'=>array()),
		array('title'=>'Documentation menu link','url'=>'','options'=>array()),
		array('title'=>'Wiki menu link','url'=>'','options'=>array()),
		MENU_FILTER_MIDDLE,
		array('title'=>'Settings overview menu link','url'=>Router::match('Settings::index'),'options'=>array()),
		array('title'=>'Account menu link','url'=>Router::match('Account::index'),'options'=>array()),
#		MENU_FILTER,
		array('title'=>'Time tracking menu link','url'=>Router::match('Billing::index'),'options'=>array()),
		array('title'=>'Logout menu link','url'=>'','options'=>array('id'=>'logout-link')),
		MENU_FILTER_END);

	$params['list'] += $list;

	return $chain->next($self, $params, $chain);
};

$defaultManageMenu = function($self, $params, $chain) {
	$defaults = array('block'=>array('id'=>'manage-menu'), 'list'=>array('class'=>'menu'));
	$params['options'] += $defaults;
	$settings = Settings::all();
	$list = array(
		MENU_FILTER_FRONT,
		array('title'=>'Manage users menu link','url'=>Router::match('Users::index'),'options'=>array()),
		array('title'=>'Manage projects menu link','url'=>Router::match('Projects::index'),'options'=>array()),
		array('title'=>'Manage tags menu link','url'=>Router::match('Tags::index'),'options'=>array()),
		array('title'=>'Manage custom fields menu link','url'=>Router::match('CustomFields::index'),'options'=>array()),
		MENU_FILTER_MIDDLE,
		array('title'=>'Manage global profiles menu link','url'=>Router::match('Profiles::index'),'options'=>array()),
		array('title'=>'Manage plugins menu link','url'=>Router::match('Plugins::index'),'options'=>array()),
		array('title'=>'Manage settings menu link','url'=>Router::match('Settings::index'),'options'=>array()),
		MENU_FILTER_END);
	$params['list'] += $list;

	return $chain->next($self, $params, $chain);
};

$defaultManageConfigMenu = function($self, $params, $chain) {
	$defaults = array('block'=>array('class'=>'manage-config-menu'), 'list'=>array('class'=>'menu'));
	$params['options'] += $defaults;
	$settings = Settings::all();
	$list = array(
		MENU_FILTER_FRONT,
		array('title'=>'Settings overview menu link','url'=>Router::match('Settings::index'),'options'=>array()),
		array('title'=>'Manage permissions settings menu link','url'=>Router::match('Settings::permissions'),'options'=>array()),
		array('title'=>'Manage threshold settings menu link','url'=>Router::match('Settings::thresholds'),'options'=>array()),
		array('title'=>'Manage workflow settings menu link','url'=>Router::match('Settings::workflow'),'options'=>array()),
		MENU_FILTER_MIDDLE,
		array('title'=>'Manage workflow graph settings menu link','url'=>Router::match('Settings::workflow_graph'),'options'=>array()),
		array('title'=>'Manage email settings menu link','url'=>Router::match('Settings::email'),'options'=>array()),
		array('title'=>'Manage global columns settings menu link','url'=>Router::match('Settings::columns'),'options'=>array()),
		MENU_FILTER_END);
	$params['list'] += $list;

	return $chain->next($self, $params, $chain);
};

$defaultAccountMenu = function($self, $params, $chain) {
	$defaults = array('block'=>array('class'=>'account-menu'), 'list'=>array('class'=>'menu'));
	$params['options'] += $defaults;
	$settings = Settings::all();
	$list = array(
		MENU_FILTER_FRONT,
		'User account settings',
		'User account preferences',
		MENU_FILTER_MIDDLE,
		'User account profiles',
		'User account sponsorship',
		MENU_FILTER_END);
	$params['list'] += $list;

	return $chain->next($self, $params, $chain);
};

$defaultReportsMenu = function($self, $params, $chain) {
	$defaults = array('block'=>array('class'=>'reports-menu'), 'list'=>array('class'=>'menu'));
	$params['options'] += $defaults;
	$settings = Settings::all();
	$list = array(
		MENU_FILTER_FRONT,
		'summary',
		MENU_FILTER_MIDDLE,
		'print_all_bugs',
		MENU_FILTER_END);
	$params['list'] += $list;

	return $chain->next($self, $params, $chain);
};

$defaultGraphsMenu = function($self, $params, $chain) {
	$defaults = array('block'=>array('class'=>'graphs-menu'), 'list'=>array('class'=>'menu'));
	$params['options'] += $defaults;
	$settings = Settings::all();
	$list = array(
		MENU_FILTER_FRONT,
		MENU_FILTER_MIDDLE,
		MENU_FILTER_END);
	$params['list'] += $list;

	return $chain->next($self, $params, $chain);
};

$defaultDocsMenu = function($self, $params, $chain) {
	$defaults = array('block'=>array('class'=>'docs-menu'), 'list'=>array('class'=>'menu'));
	$params['options'] += $defaults;
	$settings = Settings::all();
	$list = array(
		MENU_FILTER_FRONT,
		'docs',
		'add_docs',
		MENU_FILTER_MIDDLE,
		'project_docs',
		'user_docs',
		MENU_FILTER_END);
	$params['list'] += $list;

	return $chain->next($self, $params, $chain);
};

$defaultMenus = function($self, $params, $chain) use
	(
		$defaultMainMenu, $defaultManageMenu, $defaultManageConfigMenu,
		$defaultAccountMenu, $defaultReportsMenu, $defaultGraphsMenu, $defaultDocsMenu) {
	switch($params['name']) {
		case 'main':
			return $defaultMainMenu($self,$params,$chain);
		break;
		case 'manage':
			return $defaultManageMenu($self,$params,$chain);
		break;
		case 'manage_config':
			return $defaultManageConfigMenu($self,$params,$chain);
		break;
		case 'account':
			return $defaultAccountMenu($self,$params,$chain);
		break;
		case 'reports':
			return $defaultReportsMenu($self,$params,$chain);
		break;
		case 'graphs':
			return $defaultGraphsMenu($self,$params,$chain);
		break;
		case 'docs':
			return $defaultDocsMenu($self,$params,$chain);
		break;
	}
};

?>