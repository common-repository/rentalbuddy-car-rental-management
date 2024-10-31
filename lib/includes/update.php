<?php
if ( ! defined( 'ABSPATH' ) ) { 
	exit;
}

$rs_pr_curr_ver = get_option( 'rentalbuddy_version' );

//Installation of plugin starts here.
if(!function_exists("rentalbuddy_update_plugin_features")):
	function rentalbuddy_update_plugin_features() {
		//Installs default values on activation.
		global $wpdb;
		require_once(ABSPATH .'wp-admin/includes/upgrade.php');
		
		$charset_collate = $wpdb->get_charset_collate();
	
	}//end of function wc_restaurant_install()
endif;	
	
/*
	check Update status and run functions
*/
if(	empty( $rs_pr_curr_ver ) || $rs_pr_curr_ver != RENTALBUDDY_VER ) {
	rentalbuddy_update_plugin_features();
	update_option( "rentalbuddy_version", RENTALBUDDY_VER );
}