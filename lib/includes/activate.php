<?php
if ( ! defined( 'ABSPATH' ) ) { 
	exit;
}

if ( ! function_exists( 'rentalbuddy_install' ) ) : 
	function rentalbuddy_install() {
		//Installs default values on activation.
		global $wpdb;
		require_once( ABSPATH .'wp-admin/includes/upgrade.php' );
		
		$charset_collate = $wpdb->get_charset_collate();
	
		update_option( "rentalbuddy_version", RENTALBUDDY_VER );
	}
endif;
