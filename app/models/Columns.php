<?php

namespace app\models;
use app\models\Settings;

class Columns extends \lithium\data\Model {

	/**
	 * @filter
	 */
	public static function getViewIssuesColumns( $settings ) {
		$columns = $settings->view_issues_page_columns;
		$params = compact('settings', 'columns');

		return static::_filter(__FUNCTION__, $params, function($self, $params) {
			return $params['columns'];
		});
	}

	public static function removeDisabled($columns, $settings ) {
		$filteredColumns = array();
		foreach ( $columns as $column ) {
			switch( $column ) {
				case 'os':
				case 'os_build':
				case 'platform':
					if( ! $settings->enable_profiles ) {
						continue 2;
				}
				/* don't filter */
				break;
				case 'eta':
					if( $settings->enable_eta == OFF ) {
						continue 2;
				}
				break;
				case 'projection':
					if( $settings->enable_projection == OFF ) {
						continue 2;
				}
				break;
				case 'build':
					if( $settings->enable_product_build == OFF ) {
						continue 2;
				}
				break;
				default:
					/* don't filter */
				break;
			}
			$filteredColumns[] = $column;
		} /* continued 2 */
		return $filteredColumns;
	}

}

?>