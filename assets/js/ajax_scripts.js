// JavaScript Document
(function($) {
    "use strict";

	function update_calculations() {
		var $hours = $('#hoursrange').val();
		$('.rbhours').html($hours);

		if ( $hours > 6 ) {
			//$('.thekilometers').removeClass('hideme');
			$('.thekilometers').addClass('showme');
		} else {
			$('.thekilometers').removeClass('showme');
			//$('.thekilometers').addClass('hideme');
		}

		var $kilometers = $('input[name="kilometers"]').val();
		var $pickupDate = $('input[name="pickup_date"]').val();
		var $transmission = $('input[name="transmission"]:checked').val();
		var $hourly_rate = $('input[name="transport"]:checked').attr('data_hourly_rate');
		var $daily_rate = $('input[name="transport"]:checked').attr('data_daily_rate');
		var $transport = $('input[name="transport"]:checked').attr('data_title');
		//Have variables $hours $kilometers  $transmission $hourly_rate $daily_rate

		var thedate = new Date($pickupDate);
		$('.calculations .datetime .sub-item-value').html(formatDate(thedate));
		$('.calculations .transmission .sub-item-value').html($transmission);
		$('.calculations .hours .sub-item-value').html($hours);
		$('.calculations .transport .sub-item-value').html($transport);

		if($hours > 6) {
			$('.calculations .kilometers').removeClass('hideme');
			$('.calculations .kilometers').addClass('showme');

			$('.calculations .kilometers .sub-item-value').html($kilometers);
			var $calculatedRate = 0;
			if ($kilometers>50) {
				var $calculated = $kilometers-50;
				$calculatedRate = $calculated*0.25;
			}
			var $total_hrs = parseFloat($daily_rate)+$calculatedRate;
		} else {
			$('.calculations .kilometers').removeClass('showme');
			$('.calculations .kilometers').addClass('hideme');

			var $total_hrs = parseFloat($hourly_rate)*$hours;
		}

		$('.calculations .total .sub-item-value').html('€ '+$total_hrs.toFixed(2));
	}
	$(document).on('ready', function(e) {
		update_calculations();
	});

	$(document).on("change", 'input[name="kilometers"], input[name="pickup_date"], input[name="transport"]', function(e) {
		update_calculations();
	});

	$(document).on("change mousemove", "#hoursrange", function(e) {
		update_calculations();
	});

	$(document).on("change", 'input[name="transmission"]', function(e) {
		update_calculations();
		e.preventDefault();

		var $transmission = $('input[name="transmission"]:checked').val();
		$.ajax({
			type: 'POST',
			data: {
				'action': 'rentalbuddy_return_the_cars',
				'transmission': $transmission, 
				'ajax_data':'YES'
			},
			url: ajax_obj.ajax_url,
			dataType: 'json',

			beforeSend: function() {
				$('#the_carsData').html("<div class='loader'>Loading...</div>");
			},
			success: function(response) {
				//console.log(response);
				var message 		= response.message;
				$('#the_carsData').html(message);

				update_calculations();
			}
		});
	});

	$(document).on("submit", 'form#getcalculations', function(e) {
		e.preventDefault();

		var $thevehselected = $('#thevehselected').val();
		var $pickupdate     = $('#pickupdate').val();
		var $pickuptime     = $('#pickuptime').val();
		var $returndate     = $('#returndate').val();
		var $returntime     = $('#returntime').val();
		var $Additionalkm   = $('#Additionalkm').val();

		$.ajax({
			type: 'POST',
			data: {
				'action': 'rentalbuddy_new_calculations',
				'thevehselected': $thevehselected,
				'pickupdate': $pickupdate,
				'pickuptime': $pickuptime,
				'returndate': $returndate,
				'returntime': $returntime,
				'Additionalkm': $Additionalkm,
				'ajax_data':'YES'
			},
			url: ajax_obj.ajax_url,
			dataType: 'json',

			beforeSend: function() {
				$('#calculations_output').html("<div class='loaders'>Calculating...</div>");
			},
			success: function(response) {
				//console.log(response);
				var message 		= response.message;
				$('#calculations_output').html(message);
			}
		});
	});

	var formatDate = function(date) {
		return date.getDate() + "-" + date.getMonth() + "-" + date.getFullYear() + " " +  ('0' + date.getHours()).slice(-2) + ":" + ('0' + date.getMinutes()).slice(-2) + ":" + ('0' + date.getSeconds()).slice(-2) + ' ' + (date.getHours() < 12 ? 'AM' : 'PM');
	}

	$(document).on("click", '#step_follow', function(e){
		var $getStep = $(this).attr('data-step');

		if( $getStep =="step-hours" ) {
			var $button_target = "step-date";
			var $hide = '#step_hours';
			var $show = '#step_time';
		} else if( $getStep =="step-date" ) {
			var $button_target = "step-transmission";
			var $hide = '#step_time';
			var $show = '#step_transmission';
		} else if( $getStep =="step-transmission" ) {
			var $button_target = "step-transport";
			var $hide = '#step_transmission';
			var $show = '#step_transport';
		} else if( $getStep =="step-transport" ) {
			var $button_target = "step-summary";
			var $hide = '#step_transport';
			var $show = '#step_summary';
		} else if( $getStep =="step-summary" ) {
			var $button_target = "step-hours";
			var $hide = '#step_summary';
			var $show = '#step_hours';
		}
		console.log($hide);
		//Hide
		$($hide).addClass('hideme');
		$($hide).removeClass('showme');

		$($show).addClass('showme');
		$($show).addClass('hideme');
		//Change button target
		$(this).attr('data-step', $button_target);

		var $current_step = $getStep;
		var $next_step = $button_target;
		
		$('.'+$next_step+' .am-fs-sb__step-checker').addClass('am-fs-sb__step-checker-selected');
		$('.'+$current_step+' .am-fs-sb__step-checker').removeClass('am-fs-sb__step-checker-selected');
		$('.'+$current_step+' .am-fs-sb__step-checker').html('<span class="am-icon-check"></span>');
	});

	$('.calc-item-transport-box label').on('click', function(){
		$('.calc-item-transport-box label.current').removeClass('current');
		$(this).addClass('current');
	});

})(jQuery); //jQuery main function ends strict Mode on