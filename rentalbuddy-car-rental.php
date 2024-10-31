<?php
/***
	Plugin Name: RentalBuddy - Car Rental Management
	Plugin URI: https://www.webfulcreations.com
	Description: RentalBuddy is a helpful WordPress plugin which provides you car rental calculator and booking functionality
	Version: 1.0
	Author: Webful Creations
	Author URI: https://www.webfulcreations.com/
	License: GPLv2 or later.
	License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
	Text Domain: rentalbuddy
	Domain Path: languages
	Requires at least: 5.0
	Tested up to: 6.1.1
	Requires PHP: 7.4

	@package : 1.0
 */
if ( ! defined( 'ABSPATH' ) ) { 
	exit;
}
if ( ! defined( 'DS' ) ) {
	define( 'DS', '/' );
}

define( 'RENTALBUDDY_VER', '1.5' );

if ( ! function_exists( 'rentalbuddy_language_init' ) ) :
	function rentalbuddy_language_init() {
		load_plugin_textdomain( 'rentalbuddy', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	add_action( 'plugins_loaded', 'rentalbuddy_language_init' );
endif;

// Define folder name.
define( 'RENTALBUDDY_FOLDER', 	dirname( plugin_basename( __FILE__ ) ) );
define( 'RENTALBUDDY_DIR', 	  	plugin_dir_path( __FILE__ ) );
define( 'RENTALBUDDY_DIR_URL', 	plugins_url( '', __FILE__ ) );

require_once RENTALBUDDY_DIR . 'lib' . DS . 'includes' . DS . 'activate.php';
require_once RENTALBUDDY_DIR . 'lib' . DS . 'includes' . DS . 'update.php';

register_activation_hook( __FILE__, 'rentalbuddy_install' );


require_once RENTALBUDDY_DIR . 'lib' . DS . 'includes' . DS . 'admin_menu.php';
require_once RENTALBUDDY_DIR . 'lib' . DS . 'includes' . DS . 'theme_functions.php';
require_once RENTALBUDDY_DIR . 'lib' . DS . 'includes' . DS . 'main_page.php';
require_once RENTALBUDDY_DIR . 'lib' . DS . 'includes' . DS . 'wc_cars.php';
require_once RENTALBUDDY_DIR . 'lib' . DS . 'classes' . DS . 'index.php';
require_once RENTALBUDDY_DIR . 'lib' . DS . 'templates' . DS . 'main_templates.php';
require_once RENTALBUDDY_DIR . 'lib' . DS . 'shortcodes' . DS . 'rentalbuddy_calulator.php';


// Admin pages ends here.
if ( ! function_exists( 'rentalbuddy_front_scripts' ) ) :
	function rentalbuddy_front_scripts() {
		global $post;

		wp_enqueue_style( 'plugin-styles-rentalbuddy', plugins_url( 'assets/css/style.css', __FILE__ ), array(), RENTALBUDDY_VER, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'rentalbuddy_front_scripts' );
endif;

if ( ! function_exists( 'rentalbuddy_admin_scripts' ) ) :
	/**
	 * Adding Styles and Scripts
	 * To WordPress Admin side
	 *
	 * @Since 1.0.1
	 */
	function rentalbuddy_admin_scripts() {
		global $pagenow;

		$current_page = get_current_screen();
		
		$rs_pr_the_page  = ( isset( $_GET['page'] ) ) ? sanitize_text_field( $_GET['page'] ) : "";

		if ( ( isset( $rs_pr_the_page ) && ( 'rentalbuddy_settings_handle' === $rs_pr_the_page ) ) ) {

			if ( 'edit.php' !== $pagenow ) {
				// Foundation CSS enque.
				wp_register_style( 'foundation-css', plugins_url( 'assets/admin/css/foundation.min.css', __FILE__ ), array(), '6.5.3', 'all', true );
				wp_enqueue_style( 'foundation-css' );

				wp_enqueue_style( 'wc-admin-style', plugins_url( 'assets/admin/css/style.css', __FILE__ ), array(), RENTALBUDDY_VER, 'all' );
			}

			//Admin styles enque
			wp_enqueue_style( 'select2', plugins_url( 'assets/admin/css/select2.min.css', __FILE__ ), array(), '4.0.13', 'all' );

			//Admin JS enque
			wp_enqueue_script( 'foundation-js', plugins_url( 'assets/admin/js/foundation.min.js', __FILE__ ), array( 'jquery' ), '6.5.3', true );
			wp_enqueue_script( 'select2', plugins_url( 'assets/admin/js/select2.min.js', __FILE__ ), array( 'jquery' ), '4.0.13', true );
			wp_enqueue_script( 'rs-js', plugins_url( 'assets/admin/js/my-admin.js', __FILE__ ), array( 'jquery' ), RENTALBUDDY_VER, true );

			wp_enqueue_script( 'ajax_script', plugins_url( 'assets/admin/js/ajax_scripts.js', __FILE__ ), array('jquery'), RENTALBUDDY_VER, true );
			wp_localize_script( 'ajax_script', 'ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
	}
	add_action( 'admin_enqueue_scripts', 'rentalbuddy_admin_scripts', 1 );
endif;

if ( ! function_exists( 'rentalbuddy_ajax_script_enqueue' ) ) :
	/**
	 * Ajax Script Enque
	 * For Front-End
	 *
	 * @Since 1.0.0
	 */
	function rentalbuddy_ajax_script_enqueue() {
		wp_enqueue_script( 'ajax_sc_script', plugin_dir_url( __FILE__ ) . 'assets/js/ajax_scripts.js', array( 'jquery' ), RENTALBUDDY_VER, true );
		wp_localize_script( 'ajax_sc_script', 'ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
	add_action( 'wp_enqueue_scripts', 'rentalbuddy_ajax_script_enqueue' );
endif;