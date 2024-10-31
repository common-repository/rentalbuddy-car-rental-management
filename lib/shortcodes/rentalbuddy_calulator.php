<?php
defined( 'ABSPATH' ) || exit;

//List Products shortcode
//Used to display Products on a page.
//Linked to single product pages. 

if ( ! function_exists( 'rentalbuddy_calculator' ) ) :
	function rentalbuddy_calculator( $attr ) { 
		$showcars = ( isset( $attr['showcars'] ) && $attr['showcars'] == 'NO' ) ? 'NO' : 'YES';

		$content = '';
		$content .= '<div class="Car-Cost-container">';
		$content .= '<div class="Car-Cost">';
		//$content .= '<div class="Car-Cost-top-text Calculator"><h2>Cost Calculator</h2></div>';

		$content .= '<form action="" id="getcalculations" method="post"><div class="Car-Cost-form">';

		$content .= '<div class="form-col"><div class="form-col-text">';
		$content .= '<label for="car">' . esc_html__( 'Select Vehicle', 'rentalbuddy' ) . '</label>';
		$content .= '<select class="form-select" name="thevehselected" id="thevehselected">';
		$content .= wc_return_car_options();
		$content .= '</select>';
		$content .= '</div></div>';

		$datenow = wp_date( 'Y-m-d' );
		$timenow = wp_date( 'H:i:s' );

		$content .= '<div class="form-col"><div class="form-col-text">
							<label for="Pickupdate">' . esc_html__( 'Pick Up Date', 'rentalbuddy' ) . '</label>
							<input class="VehicleType" type="date" value="' . esc_html( $datenow ) . '" id="pickupdate" name="pickupdate">
						</div></div>';

		$content .= '<div class="form-col"><div class="form-col-text">
						<label for="pickuptime">' . esc_html__( 'Pick Up Time', 'rentalbuddy' ) . '</label>
						<input class="VehicleType" type="time" value="' . esc_html( $timenow ) . '" id="pickuptime" name="pickuptime">
					</div></div>';

		$content .= '<div class="form-col"><div class="form-col-text">
					<label for="returndate">' . esc_html__( 'Return Date', 'rentalbuddy' ) . '</label>
					<input class="VehicleType" type="date" value="' . esc_html( $datenow ) . '" id="returndate" name="returndate">
				</div></div>';

		$content .= '<div class="form-col"><div class="form-col-text">
				<label for="returntime">' . esc_html__( 'Return Time', 'rentalbuddy' ) . '</label>
				<input class="VehicleType" type="time" value="' . esc_html( $timenow ) . '" id="returntime" name="returntime">
			</div></div>';

		$content .= '<div class="form-col"><div class="form-col-text">
					<label for="Additionalkm">' . esc_html__( 'KM driven', 'rentalbuddy' ) . '</label>
					<input class="VehicleType" id="Additionalkm" step="10" type="number"  name="Additionalkm" />
				</div></div>';

		$content .= '</div>';

		$content .= '<div class="Car-Cost-btn button-box"><button class="btn btn-primary" type="submit">' . esc_html__( 'Calculate', 'rentalbuddy' ) . '</button></div>';
		$content .= '</div><!--CarCost /--></form>';

		$content .= '<div class="calculations_output" id="calculations_output"></div>';		

		if ( $showcars == 'YES' ) {
			$content .= rentalbuddy_return_the_cars();
		}
		$content .= '</div><!-- Container /-->';

		$allowedTags = rentalbuddy_allowed_tags();
		
		return wp_kses( $content, $allowedTags );
	}//wc_list_products.
	add_shortcode( 'rentalbuddy_calculator', 'rentalbuddy_calculator' );
endif;

