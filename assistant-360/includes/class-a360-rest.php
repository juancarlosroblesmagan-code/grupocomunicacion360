<?php
defined( 'ABSPATH' ) || exit;

final class A360_REST {
	public static function register() {
		add_action( 'rest_api_init', function() {
			register_rest_route( 'a360/v1', '/bootstrap', array( 'methods' => 'POST', 'callback' => array( __CLASS__, 'bootstrap' ), 'permission_callback' => '__return_true' ) );
			register_rest_route( 'a360/v1', '/chat', array( 'methods' => 'POST', 'callback' => array( __CLASS__, 'chat' ), 'permission_callback' => '__return_true' ) );
		} );
	}
	public static function bootstrap() {
		if ( ! A360_Settings::ready() ) return new WP_Error( 'a360_offline', 'Servicio no disponible.', array( 'status' => 503 ) );
		$session = wp_generate_password( 32, false, false ); setcookie( 'a360_session', $session, array( 'expires' => time() + DAY_IN_SECONDS, 'path' => COOKIEPATH ?: '/', 'secure' => is_ssl(), 'httponly' => true, 'samesite' => 'Lax' ) );
		set_transient( 'a360_session_' . hash_hmac( 'sha256', $session, wp_salt( 'auth' ) ), 1, DAY_IN_SECONDS );
		return rest_ensure_response( array( 'token' => wp_create_nonce( 'wp_rest' ) ) );
	}
	public static function chat( WP_REST_Request $request ) {
		if ( ! A360_Settings::ready() ) return new WP_Error( 'a360_offline', 'Servicio no disponible.', array( 'status' => 503 ) );
		if ( ! wp_verify_nonce( (string) $request->get_header( 'X-A360-Nonce' ), 'wp_rest' ) ) return new WP_Error( 'a360_nonce', 'Sesión no válida.', array( 'status' => 403 ) );
		$visitor = A360_Rate_Limiter::visitor_id( $request ); if ( ! $visitor || ! get_transient( 'a360_session_' . $visitor ) ) return new WP_Error( 'a360_session', 'Inicia una nueva conversación.', array( 'status' => 403 ) );
		$s = A360_Settings::get(); $message = trim( (string) $request->get_param( 'message' ) );
		if ( '' === $message || mb_strlen( $message, 'UTF-8' ) > (int) $s['max_input_chars'] ) return new WP_Error( 'a360_message', 'Consulta no válida.', array( 'status' => 400 ) );
		if ( ! A360_Rate_Limiter::allow( $visitor, $s['visitor_daily_requests'], $s['daily_requests'] ) ) return new WP_Error( 'a360_limit', 'Has alcanzado el límite de consultas. Puedes contactar por WhatsApp.', array( 'status' => 429 ) );
		A360_Stats::record( 'request' );
		$context = A360_Knowledge::retrieve( $message );
		if ( ! $context ) { A360_Stats::record( 'api_error' ); return new WP_Error( 'a360_unknown', 'No dispongo de información suficiente. Puedes contactar por WhatsApp.', array( 'status' => 422 ) ); }
		if ( ! A360_Rate_Limiter::reserve_budget( $s['max_request_cost_microusd'], $s['daily_budget_usd'], $s['monthly_budget_usd'] ) ) { A360_Stats::record( 'budget_limit' ); return new WP_Error( 'a360_budget', 'El asistente ha alcanzado su límite temporal. Puedes contactar por WhatsApp.', array( 'status' => 429 ) ); }
		$answer = A360_OpenAI_Client::answer( sanitize_textarea_field( $message ), $context, $visitor ); if ( is_wp_error( $answer ) ) { A360_Stats::record( 'api_error' ); return $answer; }
		A360_Stats::record( 'answer', 0, 0, $s['max_request_cost_microusd'] );
		return rest_ensure_response( array( 'answer' => $answer ) );
	}
}
