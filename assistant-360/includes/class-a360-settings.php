<?php
defined( 'ABSPATH' ) || exit;

final class A360_Settings {
	const OPTION = 'a360_settings';

	public static function defaults() {
		return array(
			'enabled' => false, 'mode' => 'test', 'name' => 'Asistente 360º',
			'model' => 'gpt-4.1-mini', 'phone' => '34607877289',
			'privacy_url' => '', 'daily_requests' => 50, 'visitor_daily_requests' => 10,
			'max_input_chars' => 900, 'max_output_tokens' => 350,
			'daily_budget_usd' => '0.50', 'monthly_budget_usd' => '5.00',
			'max_request_cost_microusd' => 10000,
			'instructions' => '',
		);
	}

	public static function get() {
		return wp_parse_args( get_option( self::OPTION, array() ), self::defaults() );
	}

	public static function api_key() {
		if ( defined( 'A360_OPENAI_API_KEY' ) && is_string( A360_OPENAI_API_KEY ) ) return trim( A360_OPENAI_API_KEY );
		$environment = getenv( 'A360_OPENAI_API_KEY' );
		return is_string( $environment ) ? trim( $environment ) : '';
	}

	public static function ready() {
		$s = self::get();
		return ! empty( $s['enabled'] ) && 'live' === $s['mode'] && ! empty( $s['privacy_url'] ) && self::api_key();
	}
}
