<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!function_exists("rentalbuddy_email_head")):
function rentalbuddy_email_head() {
	$output = '<!DOCTYPE html>';
	$output .= '<html '.get_language_attributes().'>';
	$output .= '<head>';
	$output .= '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />';
	$output .= '<title>'.get_bloginfo( 'name', 'display' ).'</title>';
	$output .= '<style type="text/css">.repair_box table tr td, .repair_box table tr th {border:1px solid #f7f7f7;padding:8px;} .repair_box table tr.heading td {
		background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;} .repair_box .invoice_totals table {
			border: 1px solid #ededed; max-width: 350px; text-align: right; float: right; margin-bottom: 15px; } .repair_box p.aligncenter {width:100%;display:block;clear:both;text-align:center;} .repair_box table tr th {font-weight:bold;} .repair_box table {margin-bottom:15px;width:100%;}</style>';
	$output .= '</head>';
	$rightmargin = is_rtl() ? 'rightmargin' : 'leftmargin';
	$direction = is_rtl() ? 'rtl' : 'ltr';
	$output .= '<body '.$rightmargin.'="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">';
	$output .= '<div id="wrapper" dir="'.$direction.'">';
	$output .= '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">';
	$output .= '<tr><td align="center" valign="top">';

	$output .= '<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">';
	$output .= '<tr>
				<td align="center" valign="top">
				<!-- Body -->
				<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
				<tr>
				<td valign="top" id="body_content">
				<!-- Content -->
				<table border="0" cellpadding="20" cellspacing="0" width="100%">
				<tr>
				<td valign="top">
				<div id="body_content_inner">';
	return $output;
}
endif;