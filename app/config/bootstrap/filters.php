<?php

use app\models\Columns;

/**
 * This filter intercepts the `getViewIssuesColumns()` method of the `Columns`,
 * and first passes the `'request'` parameter (an instance of the `Request`
 * object) to the `Environment` class to detect which environment the
 * application is running in. Then, loads all application routes in all
 * plugins, loading the default application routes last.
 *
 * Change this code if plugin routes must be loaded in a specific order (i.e.
 * not the same order as the plugins are added in your bootstrap configuration),
 * or if application routes must be loaded first (in which case the default
 * catch-all routes should be removed).
 *
 * If `Dispatcher::run()` is called multiple times in the course of a single
 * request, change the `include`s to `include_once`.
 *
 * @see app\models\Columns
 */
Columns::applyFilter('getViewIssuesColumns', function($self, $params, $chain) {
	$params['columns'][] = 'CustomFunctionColumn1';
	$params['columns'][] = 'CustomFunctionColumn2';
	return $chain->next($self, $params, $chain);
});

?>