<?php
/**
 * The file contains the functions related to Shortcode Pages
 *
 * Help setup pages to they can be used in notifications and other items
 *
 * @package rentalbuddy
 * @version 3.7947
 */

defined( 'ABSPATH' ) || exit;

class RENTALBUDDY_MAIN_SETTINGS {

	private $TABID = 'wc_rb_main_settings';

	function __construct() {
        add_action( 'rentalbuddy_setting_menu_action', array( $this, 'add_main_menu_settings_menu' ), 10, 2 );
        add_action( 'rentalbuddy_setting_tab_action', array( $this, 'add_main_menu_settings_body' ), 10, 2 );
		add_action( 'wp_ajax_rentalbuddy_form_submit_main_settings', array( $this, 'rentalbuddy_form_submit_main_settings' ) );
    }

	function add_main_menu_settings_menu() {
        $active = ' active is-active';

        $menu_output = '<li class="tabs-title' . esc_attr($active) . '" role="presentation">';
        $menu_output .= '<a href="#' . $this->TABID . '" role="tab" aria-controls="' . $this->TABID . '" aria-selected="true" id="' . $this->TABID . '-label">';
        $menu_output .= '<h2>' . esc_html__( 'Settings', 'rentalbuddy' ) . '</h2>';
        $menu_output .=	'</a>';
        $menu_output .= '</li>';

        echo wp_kses_post( $menu_output );
    }
	
	function add_main_menu_settings_body() {
        global $wpdb;

        $active = ' active is-active';

		$rb_daily_mileage_allow = ( empty ( get_option( 'rb_daily_mileage_allow' ) ) ) ? '75' : get_option( 'rb_daily_mileage_allow' );
		$rb_weekly_mileage_allow = ( empty ( get_option( 'rb_weekly_mileage_allow' ) ) ) ? '300' : get_option( 'rb_weekly_mileage_allow' );
		$rb_hourly_mileage_allow = ( empty ( get_option( 'rb_hourly_mileage_allow' ) ) ) ? '15' : get_option( 'rb_hourly_mileage_allow' );

		$setting_body = '<div class="tabs-panel team-wrap' . esc_attr($active) . '" 
        id="' . $this->TABID . '" role="tabpanel" aria-hidden="true" aria-labelledby="' . $this->TABID . '-label">';

		$setting_body .= '<div class="rs_pr_main_settings">';
		
		$setting_body .= '<h2>' . esc_html__( 'Main Settings - RentalBuddy', 'rentalbuddy' ) . '</h2>';
		$setting_body .= '<div class="rb_settings_success_message"></div>';
		
		$setting_body .= '<form data-async data-abide class="needs-validation" novalidate method="post" data-success-class=".rb_settings_success_message">';

		$setting_body .= '<table class="form-table border"><tbody>';

		$setting_body .= '<tr>';
		$setting_body .= '<th scope="row"><label for="rb_daily_mileage_allow">' . esc_html__( 'Mileage Allowance', 'rentalbuddy' ) . '</label></th>';

		$setting_body .= '<td><table class="form-table no-padding-table"><tr>';
		$setting_body .= '<td><label for="rb_weekly_mileage_allow">' . esc_html__( 'Weekly Allowance', 'rentalbuddy' );
		$setting_body .= '<input name="rb_weekly_mileage_allow" id="rb_weekly_mileage_allow" class="regular-text" value="' . esc_html( $rb_weekly_mileage_allow ) . '" type="number" 
		 /></label></td>';

		$setting_body .= '<td><label for="rb_daily_mileage_allow">' . esc_html__( 'Daily Allowance', 'rentalbuddy' );
		$setting_body .= '<input name="rb_daily_mileage_allow" id="rb_daily_mileage_allow" class="regular-text" value="' . esc_html( $rb_daily_mileage_allow ) . '" type="number" 
		  /></label></td>';

	    $setting_body .= '<td><label for="rb_hourly_mileage_allow">' . esc_html__( 'Hourly Allowance', 'rentalbuddy' );
		$setting_body .= '<input name="rb_hourly_mileage_allow" id="rb_hourly_mileage_allow" class="regular-text" value="' . esc_html( $rb_hourly_mileage_allow ) . '" type="number" 
		   /></label></tr></table></td></tr>';

		$setting_body .= '</tbody></table>';

		$setting_body .= '<input type="hidden" name="form_type" value="rb_settings_form" />';
		$setting_body .= wp_nonce_field( 'rs_pr_main_settings_form_nonce', 'rs_pr_main_settings_form_nonce_field', true, false );

		$setting_body .= '<button type="submit" class="button button-primary" data-type="rbssubmitdevices">' . esc_html__( 'Save Settings!', 'rentalbuddy' ) . '</button></form>';

		$setting_body .= '</div><!-- wc rb Devices /-->';
		$setting_body .= '</div><!-- Tabs Panel /-->';

		$allowedHTML = ( function_exists( 'rentalbuddy_allowed_tags' ) ) ? rentalbuddy_allowed_tags() : '';
		echo wp_kses( $setting_body, $allowedHTML );
	}

	function rentalbuddy_form_submit_main_settings() {
		$message = '';
		$success = 'NO';

		if ( ! isset( $_POST['rs_pr_main_settings_form_nonce_field'] ) || ! wp_verify_nonce( $_POST['rs_pr_main_settings_form_nonce_field'], 'rs_pr_main_settings_form_nonce' ) ) {
			$message = esc_html__( 'Couldn\'t verify nonce please reload page.', 'rentalbuddy' );
		} else {
			// process form data
			$rb_weekly_mileage_allow  = ( isset( $_POST['rb_weekly_mileage_allow'] ) ) ? sanitize_text_field( $_POST['rb_weekly_mileage_allow'] ) : '';
			$rb_daily_mileage_allow   = ( isset( $_POST['rb_daily_mileage_allow'] ) ) ? sanitize_text_field( $_POST['rb_daily_mileage_allow'] ) : '';
			$rb_hourly_mileage_allow   = ( isset( $_POST['rb_hourly_mileage_allow'] ) ) ? sanitize_text_field( $_POST['rb_hourly_mileage_allow'] ) : '';

			update_option( 'rb_weekly_mileage_allow', $rb_weekly_mileage_allow );
			update_option( 'rb_daily_mileage_allow', $rb_daily_mileage_allow );
			update_option( 'rb_hourly_mileage_allow', $rb_hourly_mileage_allow );

			$message = esc_html__( 'Settings updated!', 'rentalbuddy' );
		}

		$values['message'] = $message;
		$values['success'] = $success;

		wp_send_json( $values );
		wp_die();
	}
} // Class Ends here.
$RENTALBUDDY_MAIN_SETTINGS = new RENTALBUDDY_MAIN_SETTINGS;