<?php
/**
 * RentalBuddy Admin Pages
 * Adds pages to backend
 *
 * @Since 1.0.0
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'rentalbuddy_admin_pages' ) ) : 
	function rentalbuddy_admin_pages() {
		add_menu_page( esc_html__( 'RentalBuddy', 'rentalbuddy' ), esc_html__( 'RentalBuddy', 'rentalbuddy' ), 
		'manage_options', 'rentalbuddy_settings_handle', 'rentalbuddy_main_settings_page', esc_url( RENTALBUDDY_DIR_URL . '/assets/admin/images/rentalbuddy-small.png' ), '70' );

		add_submenu_page( 'rentalbuddy_settings_handle', esc_html__( 'Cars', 'rentalbuddy' ), esc_html__( 'Cars', 'rentalbuddy' ), 
		'manage_options', 'edit.php?post_type=rb_cars' );
		add_submenu_page( 'rentalbuddy_settings_handle', esc_html__( 'Manufactures', 'rentalbuddy' ), esc_html__( 'Manufactures', 'rentalbuddy' ), 
		'manage_options', 'edit-tags.php?taxonomy=car_manufactures&post_type=rb_cars' );

		add_submenu_page( 'rentalbuddy_settings_handle', esc_html__( 'Bookings', 'rentalbuddy' ), esc_html__( 'Bookings', 'rentalbuddy' ), 
		'manage_options', 'rb_booking_features', 'rb_booking_features' );
		add_submenu_page( 'rentalbuddy_settings_handle', esc_html__( 'Clients', 'rentalbuddy' ), esc_html__( 'Clients', 'rentalbuddy' ), 
		'manage_options', 'rb_booking_clients', 'rb_booking_features' );
	}
	add_action( 'admin_menu', 'rentalbuddy_admin_pages' );
endif;

function rb_booking_features() {
	?>
	<h2>Rental Bookings</h2>
	<p>This feature is available in our pro version. This will let your customers book from front end and you would able to see bookings and customers in backend. There is no online payment support available right now for bookings. <br><br><br>
		<a href="https://www.webfulcreations.com/products/rentalbuddy-car-rental-management-wordpress-plugin/" target="_blank" class="button button-primary secondary">Get Pro Version</a>
</p>

	<?php
}