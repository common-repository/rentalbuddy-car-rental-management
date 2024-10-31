// JavaScript Document
(function($) {
    "use strict";
	
	$("form[data-async]").on("submit",function(e) {
		e.preventDefault();
		return false;
	});

	$("form[data-async]").on("forminvalid.zf.abide", function(e,target) {
	  console.log("form is invalid");
	});

	$("form[data-async]").on("formvalid.zf.abide", function(e,target) {
		var $form 		 = $(this);
		var formData 	 = $form.serialize();

		var $input = $(this).find("input[name=form_type]");

		var $success_class = '.form-message';

		if ($form.attr('data-success-class') !== undefined ) {
			$success_class = $form.attr('data-success-class');
		}

		if($input.val() == "rb_settings_form") {
			var $perform_act = "rentalbuddy_form_submit_main_settings";	
		}

		$.ajax({
			type: $form.attr('method'),
			data: formData + '&action='+$perform_act,
			url: ajax_obj.ajax_url,
			dataType: 'json',
			beforeSend: function() {
				$($success_class).html("<div class='spinner is-active'></div>");
			},
			success: function(response) {
				//console.log(response);
				var message 		= response.message;
				var success 		= response.success;
				
				$($success_class).html('<div class="callout success" data-closable="slide-out-right">'+message+'<button class="close-button" aria-label="Dismiss alert" type="button" data-close><span aria-hidden="true">&times;</span></button></div>');
				
				if(success == "YES") {
					//$form.trigger("reset");	
				}
			}
		});
	});

})(jQuery); //jQuery main function ends strict Mode on