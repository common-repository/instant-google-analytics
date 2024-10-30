<?php

/**
 * Plugin Name: Instant Google Analytics
 * Description: Adds the Universal Google Analytics Tracking Code to Wordpress Theme Header
 * Version: 1.0.5
 * Author: 360Tactics
 * Author URI: http://www.360tactics.net
 * Bitbucket Plugin URI: https://bitbucket.org/team360tactics/360tactics-google-analytics-plugin
 * Bitbucket Branch: master
 *
 */

define( 'TACTICS_IGA_DIR', dirname( __FILE__ ) );
define( 'TACTICS_IGA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
require_once( 'lib/controllers/tactics-iga-controller-class.php' );