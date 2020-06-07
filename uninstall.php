<?php

use Penguinet\Gripeless\Settings;

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( Settings::OPTION_NAME );
