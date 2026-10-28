<?php

// Define ABSPATH to allow loading the plugin during unit testing
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/../' );
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../simple-wp-debug-logger.php';
