<?php
/**
 * The "button" functionality of the plugin.
 *
 * @link       https://www.penguinet.it
 * @since      1.0.0
 *
 * @package    Penguinet_Gripeless
 */

namespace Penguinet\Gripeless;

/**
 * Defines the admin bar button and includes the scripts.
 *
 * @package    Penguinet_Gripeless
 * @author     Erika Gili <penguinet.it@gmail.com>
 */
class Button {

	/**
	 * Singleton instance
	 *
	 * @var Button $instance This instance.
	 */
	private static $instance = null;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	private function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'add_button' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Get class instance
	 *
	 * @return Button
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			$c              = __CLASS__;
			self::$instance = new $c();
		}

		return self::$instance;
	}

	/**
	 * Add the button to report a problem in the admin bar
	 *
	 * @param \WP_Admin_Bar $admin_bar WP_Admin_Bar instance, passed by reference.
	 */
	public function add_button( $admin_bar ) {
		if ( empty( Settings::get_instance()->get_project_name() ) || ! is_admin_bar_showing() ) {
			return;
		}
		$admin_bar->add_menu(
			array(
				'id'    => 'penguinet-gripeless-report',
				'title' => __( 'Report a problem', 'penguinet-gripeless' ),
				'href'  => '#',
				'meta'  => array(
					'title' => __( 'Report a problem', 'penguinet-gripeless' ),
				),
			)
		);
	}

	/**
	 * Enqueue the Gripeless SDK
	 */
	public function enqueue_scripts() {
		if ( empty( Settings::get_instance()->get_project_name() ) || ! is_admin_bar_showing() ) {
			return;
		}
		wp_enqueue_script(
			PLUGIN_NAME . '-sdk',
			'//sdk.usegripeless.com',
			array(),
			null,
			false
		);
		wp_enqueue_script(
			PLUGIN_NAME . '-modal',
			plugin_dir_url( pathinfo( __FILE__, PATHINFO_DIRNAME ) ) . 'js/modal.js',
			array( PLUGIN_NAME . '-sdk' ),
			filemtime( plugin_dir_path( pathinfo( __FILE__, PATHINFO_DIRNAME ) ) . 'js/modal.js' ),
			true
		);
		wp_localize_script(
			PLUGIN_NAME . '-modal',
			'PenguinetGripelessModal',
			array(
				'projectName' => Settings::get_instance()->get_project_name(),
				'userEmail'   => wp_get_current_user()->user_email,
			)
		);
	}

}