if ( ! function_exists( 'rentalbuddy_return_the_cars' ) ) :
	function rentalbuddy_return_the_cars() {
		$transmission = $output = '';

		$transmission = 'Any';

		if ( $transmission == 'Any' ) {
			$args = array(
				'post_type'      => array( 'rb_cars' ),
				'post_status'    => array( 'publish' ),
				'posts_per_page' => '-1',
				'order'          => 'ASC',
				'orderby'        => 'title',
			);
		} else {	
			$args = array(
				'post_type'      => array( 'rb_cars' ),
				'post_status'    => array( 'publish' ),
				'posts_per_page' => '-1',
				'order'          => 'ASC',
				'orderby'        => 'title',
				'meta_query' => array(
					array(
						'key'     => '_transmission',
						'value'   => $transmission,
						'compare' => '=',
					),
				),
			);
		}
		
		// The Query
		$query = new WP_Query( $args );
		$counter = 0;
		// The Loop
		if ($query->have_posts()) {
			$output .= '<div class="cars-vehcile">
							<div class="cars-vehcile-text">
								<h2>' . esc_html__( 'RATES', 'rentalbuddy' ) . '</h2>
							</div>';
			$output .= '<div class="cars-vehcile-row">';						

			while ($query->have_posts()) {
				$query->the_post();
				global $post;

				$hourly = get_post_meta( $post->ID, '_hourly_rate', true );
				$daily  = get_post_meta( $post->ID, '_daily_rate', true );
				$specs  = get_post_meta( $post->ID, '_specs', true );
				$dailyallowancekm  = get_post_meta( $post->ID, '_dailyallowancekm', true );

				$output .= '<div class="cars-vehcile-col">';
				$output .= '<h3>' . get_the_title() . '</h3>';

				$output .= '<div class="body-img">';

				$output .= '<div class="cars-vehcile-col-md-6"><div class="left-side">';
				$feat_image =   wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ), 'medium');
				$output .= '<img src="' . $feat_image[0] . '">';
				$output .= '</div></div>';
						
				$output .= '<div class="cars-vehcile-col-md-6">';
				$output .= '<div class="right-side">';
				$output .= '<div class="hour-price">';
				$output .= '€' . number_format( $hourly, 2 ) . '<span>/' . esc_html__( 'hour', 'rentalbuddy' ) . '</span>';
				$output .= '</div>';
				$output .= '<div class="day-price">';
				$output .= '<span>€' . number_format( $daily, 2 ) . '/' . esc_html__( 'day', 'rentalbuddy' ) . '</span>';
				$output .= '</div>';

				if ( ! empty( $dailyallowancekm ) ) :
					$output .= '<div class="kmdriven">';
					$output .= '<span>' . esc_attr( $dailyallowancekm ) . esc_html__( 'KM Free/day', 'rentalbuddy' ) . '</span>';
					$output .= '</div>';
				endif;

				$output .= '</div><!-- Right Side /-->';
				$output .= '</div><!-- Vehicle Column /-->';

				$output .= '</div>';

				$output .= '<div class="description">' . $specs . '</div>';
				$output .= '</div>';

				$counter++;
			}
			$output .= '</div></div>';
		} else {
			$output .= '<p>' . esc_html__( 'Nothing found please add some trasnports', 'rentalbuddy' ) . '</p>';
		}

		wp_reset_postdata();

		$allowedTags = rentalbuddy_allowed_tags();
		$output 	 = wp_kses( $output, $allowedTags );

		if ( isset( $_POST['ajax_data'] ) && $_POST['ajax_data'] == 'YES' ) {
			$values['message'] = $output;
			$$values['success'] = 'YES';

			wp_send_json($values);
			wp_die();
		} else {
			return $output;
		}
	}
endif;

