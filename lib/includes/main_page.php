<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'rentalbuddy_main_settings_page' ) ) : 
	function rentalbuddy_main_settings_page() {
		if ( ! current_user_can('manage_options' ) ) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
		}
	?>
		<div class="main-container rentalbuddy">
			<div class="grid-x grid-container grid-margin-x grid-padding-y" style="width:100%;">
				<div class="small-12 cell">
					<div class="form-update-message"></div>
				</div>

				<div class="large-12 medium-12 small-12 cell">
					
					<div class="team-wrap grid-x" data-equalizer data-equalize-on="medium">

						<div class="cell medium-2 thebluebg">
							<div class="the-brand-logo">
								<a href="https://www.webfulcreations.com/" target="_blank">
									<img src="<?php echo esc_url( RENTALBUDDY_DIR_URL . '/assets/admin/images/rentalbuddy.png' ); ?>" alt="RentalBuddy Logo" />
								</a>
							</div>
							<ul class="vertical tabs thebluebg" data-tabs="82ulyt-tabs" id="example-tabs">
								<?php
									do_action( 'rentalbuddy_setting_menu_action' );
								?>
								<li class="thespacer"><hr></li>
								<li class="external-title">
									<a href="https://www.webfulcreations.com/contact-us/" target="_blank">
										<h2><span class="dashicons dashicons-buddicons-pm"></span> <?php echo esc_html__( 'Contact Us', 'rentalbuddy' ); ?></h2>
									</a>
								</li>
								<li class="external-title">
									<a href="https://facebook.com/webfulcreations" target="_blank">
										<h2><span class="dashicons dashicons-facebook"></span> <?php echo esc_html__( 'Chat With Us', 'rentalbuddy' ); ?></h2>
									</a>
								</li>
							</ul>
						</div>
						
						<div class="cell medium-10 thewhitebg">
							<div class="tabs-content vertical" data-tabs-content="example-tabs">
								<?php do_action( 'rentalbuddy_setting_tab_action' ); ?>
							</div><!-- tabs content ends -->
						</div>
					</div>
				</div><!-- Main Content Div Ends /-->
							
				<div class="large-4 medium-4 small-12 cell">
					<?php //Sidebar // ?>
				</div><!-- Sidebar Div Ends /-->

			</div><!-- Row Ends /-->
		</div>
	<?php	
	}
endif;