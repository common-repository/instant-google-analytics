<?php

/**
 * Removes Google Analytics Tracking ID in the database when the plugin is uninstalled.
 *
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'tactics_iga_tracking_id' );