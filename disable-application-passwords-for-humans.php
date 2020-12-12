<?php
defined( 'ABSPATH' ) or exit;

/**
 * Plugin Name: Disable Application Passwords for Humans
 * Plugin URI: https://github.com/csalzano/disable-application-passwords-for-humans
 * Description: Disables application passwords for user accounts that have recorded at least one log in
 * Version: 0.1.0
 * Author: Corey Salzano
 * Author URI: https://github.com/csalzano
 * Text Domain: disable-apps-for-humans
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

function user_has_never_logged_in( $value, $user )
{
	global $wpdb;
	return empty( $wpdb->get_var( $wpdb->prepare( 
		"SELECT		user_login
		
		FROM		wp_users
					LEFT JOIN wp_usermeta ON ID = %d
		
		WHERE		meta_key = 'session_tokens'",
		$user->ID
	) ) );
}
add_filter( 'wp_is_application_passwords_available_for_user', 'user_has_never_logged_in', 10, 2 );
