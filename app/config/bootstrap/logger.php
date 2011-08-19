<?php

use lithium\analysis\Logger;
use lithium\data\Connections;

// Set up the logger configuration to use the file adapter.
Logger::config(array(
    'default' => array('adapter' => 'File')
));

// Filter the database adapter returned from the Connections object.
Connections::get('default')->applyFilter('_execute', function($self, $params, $chain) {
	# Hand the SQL in the params headed to _execute() to the logger:
	Logger::debug(date("D M j G:i:s") . " " . $params['sql']);

	# Always make sure to keep the filter chain going.
	return $chain->next($self, $params, $chain);
});

?>