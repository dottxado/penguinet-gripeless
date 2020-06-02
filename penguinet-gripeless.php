<?php
/**
 * Plugin Name:     Feedback with Gripeless
 * Plugin URI:      https://www.penguinet.it/progetti/gripeless
 * Description:     Make reporting issues frictionless
 * Author:          Erika Gili
 * Author URI:      https://www.penguinet.it
 * Text Domain:     penguinet-gripeless
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Penguinet_Gripeless
 */

namespace Penguinet\Gripeless;

if ( ! defined( 'WPINC' ) ) {
	die;
}

const PLUGIN_NAME = 'penguinet-gripeless';

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'Penguinet\Gripeless\settings_link' );
add_action( 'plugins_loaded', 'Penguinet\Gripeless\load_textdomain' );

/**
 * Place a settings link in the plugins page
 *
 * @param array $links The other plugin's links.
 *
 * @return array
 */
function settings_link( $links ) {
	$settings_link = '<a href="options-general.php?page=' . Settings::MENU_SLUG . '">' . __( 'Settings', 'penguinet-gripeless' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}

/**
 * Load the plugin text domain for translation.
 */
function load_textdomain() {
	load_plugin_textdomain(
		'penguinet-gripeless',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
	);
}

/**
 * Include classes with Composer.
 */
require_once 'vendor/autoload.php';

Button::get_instance();
Settings::get_instance();

