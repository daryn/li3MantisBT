<?php

namespace app\models;
use stdClass;

class Settings extends \lithium\data\Model {
	public $validates = array();

	protected static $settings;

	/**
	 *	Override all function to load configuration settings from files until
	 *	such time as they are moved exclusively into the database.
	 */
	public static function all() {

		if( empty( self::$settings ) ) {
			$configIncFound = false;

			# Include default configuration settings
			require_once( LITHIUM_APP_PATH . '/config/config_defaults_inc.php' );

			# config_inc may not be present if this is a new install
			if ( file_exists( LITHIUM_APP_PATH . '/config/config_inc.php' ) ) {
				require_once( LITHIUM_APP_PATH . '/config/config_inc.php' );
				$configIncFound = true;
			}

			# Allow an environment variable (defined in an Apache vhost for example)
			# to specify a config file to load to override other local settings
			$localConfig = getenv( 'MANTIS_CONFIG' );
			if ( $localConfig && file_exists( $localConfig ) ){
				require_once( $localConfig );
				$configIncFound = true;
			}

			if( $configIncFound ) {
				$vars = get_defined_vars();
				self::$settings = new stdClass();
				foreach( $vars AS $key=>$val ) {
					if( strpos( $key, 'g_' ) === 0 ) {
						$key = substr( $key, 2 );
						self::$settings->$key = $val;
					}
				}
			} else {
				return false;
			}
		}
		return self::$settings;
	}

}

?>