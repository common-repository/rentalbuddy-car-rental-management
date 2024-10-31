// JavaScript Document
(function($) {
    "use strict";

	//calling foundation js
	jQuery(document).foundation();
	
	jQuery.fn.exists = function(){ return this.length > 0; }

	jQuery(document).ready(function() {
		$('#customer').select2();
	});

})(jQuery); //jQuery main function ends strict Mode on