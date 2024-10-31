<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!function_exists("rentalbuddy_get_email_footer")):
	function rentalbuddy_get_email_footer() {
		$output = '</div>
					</td></tr>
					</table>
					<!-- End Content -->
					</td>
					</tr>
					</table>
					<!-- End Body -->
					</td>
					</tr>
					</table>
					</td>
					</tr>';
		$output .= '<tr>
			<td align="center" valign="top">
				<!-- Footer -->
				<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
					<tr>
						<td valign="top">
							<table border="0" cellpadding="10" cellspacing="0" width="100%">
								<tr>
									<td colspan="2" valign="middle" id="credit">
									'.get_bloginfo( 'name' ).'<br>
									'.get_bloginfo( 'description' ).'
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<!-- End Footer -->
			</td>
		</tr>
		</table>
		</div>
		</body>
		</html>';

		return $output;
	}
endif;