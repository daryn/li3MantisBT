<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2011, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * Uncomment the lines below to enable forms-based authentication. This configuration will attempt
 * to authenticate users against a `Users` model. In a controller, run
 * `Auth::check('default', $this->request)` to authenticate a user. This will check the POST data of
 * the request (`lithium\action\Request::$data`) to see if the fields match the `'fields'` key of
 * the configuration below. If successful, it will write the data returned from `Users::first()` to
 * the session using the default session configuration.
 *
 * Once the session data is written, you can call `Auth::check('default')` to check authentication
 * status or retrieve the user's data from the session. Call `Auth::clear('default')` to remove the
 * user's authentication details from the session. This effectively logs a user out of the system.
 * To modify the form input that the adapter accepts, or how the configured model is queried, or how
 * the data is stored in the session, see the `Form` adapter API or the `Auth` API, respectively.
 *
 * @see lithium\security\auth\adapter\Form
 * @see lithium\action\Request::$data
 * @see lithium\security\Auth
 */
use lithium\security\Auth;
use lithium\security\Password;
use app\models\Users;

Auth::config(array(
	'default' => array(
		'adapter' => 'Form',
		'model' => 'Users',
		'fields' => array('username', 'password'),
		'scope' => array('enabled' => true),
		'session' => array( 'options' => array( 'name' => '' ) ),
#		'filters' => array( function( $data ) {
#			$user = Users::first( array('fields' => 'password', 'conditions' => array('username' => $data['username'] )) );
#			if( $user ) {
#				$data['password'] = $user->password;
#			}
#			return $data;
#		})
	),
/*	'user' => array(
		'adapter' => 'Form',
		'model' => 'Users',
		'fields' => array('username'=>'username', 'password'=>'password'),
		'scope' => array('enabled' => true),
		'filters' => array( function( $data ) {
			$user = Users::first( array('fields' => 'password', 'conditions' => array('username' => $data['username'] )) );
			if( $user ) {
				$data['password'] = $user->password;
			}
			return $data;
		})
	),
	'administrator' => array(
		'adapter' => 'Form',
		'model' => 'Administrator',
		'fields' => array('username'=>'username', 'password'=>'password'),
		'scope' => array('enabled' => true),
		'filters' => array( function( $data ) {
			$user = Users::first( array('fields' => 'password', 'conditions' => array('username' => $data['username'] )) );
			if( $user ) {
				$data['password'] = $user->password;
			}
			return $data;
		})
	),*/
));


# filter to hash the password when saving a user.
Users::applyFilter('save', function($self, $params, $chain) {
	if ($params['data']) {
		$params['entity']->set($params['data']);
		$params['data'] = array();
	}

	if (!$params['entity']->exists()) {
		$params['entity']->password = Password::hash($params['entity']->password);
	}
	return $chain->next($self, $params, $chain);
});

?>