<?php
	defined( 'ABSPATH' ) || exit;

	/**
	 * Register post type
	 * Cars with Taxnomy Manufactures
	 * To be used as rental items.
	 */
	if ( ! function_exists( 'rentalbuddy_cars_post_init' ) ) :
		function rentalbuddy_cars_post_init() {
			$labels = array(
				'add_new_item' 			=> esc_html__('Add New Car', 'rentalbuddy'),
				'singular_name' 		=> esc_html__('Car', 'rentalbuddy'), 
				'menu_name' 			=> esc_html__('Cars', 'rentalbuddy'),
				'all_items' 			=> esc_html__('All Cars', 'rentalbuddy'),
				'edit_item' 			=> esc_html__('Edit ', 'rentalbuddy'),
				'new_item' 				=> esc_html__('New ', 'rentalbuddy'),
				'view_item' 			=> esc_html__('View ', 'rentalbuddy'),
				'search_items' 			=> esc_html__('Search ', 'rentalbuddy'),
				'not_found' 			=> esc_html__('Nothing found', 'rentalbuddy'),
				'not_found_in_trash' 	=> esc_html__('Nothing in trash', 'rentalbuddy')
			);
			$args = array(
				'labels'             	=> $labels,
				'label'					=> esc_html__('Cars', 'rentalbuddy'),
				'description'        	=> esc_html__('Cars Section', 'rentalbuddy'),
				'public'             	=> false,
				'publicly_queryable' 	=> true,
				'show_ui'            	=> true,
				'show_in_menu'       	=> false,
				'query_var'          	=> true,
				'rewrite'            	=> array('slug' => 'rb_cars'),
				'capability_type'    	=> 'post',
				'has_archive'        	=> true,
				'menu_icon'			 	=> 'dashicons-clipboard',
				'menu_position'      	=> 30,
				'supports'           	=> array( 'title', 'thumbnail' ), 	
				'register_meta_box_cb' 	=> 'rentalbuddy_cars_features',
				'taxonomies' 			=> array( 'car_manufactures' )
			);
			register_post_type('rb_cars', $args);
		}
		add_action( 'init', 'rentalbuddy_cars_post_init');
		//registeration of post type ends here.
	endif;

	if ( ! function_exists( 'rentalbuddy_cars_manufactures_init' ) ) :
		add_action( 'init', 'rentalbuddy_cars_manufactures_init' );
		function rentalbuddy_cars_manufactures_init() {
			$wc_device_brand_label        = esc_html__( 'Manufacture', 'rentalbuddy' );
			$wc_device_brand_label_plural = esc_html__( 'Manufactures', 'rentalbuddy' );

			$labels = array(
				'name'              => $wc_device_brand_label_plural,
				'singular_name'     => $wc_device_brand_label,
				'search_items'      => esc_html__( 'Search ', 'rentalbuddy' ) . $wc_device_brand_label_plural,
				'all_items'         => esc_html__( 'All ', 'rentalbuddy' ) . $wc_device_brand_label_plural,
				'parent_item'       => esc_html__( 'Parent ', 'rentalbuddy' ) . $wc_device_brand_label,
				'parent_item_colon' => esc_html__( 'Parent ', 'rentalbuddy' ) . $wc_device_brand_label,
				'edit_item'         => esc_html__( 'Edit ', 'rentalbuddy' ) . $wc_device_brand_label,
				'update_item'       => esc_html__( 'Update ', 'rentalbuddy' ) . $wc_device_brand_label,
				'add_new_item'      => esc_html__( 'Add New ', 'rentalbuddy' ) . $wc_device_brand_label,
				'new_item_name'     => esc_html__( 'New Name', 'rentalbuddy' ),
				'menu_name'         => $wc_device_brand_label,
			);
			
			$args = array(
					'label'   => $wc_device_brand_label,
					'rewrite' => array('slug' => 'rb_manufactures'),
					'public'  => true,
					'labels'  			=> $labels,
					'hierarchical' => true,
					'show_admin_column' => true,	
			);
			
			register_taxonomy(
				'car_manufactures',
				'rb_cars',
				$args
			);
		} //Registration of Taxanomy Ends here.
	endif;

	if ( ! function_exists( 'rentalbuddy_cars_features' ) ) :
		function rentalbuddy_cars_features() { 
			$screens = array('rb_cars');
		
			foreach ( $screens as $screen ) {
				add_meta_box(
					'myplugin_sectionid',
					esc_html__( 'Car Details', 'rentalbuddy' ),
					'rentalbuddy_features_callback',
					$screen,
					'advanced',
					'high'
				);
			}
		} //Parts features post.
		add_action( 'add_meta_boxes', 'rentalbuddy_cars_features');
	endif;
		
	if ( ! function_exists( 'rentalbuddy_features_callback' ) ) :
		function rentalbuddy_features_callback( $post ) {
		
			wp_nonce_field( 'wc_meta_box_nonce', 'rentalbuddy_features_sub' );
			settings_errors();

			echo '<table class="form-table">';
			
			$value = get_post_meta( $post->ID, '_transmission', true );
			
			$auto = 'checked';
			$manual = '';
			if ( $value == 'Manual' ) {
				$auto = '';
				$manual = 'checked';
			}

			echo '<tr><td scope="row"><label for="transmission">'.esc_html__( 'Transmission', 'rentalbuddy' ).'</label></td><td>';
			echo '<label><input ' . esc_attr( $auto ) . ' type="radio" class="regular-text" name="transmission" value="Automatic" />' . esc_html__( 'Automatic', 'rentalbuddy' ) . '</label><br>';
			echo '<label><input ' . esc_attr( $manual ) . ' type="radio" class="regular-text" name="transmission" value="Manual" />' . esc_html__( 'Manual', 'rentalbuddy' ) . '</label>';
			echo '</td></tr>';
			
			$value = get_post_meta( $post->ID, '_hourly_rate', true );
			$value = ( empty( $value ) ) ? '9.00' : $value;

			echo '<tr><td scope="row">
			<label for="hourly_rate">'.esc_html__( 'Hourly Rate', 'rentalbuddy' ).'</label></td><td>';
			echo '<input type="text" class="regular-text" name="hourly_rate" id="hourly_rate" value="'.esc_attr($value). '" />';
			echo '</td></tr>';
			
			$value = get_post_meta( $post->ID, '_daily_rate', true );
			$value = ( empty( $value ) ) ? '50.00' : $value;
		
			echo '<tr><td scope="row"><label for="daily_rate">'.esc_html__( "Daily Rate", 'rentalbuddy' ).'</label></td><td>';
			echo '<input type="number" class="regular-text" name="daily_rate" step="any" value="'.esc_attr( $value ). '" />';
			echo '</td></tr>';

			$value = get_post_meta( $post->ID, '_weekly_rate', true );
			$value = ( empty( $value ) ) ? '250.00' : $value;
		
			echo '<tr><td scope="row"><label for="weekly_rate">'.esc_html__( "Weekly Rate", 'rentalbuddy' ).'</label></td><td>';
			echo '<input type="number" class="regular-text" name="weekly_rate" step="any" value="'.esc_attr( $value ). '" />';
			echo '</td></tr>';
			
			$value = get_post_meta( $post->ID, '_extramilage', true );
			$value = ( empty( $value ) ) ? '0.24' : $value;

			echo '<tr><td scope="row"><label for="extramilage">'.esc_html__( 'Extra Mileage Price', 'rentalbuddy' ).'</label></td><td>';
			echo '<input type="text" class="regular-text" name="extramilage" id="extramilage" value="'.esc_attr($value). '" />';
			echo '</td></tr>';

			$rb_daily_mileage_allow  = get_option( 'rb_daily_mileage_allow' );
			$value = get_post_meta( $post->ID, '_dailyallowancekm', true );
			$value = ( empty( $value ) ) ? $rb_daily_mileage_allow : $value;

			echo '<tr><td scope="row"><label for="dailyallowancekm">'.esc_html__( 'Daily allowed Mileage', 'rentalbuddy' ).'</label></td><td>';
			echo '<input type="text" class="regular-text" name="dailyallowancekm" id="dailyallowancekm" value="'.esc_attr($value). '" />';
			echo '</td></tr>';

			$rb_weekly_mileage_allow = get_option( 'rb_weekly_mileage_allow' );
			$value = get_post_meta( $post->ID, '_weeklyallowancekm', true );
			$value = ( empty( $value ) ) ? $rb_weekly_mileage_allow : $value;

			echo '<tr><td scope="row"><label for="weeklyallowancekm">'.esc_html__( 'Weekly allowed Mileage', 'rentalbuddy' ).'</label></td><td>';
			echo '<input type="text" class="regular-text" name="weeklyallowancekm" id="weeklyallowancekm" value="'.esc_attr($value). '" />';
			echo '</td></tr>';

			$rb_hourly_mileage_allow = get_option( 'rb_hourly_mileage_allow' );
			$value = get_post_meta( $post->ID, '_hourlyallowancekm', true );
			$value = ( empty( $value ) ) ? $rb_hourly_mileage_allow : $value;

			echo '<tr><td scope="row"><label for="hourlyallowancekm">'.esc_html__( 'Hourly allowed Mileage', 'rentalbuddy' ).'</label></td><td>';
			echo '<input type="text" class="regular-text" name="hourlyallowancekm" id="hourlyallowancekm" value="'.esc_attr($value). '" />';
			echo '</td></tr>';

			$value = get_post_meta( $post->ID, '_specs', true );
			$value = ( empty( $value ) ) ? '' : $value;

			echo '<tr><td scope="row"><label for="specs">'.esc_html__( 'Specifications', 'rentalbuddy' ).'</label></td><td>';

			$custom_editor_id   = "specs";
			$custom_editor_name = "specs";
			$args = array(
					'media_buttons' => false,
					'textarea_name' => $custom_editor_name,
					'textarea_rows' => get_option('default_post_edit_rows', 10),
					'quicktags' 	=> false,
				);
			wp_editor( $value, $custom_editor_id, $args );
			echo '</td></tr>';

			echo '</table>';
		}
	endif;
	
	/**
	 * Save infor.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	if ( ! function_exists( 'rentalbuddy_features_save_box' ) ) :
		function rentalbuddy_features_save_box( $post_id ) {
			// Verify that the nonce is valid.
			if (!isset( $_POST['rentalbuddy_features_sub']) || ! wp_verify_nonce( $_POST['rentalbuddy_features_sub'], 'wc_meta_box_nonce' )) {
				return;
			}
		
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
		
			// Check the user's permissions.
			if ( isset( $_POST['post_type'] )) {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}
		
			//Form PRocessing
			$submission_values = array(
								"transmission",
								"hourly_rate",
								"daily_rate",
								"weekly_rate",
								"disable",
								"extramilage",
								"specs",
								"dailyallowancekm",
								"weeklyallowancekm",
								"hourlyallowancekm",
								);
		
			foreach( $submission_values as $submit_value ) {
				$my_value = sanitize_text_field( $_POST[$submit_value] );
				if ( $submit_value == 'specs' ) {
					$my_value = wp_kses_post( $_POST[$submit_value] );
				}
				update_post_meta( $post_id, '_'.$submit_value, $my_value );
			}
		}
		add_action( 'save_post', 'rentalbuddy_features_save_box' );
	endif;