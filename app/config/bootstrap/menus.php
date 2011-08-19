<?php

use app\models\Menus;

/**
 *	Include the default menus or a custom menus file to override all menus
 */
require __DIR__ . '/default_menus.php';

/**
 * This filter intercepts the `getMenuList()` method of the `Menus` model
 * and sets up the menus for the application.
 * The first parameter is the name of the function being filtered.
 * The second parameter is the starting filter.
 */
Menus::applyFilter('menuFilter', $defaultMenus);
#Menus::applyFilter('getMenu', $defaultManageMenu);
#Menus::applyFilter('getMenu', $defaultManageConfigMenu);
#Menus::applyFilter('getMenu', $defaultAccountMenu);
#Menus::applyFilter('getMenu', $defaultReportMenu);
#Menus::applyFilter('getMenu', $defaultGraphsMenu);
#Menus::applyFilter('getMenu', $defaultDocsMenu);
?>