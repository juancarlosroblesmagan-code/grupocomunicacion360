<?php
defined( 'ABSPATH' ) || exit;

final class A360_Stats {
	public static function record( $event, $input_tokens = 0, $output_tokens = 0, $cost_microusd = 0 ) {
		global $wpdb;
		$allowed = array( 'request', 'answer', 'api_error', 'limit', 'budget_limit', 'whatsapp_click' );
		if ( ! in_array( $event, $allowed, true ) ) return;
		$wpdb->insert( $wpdb->prefix . 'a360_stats', array( 'created_at' => current_time( 'mysql', true ), 'event' => $event, 'tokens_in' => max( 0, (int) $input_tokens ), 'tokens_out' => max( 0, (int) $output_tokens ), 'cost_microusd' => max( 0, (int) $cost_microusd ) ), array( '%s', '%s', '%d', '%d', '%d' ) );
	}
	public static function summary() {
		global $wpdb; $table = $wpdb->prefix . 'a360_stats';
		return $wpdb->get_results( "SELECT event,COUNT(*) AS total,SUM(tokens_in) AS tokens_in,SUM(tokens_out) AS tokens_out,SUM(cost_microusd) AS cost_microusd FROM $table WHERE created_at >= DATE_SUB(UTC_TIMESTAMP(),INTERVAL 30 DAY) GROUP BY event", ARRAY_A );
	}
}