if ( ! function_exists( 'rentalbuddy_new_calculations' ) ) : 
	function rentalbuddy_new_calculations() {
		$thevehselected = $pickupdate = $pickuptime = $returndate = $returntime = $Additionalkm = $output = '';

		$thevehselected = ( isset( $_POST['thevehselected'] ) && ! empty( $_POST['thevehselected'] ) ) ? sanitize_text_field( $_POST['thevehselected'] ) : '';
		$pickupdate 	= ( isset( $_POST['pickupdate'] ) && ! empty( $_POST['pickupdate'] ) ) ? sanitize_text_field( $_POST['pickupdate'] ) : '';
		$pickuptime 	= ( isset( $_POST['pickuptime'] ) && ! empty( $_POST['pickuptime'] ) ) ? sanitize_text_field( $_POST['pickuptime'] ) : '';
		$returndate 	= ( isset( $_POST['returndate'] ) && ! empty( $_POST['returndate'] ) ) ? sanitize_text_field( $_POST['returndate'] ) : '';
		$returntime 	= ( isset( $_POST['returntime'] ) && ! empty( $_POST['returntime'] ) ) ? sanitize_text_field( $_POST['returntime'] ) : '';
		$Additionalkm 	= ( isset( $_POST['Additionalkm'] ) && ! empty( $_POST['Additionalkm'] ) ) ? sanitize_text_field( $_POST['Additionalkm'] ) : '';

		if ( empty( $thevehselected ) ) {
			$output = '<div class="calculationsTotalWrap">' . esc_html__( 'Please select transport', 'rentalbuddy' ) . '</div>';
		} elseif ( empty( $pickupdate ) ) {
			$output = '<div class="calculationsTotalWrap">' . esc_html__( 'Please select pickup date', 'rentalbuddy' ) . '</div>';
		} elseif ( empty( $pickuptime ) ) {
			$output = '<div class="calculationsTotalWrap">' . esc_html__( 'Please select pickup time', 'rentalbuddy' ) . '</div>';
		} elseif ( empty( $returndate ) ) {
			$output = '<div class="calculationsTotalWrap">' . esc_html__( 'Please select return date', 'rentalbuddy' ) . '</div>';
		} elseif ( empty( $returntime ) ) {
			$output = '<div class="calculationsTotalWrap">' . esc_html__( 'Please select return time', 'rentalbuddy' ) . '</div>';
		} else {
			//Let's start calculations.
			$rb_daily_mileage_allow  = get_option( 'rb_daily_mileage_allow' );
			$rb_hourly_mileage_allow = get_option( 'rb_hourly_mileage_allow' );
			$rb_weekly_mileage_allow = get_option( 'rb_weekly_mileage_allow' );

			$dailyAllowanceKM  = ( empty( $rb_daily_mileage_allow ) ) ? '75' : $rb_daily_mileage_allow;
			$hourlyAllowanceKM = ( empty( $rb_hourly_mileage_allow ) ) ? '15' : $rb_hourly_mileage_allow;
			$weeklyAllowanceKM = ( empty( $rb_weekly_mileage_allow ) ) ? '300' : $rb_weekly_mileage_allow;

			//PostMeta if exists
			$me_dailyallowancekm  = get_post_meta( $thevehselected, '_dailyallowancekm', true );
			$me_weeklyallowancekm = get_post_meta( $thevehselected, '_weeklyallowancekm', true );
			$me_hourlyallowancekm = get_post_meta( $thevehselected, '_hourlyallowancekm', true );

			$dailyAllowanceKM = ( ! empty( $me_dailyallowancekm ) ) ? $me_dailyallowancekm : $dailyAllowanceKM;
			$hourlyAllowanceKM = ( ! empty( $me_weeklyallowancekm ) ) ? $me_weeklyallowancekm : $hourlyAllowanceKM;
			$weeklyAllowanceKM = ( ! empty( $me_hourlyallowancekm ) ) ? $me_hourlyallowancekm : $weeklyAllowanceKM;

			$hourlyRate 	  = get_post_meta( $thevehselected, '_hourly_rate', true );
			$dailyRate 		  = get_post_meta( $thevehselected, '_daily_rate', true );
			$weeklyRate 	  = get_post_meta( $thevehselected, '_weekly_rate', true );
			$extraMilagePrice = get_post_meta( $thevehselected, '_extramilage', true );
			$thetransmission  = get_post_meta( $thevehselected, '_transmission', true );

			$output .= '<div class="calculationsTotalWrap">';

			$output .= '<div class="vehiclepicure">';
			$feat_image =   wp_get_attachment_image_src( get_post_thumbnail_id( $thevehselected ), 'medium');
			$output .= '<img src="' . $feat_image[0] . '">';
			$output .= '<h2>'. get_the_title( $thevehselected ) . '</h2>';
			$output .= '<h3>Transmission: '. $thetransmission . '</h3>';
			$output .= '</div><!-- Vehicle Picture /-->';
			
			$output .= '<div class="calc-item-subtotal-container calculations">';

			$date_format = get_option( 'date_format' ); 
			$time_format = get_option( 'time_format' );

			$receivedPickup = $pickupdate . ' ' . $pickuptime;
			$actualpickuptime = strtotime( $receivedPickup );

			$fromoutput = date( $date_format . ' ' . $time_format, $actualpickuptime );

			$receivedReturn = $returndate . ' ' . $returntime;
			$actualreturntime = strtotime( $receivedReturn );

			$tooutput = date( $date_format . ' ' . $time_format, $actualreturntime );

			$output .= '<div class="calc-item-subtotal-box from">
				<span class="sub-item-title"> ' . esc_html__( 'From', 'rentalbuddy' ) . ' </span>
				<span class="sub-item-space"></span>
				<span class="sub-item-value"> '.$fromoutput.' </span>
			</div>';

			$output .= '<div class="calc-item-subtotal-box to">
				<span class="sub-item-title"> ' . esc_html__( 'To', 'rentalbuddy' ) . ' </span>
				<span class="sub-item-space"></span>
				<span class="sub-item-value"> ' . $tooutput . ' </span>
			</div>';

			$difference = $actualreturntime - $actualpickuptime;
			$return_label = get_time_diff_label( $difference );

			$output .= '<div class="calc-item-subtotal-box to">
				<span class="sub-item-title"> ' . esc_html__( 'Booking For', 'rentalbuddy' ) . ' </span>
				<span class="sub-item-space"></span>
				<span class="sub-item-value"> ' . $return_label . ' </span>
			</div>';

			$bweek = $bdays = $bhours = $price = $allowed_milage = 0;

			while ( $difference >= 604800 ) {
				$bweek++;
				$difference = $difference - 604800;
			}
			while ( $difference >= 86400 ) {
				$bdays++;
				$difference = $difference - 86400;
			}
			while ( $difference >= 3600 ) {
				$bhours++;
				$difference = $difference - 3600;
			}

			$allowed_milage = ( $bweek * $weeklyAllowanceKM ) + ( $bdays * $dailyAllowanceKM ) + ( $bhours * $hourlyAllowanceKM );

			$output .= '<div class="calc-item-subtotal-box to">
				<span class="sub-item-title"> ' . esc_html__( 'Allowed Mileage', 'rentalbuddy' ) . ' </span>
				<span class="sub-item-space"></span>
				<span class="sub-item-value"> ' . $allowed_milage . ' </span>
			</div>';

			$output .= '<div class="calc-item-subtotal-box to">
				<span class="sub-item-title"> ' . esc_html__( 'Requested Mileage', 'rentalbuddy' ) . ' </span>
				<span class="sub-item-space"></span>
				<span class="sub-item-value"> ' . $Additionalkm . ' </span>
			</div>';

			$milageDiff = $Additionalkm - $allowed_milage;
			$additionalMilage = 0;

			if ( $milageDiff > 0 ) {
				$additionalMilage = $milageDiff;

				$output .= '<div class="calc-item-subtotal-box to">
					<span class="sub-item-title"> ' . esc_html__( 'Additional Mileage', 'rentalbuddy' ) . ' </span>
					<span class="sub-item-space"></span>
					<span class="sub-item-value"> ' . $additionalMilage . ' </span>
				</div>';
			}

			$extraMilagePrice = ( empty ( $extraMilagePrice ) ) ? 0 : $extraMilagePrice;
			$thePrice 	      = ( $bweek * $weeklyRate ) + ( $bdays * $dailyRate ) + ( $bhours * $hourlyRate );

			$total = ( $additionalMilage * $extraMilagePrice ) + $thePrice;

			$output .= '<div class="calc-item-subtotal-total total">
				<h3 class="sub-item-title">' . esc_html__( 'Total', 'rentalbuddy' ) . '</h3>
				<h3 class="sub-item-value">€ '.number_format( $total, 2 ).'</h3>
			</div>';

			$output .= '</div><!-- subtotal container /-->';
			$output .= '</div>';
		}

		$allowedTags = rentalbuddy_allowed_tags();
		$output 	 = wp_kses( $output, $allowedTags );	

		$values['message'] = $output;
		$$values['success'] = 'YES';

		wp_send_json( $values );
		wp_die();
	}
	add_action( 'wp_ajax_rentalbuddy_new_calculations', 'rentalbuddy_new_calculations' );
	add_action( 'wp_ajax_nopriv_rentalbuddy_new_calculations', 'rentalbuddy_new_calculations' );
endif;