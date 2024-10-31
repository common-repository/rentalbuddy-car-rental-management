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

class RENTALBUDDY_DOCUMENTATION {

	private $TABID = 'rb_setting_documentation';

	function __construct() {
        add_action( 'rentalbuddy_setting_menu_action', array( $this, 'add_main_menu_documentation_menu' ), 10, 2 );
        add_action( 'rentalbuddy_setting_tab_action', array( $this, 'add_main_menu_documentation_body' ), 10, 2 );
    }

	function add_main_menu_documentation_menu() {
        $active = '';

        $menu_output = '<li class="tabs-title' . esc_attr($active) . '" role="presentation">';
        $menu_output .= '<a href="#' . $this->TABID . '" role="tab" aria-controls="' . $this->TABID . '" aria-selected="true" id="' . $this->TABID . '-label">';
        $menu_output .= '<h2>' . esc_html__( 'Documentation', 'rentalbuddy' ) . '</h2>';
        $menu_output .=	'</a>';
        $menu_output .= '</li>';

        echo wp_kses_post( $menu_output );
    }
	
	function add_main_menu_documentation_body() {
        global $wpdb;

        $active = '';

		$setting_body = '<div class="tabs-panel team-wrap' . esc_attr($active) . '" 
        id="' . $this->TABID . '" role="tabpanel" aria-hidden="true" aria-labelledby="' . $this->TABID . '-label">';

		$setting_body .= '<div class="rs_pr_main_settings">';
		
		$setting_body .= '<h2>' . esc_html__( 'Rental Buddy', 'rentalbuddy' ) . '</h2>';
		$setting_body .= '<div class="rs_pr_main_settings_msg"></div>';
		
		$setting_body .= '<p>' . esc_html__( 'Please use the shortcode below to add calculator into post or page.', 'rentalbuddy' ) . '</p>';

		$setting_body .= '<div class="callout code">[rentalbuddy_calculator]</div>';

		$setting_body .= '<p>' . esc_html__( 'To hide cars you can add showcars="NO" NO in capital to shortcode.', 'rentalbuddy' ) . '</p>';

		$setting_body .= '<div class="callout code">[rentalbuddy_calculator showcars=\'NO\']</div>';

		$setting_body .= '<form data-async data-abide class="needs-validation" novalidate method="post" data-success-class=".rs_pr_main_settings_msg">';

		$setting_body .= '<input type="hidden" name="form_type" value="rs_pr_form_main_settings" />';
		$setting_body .= wp_nonce_field( 'rs_pr_main_settings_form_nonce', 'rs_pr_main_settings_form_nonce_field', true, false );

		//$setting_body .= '<button type="submit" class="button button-primary" data-type="rbssubmitdevices">' . esc_html__( 'Save Settings!', 'rentalbuddy' ) . '</button></form>';

		$setting_body .= '</div><!-- wc rb Devices /-->';
		$setting_body .= '</div><!-- Tabs Panel /-->';

		$allowedHTML = ( function_exists( 'rentalbuddy_allowed_tags' ) ) ? rentalbuddy_allowed_tags() : '';
		echo wp_kses( $setting_body, $allowedHTML );
	}
} // Class Ends here.
$RENTALBUDDY_DOCUMENTATION = new RENTALBUDDY_DOCUMENTATION;