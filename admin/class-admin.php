<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       https://www.slushman.com
 * @since      1.0.0
 * @package    Restaurants\Admin
 * @author     Slushman <chris@slushman.com>
 */

namespace Restaurants\Admin;
use \Restaurants\Fields as Fields;
use \Restaurants\Includes as Inc;

class Admin {

	/**
	 * Array of plugin settings to validate before saving to the database.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		array
	 */
	private $settings;

	/**
	 * The settings tabs.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		array 		$tabs 		The settings tabs.
	 */
	private $tabs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		//

	} // __construct()

	/**
	 * Registers all the WordPress hooks and filters related to this class.
	 *
	 * @hooked 		init
	 * @since 		1.0.0
	 */
	public function hooks() {

		add_action( 'activated_plugin', 		array( $this, 'save_activation_errors' ) );
		add_action( 'admin_notices', 			array( $this, 'activation_error_notice' ) );
		add_action( 'admin_enqueue_scripts', 	array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', 	array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_init', 				array( $this, 'register_fields' ) );
		add_action( 'admin_init', 				array( $this, 'register_sections' ) );
		add_action( 'admin_init', 				array( $this, 'register_settings' ) );
		add_action( 'admin_menu', 				array( $this, 'add_menu' ) );
		add_action( 'plugin_action_links_' . RESTAURANTS_FILE, array( $this, 'link_settings' ) );

	} // hooks()

	/**
	 * Displays an error notice displaying the error notice, if there is one.
	 *
	 * @hooked 		admin_notices
	 * @since 		1.0.0
	 */
	public function activation_error_notice() {

		$error = get_option( 'restaurants-errors' );

		if ( empty( $error ) ) { return; }

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/error-notice.php' );

	} // activation_error_notice()

	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/classesistration_Menus
	 * @since 		1.0.0
	 */
	public function add_menu() {

		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		// Submenu Page
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

		add_submenu_page(
			'edit.php?post_type=restaurant',
			esc_html__( 'Restaurants Settings', 'restaurants' ),
			esc_html__( 'Settings', 'restaurants' ),
			'manage_options',
			RESTAURANTS_SLUG . '-settings',
			array( $this, 'page_options' )
		);

		add_submenu_page(
			'edit.php?post_type=restaurant',
			esc_html__( 'Restaurants Help', 'restaurants' ),
			esc_html__( 'Help', 'restaurants' ),
			'manage_options',
			RESTAURANTS_SLUG . '-help',
			array( $this, 'page_help' )
		);

	} // add_menu()

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( RESTAURANTS_SLUG, plugin_dir_url( __FILE__ ) . 'css/restaurants.css', array(), RESTAURANTS_VERSION, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 		1.0.0
	 * @param		string 		$hook_suffix 		//
	 */
	public function enqueue_scripts( $hook_suffix ) {

		wp_enqueue_media();

		wp_enqueue_script( RESTAURANTS_SLUG, plugin_dir_url( __FILE__ ) . 'js/restaurants-admin.min.js', array( 'jquery' ), RESTAURANTS_VERSION, true );

	} // enqueue_scripts()

	/**
	 * Creates a checkbox form field.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 		The field arguments.
	 * @return 		string 					The HTML field.
	 */
	public function field_checkbox( $args ) {

		new Fields\Checkbox( 'settings', $args );

	} // field_checkbox()

	/**
	 * Creates a editor form field.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 		The field arguments.
	 * @return 		string 					The HTML field.
	 */
	public function field_editor( $args ) {

		new Fields\Editor( 'settings', $args );

	} // field_editor()

	/**
	 * Creates a file uploader form field.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 		The field arguments.
	 * @return 		string 					The HTML field.
	 */
	public function field_file_uploader( $args ) {

		new Fields\File_Uploader( 'settings', $args );

	} // field_file_uploader()

	/**
	 * Creates a radios form field.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 		The field arguments.
	 * @return 		string 					The HTML field.
	 */
	public function field_radios( $args ) {

		new Restaurants_Field_Radios( 'settings', $args );

	} // field_radios()

	/**
	 * Creates a select form field.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 		The field arguments.
	 * @return 		string 					The HTML field.
	 */
	public function field_select( $args ) {

		new Fields\Select( 'settings', $args );

	} // field_select()

	/**
	 * Creates a text form field.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 		The field arguments.
	 * @return 		string 					The HTML field.
	 */
	public function field_text( $args ) {

		new Fields\Text( 'settings', $args );

	} // field_text()

	/**
	 * Creates a textarea form field.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$args 		The field arguments.
	 * @return 		string 					The HTML field.
	 */
	public function field_textarea( $args ) {

		new Fields\Textarea( 'settings', $args );

	} // field_textarea()

	/**
	 * Returns the active tab.
	 *
	 * @since 		1.0.0
	 * @return 		string 			The name of the active tab.
	 */
	protected function get_active_tab() {

		if ( isset( $_GET['tab'] ) ) {

			return $_GET['tab'];

		} else {

			return 'settings';

		}

	} // get_active_tab()

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of links
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {

		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=restaurant&page=restaurants-settings' ), esc_html__( 'Settings', 'restaurants' ) );

		return $links;

	} // link_settings()

	/**
	 * Includes the help page view
	 *
	 * @since 		1.0.0
	 */
	public function page_help() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pages/help.php' );

	} // page_help()

	/**
	 * Includes the options page view
	 *
	 * @since 		1.0.0
	 */
	public function page_options() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/pages/settings.php' );

	} // page_options()

	/**
	 * Registers settings fields with WordPress
	 *
	 * @hooked 		admin_init
	 * @since 		1.0.0
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

	} // register_fields()

	/**
	 * Registers settings sections with WordPress
	 *
	 * @hooked 		admin_init
	 * @since 		1.0.0
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			RESTAURANTS_SETTINGS,
			esc_html__( 'Settings Section', 'restaurants' ),
			array( $this, 'sections' ),
			RESTAURANTS_SETTINGS
		);

	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @hooked 		admin_init
	 * @since 		1.0.0
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			RESTAURANTS_SETTINGS,
			RESTAURANTS_SETTINGS,
			array( $this, 'validate_settings' )
		);

	} // register_settings()

	/**
	 * Sets the class variable $tabs.
	 *
	 * Tabs can be added using the restaurants_settings_tabs filter.
	 * Each tab array needs the following:
	 * 	name 		The name of the tab
	 *  url 		The URL for the tab.
	 *  fields 		The settings key for this tab's fields
	 *  sections 	The settings key for this tab's sections
	 *
	 * @since 		1.0.0
	 */
	public function register_tabs() {

		$default_tabs = array();

		/**
		 * The restaurants_settings_tabs filter.
		 *
		 * @var 		array 		$default_tabs 		The default tabs.
		 */
		$this->tabs = apply_filters( 'restaurants_settings_tabs', $default_tabs );

	} // register_tabs()

	/**
	 * Saves activations errors to a plugin setting.
	 *
	 * @hooked 		activated_plugin
	 * @since 		1.0.0
	 */
	public function save_activation_errors() {

		update_option( 'restaurants-errors', ob_get_contents() );

	} // save_activation_errors()

	/**
	 * Includes the settings section partial file based on the section ID.
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function sections( $params ) {

		switch ( $params['id'] ) :

			case RESTAURANTS_SETTINGS: 	$params['description'] = __( '', 'restaurants' );

		endswitch;

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/sections/settings.php' );

	} // section_settingssection()

	/**
	 * Validates saved settings
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin settings
	 * @return 		array 						array of validated plugin settings
	 */
	public function validate_settings( $input ) {

		$valid = array();

		foreach ( $this->settings as $setting ) {

			$sanitizer 				= new Inc\Sanitize();
			$valid[$setting[0]] 	= $sanitizer->clean( $input[$setting[0]], $setting[1] );

			if ( $valid[$setting[0]] != $input[$setting[0]] && 'checkbox' !== $setting[1] ) {

				add_settings_error( $setting[0], $setting[0] . '_error', $setting[0] . ' error.', 'error' );

			}

			unset( $sanitizer );

		}

		return $valid;

	} // validate_settings()

} // class
