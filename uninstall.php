<?php

use Penguinet\Gripeless\Settings;

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Include classes with Composer.
 */
require_once 'vendor/autoload.php';

delete_option( Settings::OPTION_NAME );
