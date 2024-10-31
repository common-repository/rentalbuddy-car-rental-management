<?php
	defined( 'ABSPATH' ) || exit;

	if ( ! function_exists( 'get_time_diff_label' ) ) :
		function get_time_diff_label( $difference ) {
			if ( empty ( $difference ) ) {
				return;
			}
		
			$hours = $days = $week = 0;
		
			while ( $difference >= 604800 ) {
				$week++;
				$difference = $difference - 604800;
			}
		
			while ( $difference >= 86400 ) {
				$days++;
				$difference = $difference - 86400;
			}
		
			while ( $difference >= 3600 ) {
				$hours++;
				$difference = $difference - 3600;
			}
		
			$output = '';
		
			if ( $week != 0 ) {
				$label = ( $week > 1 ) ? esc_html__( 'Weeks', 'rentalbuddy' ) : esc_html__( 'Week', 'rentalbuddy' );
				$output .= $week . ' ' . $label . ' ';
			}
			if ( $days != 0 ) {
				$label = ( $days > 1 ) ? esc_html__( 'Days', 'rentalbuddy' ) : esc_html__( 'Day', 'rentalbuddy' );
				$output .= $days . ' ' . $label . ' ';
			}
			if ( $hours != 0 ) {
				$label = ( $hours > 1 ) ? esc_html__( 'Hours', 'rentalbuddy' ) : esc_html__( 'Hour', 'rentalbuddy' );
				$output .= $hours . ' ' . $label . ' ';
			}
			
			return $output;
		}
	endif;

	/**
	 * Important functions to use site wide
	 */
	if ( ! function_exists( 'rentalbuddy_allowed_tags' ) ) :
		function rentalbuddy_allowed_tags() {
			$allowed_tags = array(
			'div' => array(
				'class' 		  => array(),
				'id' 			  => array(),
				'style' 		  => array(),
				'data-position'   => array(),
				'data-alignment'  => array(),
				'data-dropdown'   => array(),
				'data-auto-focus' => array(),
				'data-reveal' 	  => array(),
				'data-abide-error' => array(),
				'data-tab-content' => array(),
			),
			'form' => array(
				'class' => array(),
				'id' => array(),
				'name' => array(),
				'method' => array(),
				'action' => array(),
				'data-async' => array(),
				'data-success-class' => array(),
				'data-abide' => array()
			),
			'pre' => array(
				'class' => array(),
			),
			'label' => array(
				'class' => array(),
				'id' => array(),
				'for'	=> array()
			),
			'input' => array(
				'class' => array(),
				'id' => array(),
				'type'	=> array(),
				'name'	=> array(),
				'required' => array(),
				'value'	=> array(),
				'placeholder'	=> array(),
				'checked' => array(),
				'step'	=> array(),
			),
			'textarea' => array(
				'class' => array(),
				'id' => array(),
				'type'	=> array(),
				'name'	=> array(),
				'required' => array(),
				'placeholder'	=> array(),
				'cols'	=> array(),
				'rows' => array()
			),
			'select' => array(
				'class' => array(),
				'id' => array(),
				'name'	=> array(),
				'required' => array(),
				'data-security' => array(),
				'data-placeholder' => array(),
				'data-exclude_type' => array(),
				'data-display_stock' => array(),
				'data-post' => array(),
				'style' => array(),
			),
			'option' => array(
				'value' => array(),
				'selected' => array(),
			),
			'button' => array(
				'class' => array(),
				'id' => array(),
				'for'	=> array(),
				'type' => array(),
				'data-open' => array(),
				'data-close' => array(),
				'data-type' => array(),
				'data-job-id' => array(),
				'data-toggle' => array()
			),
			'fieldset' => array(
				'class' => array(),
			),
			'legend' => array(
				'class' => array(),
			),
			'a' => array(
				'class' => array(),
				'id' => array(),
				'href'	=> array(),
				'title'	=> array(),
				'target' => array(),
				'recordid' => array(),
				'data-open' => array(),
				'data-type' => array(),
				'data-value' => array(),
				'style' => array(),
				'dt_brand_device' => array(),
				'dt_brand_id' => array(),
			),
			'table' => array(
				'class' => array(),
				'id' => array(),
				'cellpadding' => array(),
				'cellspacing' => array()
			),
			'thead' => array(
				'class' => array(),
				'id' => array()
			),
			'tbody' => array(
				'class' => array(),
				'id' => array()
			),
			'tr' => array(
				'class' => array(),
				'id' => array()
			),
			'th' => array(
				'class' => array(),
				'id' => array(),
				'colspan' => array(),
				'data-colname' => array()
			),
			'td' => array(
				'class' => array(),
				'id' => array(),
				'colspan' => array(),
				'data-colname' => array()
			),
			'img' => array(
				'class' => array(),
				'id' => array(),
				'src' => array(),
				'alt' => array()
			),
			'h2' => array(
				'class' => array(),
				'id' 	=> array(),
			),
			'ul' => array(
				'class' => array(),
				'id' 	=> array(),
				'data-accordion'	=> array(),
				'data-multi-expand'	=> array(),
				'data-allow-all-closed' => array(),
			),
			'li' => array(
				'class' => array(),
				'id' 	=> array(),
				'data-accordion-item' => array(),
			),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'p' => array(
				'class' => array()
			),
			'br' => array(),
			'em' => array(),
			'em' => array(),
			'hr' => array(),
			'small' => array(),
			'strong' => array(),
			'span' => array(
				'class' => array()
			)
		);

			return $allowed_tags;
		}
	endif;

	if ( ! function_exists( 'wc_return_car_options' ) ):
		function wc_return_car_options() {
			$transmission = $output = '';
		
			$args = array(
				'post_type'      => array( 'rb_cars' ),
				'post_status'    => array( 'publish' ),
				'posts_per_page' => '-1',
				'order'          => 'ASC',
				'orderby'        => 'title',
			);
		
			$query   = new WP_Query( $args );
			$counter = 0;
			// The Loop
			if ($query->have_posts()) {
				$output .= '<option value="">' . esc_html__( 'Select Transport', 'rentalbuddy' ) . '</option>';						
				while ($query->have_posts()) {
					$query->the_post();
					global $post;
		
					$hourly = get_post_meta( $post->ID, '_hourly_rate', true );
					$daily  = get_post_meta( $post->ID, '_daily_rate', true );
					$specs  = get_post_meta( $post->ID, '_specs', true );
		
					$output .= '<option value="' . esc_attr( $post->ID ) . '">' . esc_html( get_the_title() ) . '</option>';
		
					$counter++;
				}
			} else {
				$output .= '<option>' . esc_html__( 'Nothing found please add some trasnports', 'rentalbuddy' ) . '</option>';
			}
			wp_reset_postdata();
		
			return $output;
		}
	endif;