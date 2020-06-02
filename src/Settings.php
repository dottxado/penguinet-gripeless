<?php
/**
 * The option panel functionality of the plugin.
 *
 * @link       https://www.penguinet.it
 * @since      1.0.0
 *
 * @package    Penguinet_Gripeless
 */

namespace Penguinet\Gripeless;

/**
 * Defines the option panel where to provide the project name.
 *
 * @package    Penguinet_Gripeless
 * @author     Erika Gili <penguinet.it@gmail.com>
 */
class Settings {
	/**
	 * Singleton instance
	 *
	 * @var Settings $instance This instance.
	 */
	private static $instance = null;

	/**
	 * The option value taken form the database
	 *
	 * @var string
	 */
	private $option_value;

	const GROUP = 'penguinet_gripeless_group';

	const SECTION = 'penguinet_gripeless_section';

	const OPTION_NAME = 'penguinet_gripeless';

	const MENU_SLUG = 'penguinet-gripeless';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		$this->option_value = get_option( self::OPTION_NAME, '' );
	}

	/**
	 * Get class instance
	 *
	 * @return Settings
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			$c              = __CLASS__;
			self::$instance = new $c();
		}

		return self::$instance;
	}

	/**
	 * Add options page into the settings menu
	 */
	public function add_options_page() {
		add_options_page(
			__( 'Feedback with Gripeless', 'penguinet-gripeless' ),
			__( 'Feedback with Gripeless', 'penguinet-gripeless' ),
			'manage_options',
			self::MENU_SLUG,
			array( $this, 'display_options_page' )
		);
	}

	/**
	 * Display the options page
	 */
	public function display_options_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Feedback with Gripeless Settings', 'penguinet-gripeless' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( self::GROUP );
				do_settings_sections( self::SECTION );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			self::GROUP,
			self::OPTION_NAME
		);

		add_settings_section(
			'project_name_section_id',
			__( 'Add Project Name', 'penguinet-gripeless' ),
			array( $this, 'print_section_info' ),
			self::SECTION
		);

		add_settings_field(
			'tag', // ID.
			__( 'Project Name', 'penguinet-gripeless' ),
			array( $this, 'project_name_callback' ),
			self::SECTION,
			'project_name_section_id'
		);
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		echo '<p>' . esc_html__( 'Open your Gripeless dashboard, create a project and insert here the project name', 'penguinet-gripeless' ) . ' --> ';
		echo '<a href="https://usegripeless.com/app/select-project" target="_blank">' . esc_html__( 'Go to Gripeless projects', 'penguinet-gripeless' ) . '</a></p>';
	}

	/**
	 * Print the setting field
	 */
	public function project_name_callback() {
		echo sprintf(
			'<input type="text" style="width: 400px" name="%s" value="%s" />',
			esc_attr( self::OPTION_NAME ) . '[project_name]',
			esc_attr( $this->get_project_name() )
		);
	}

	/**
	 * Get the project name from the database
	 *
	 * @return string
	 */
	public function get_project_name() {
		if ( isset( $this->option_value['project_name'] ) ) {
			return $this->option_value['project_name'];
		}

		return null;
	}
}
