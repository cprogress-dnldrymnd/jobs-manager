<?php
/**
 * Jobs Manager
 *
 * @author            Donald Raymundo
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Jobs Manager
 * Description:       Jobs Manager by Digitally Disruptive
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Donald Raymundo
 * Text Domain:       jobsmanager
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

 /**
 * Register the "jobs" custom post type
 */
function jobsmanager_setup_post_type() {
	register_post_type( 'jobs', ['public' => true ] ); 
} 
add_action( 'init', 'jobsmanager_setup_post_type' );

/**
 * Activate the plugin.
 */
function jobsmanager_activate() { 
	// Trigger our function that registers the custom post type plugin.
	jobsmanager_setup_post_type(); 
	// Clear the permalinks after the post type has been registered.
	flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'jobsmanager_activate' );

/**
 * Deactivation hook.
 */
function jobsmanager_deactivate() {
	// Unregister the post type, so the rules are no longer in memory.
	unregister_post_type( 'jobs' );
	// Clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'jobsmanager_deactivate' );