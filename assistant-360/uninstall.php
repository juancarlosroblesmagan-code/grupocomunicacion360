<?php
/** Controlled uninstall. Data is retained unless the site owner explicitly opts in. */
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

if ( ! defined( 'A360_REMOVE_DATA_ON_UNINSTALL' ) || true !== A360_REMOVE_DATA_ON_UNINSTALL ) {
	return;
}

global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}a360_limits" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}a360_stats" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}a360_knowledge" );
delete_option( 'a360_settings' );
