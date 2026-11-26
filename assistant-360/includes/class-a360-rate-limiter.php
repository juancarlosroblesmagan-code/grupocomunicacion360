<?php
defined( 'ABSPATH' ) || exit;

final class A360_Rate_Limiter {
	public static function visitor_id( WP_REST_Request $request ) {
		$cookie = isset( $_COOKIE['a360_session'] ) ? preg_replace( '/[^a-zA-Z0-9_-]/', '', (string) $_COOKIE['a360_session'] ) : '';
		return $cookie ? hash_hmac( 'sha256', $cookie, wp_salt( 'auth' ) ) : '';
	}
	public static function allow( $visitor, $limit, $global_limit ) {
		global $wpdb; $table = $wpdb->prefix . 'a360_limits'; $bucket = gmdate( 'Ymd' );
		foreach ( array( 'day:global' => (int) $global_limit, 'day:' . $visitor => (int) $limit ) as $scope => $max ) {
			$wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO $table (scope,bucket,requests,reserved_microusd,updated_at) VALUES (%s,%s,0,0,UTC_TIMESTAMP())", $scope, $bucket ) );
			$updated = $wpdb->query( $wpdb->prepare( "UPDATE $table SET requests=requests+1,updated_at=UTC_TIMESTAMP() WHERE scope=%s AND bucket=%s AND requests<%d", $scope, $bucket, $max ) );
			if ( 1 !== (int) $updated ) return false;
		}
		return true;
	}
	public static function reserve_budget( $microusd, $daily_usd, $monthly_usd ) {
		global $wpdb; $table = $wpdb->prefix . 'a360_limits'; $microusd = max( 0, (int) $microusd );
		$buckets = array( 'budget:day' => array( gmdate( 'Ymd' ), (int) round( (float) $daily_usd * 1000000 ) ), 'budget:month' => array( gmdate( 'Ym' ), (int) round( (float) $monthly_usd * 1000000 ) ) );
		foreach ( $buckets as $scope => $data ) { list( $bucket, $limit ) = $data; $wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO $table (scope,bucket,requests,reserved_microusd,updated_at) VALUES (%s,%s,0,0,UTC_TIMESTAMP())", $scope, $bucket ) ); $ok = $wpdb->query( $wpdb->prepare( "UPDATE $table SET reserved_microusd=reserved_microusd+%d,updated_at=UTC_TIMESTAMP() WHERE scope=%s AND bucket=%s AND reserved_microusd+%d<=%d", $microusd, $scope, $bucket, $microusd, $limit ) ); if ( 1 !== (int) $ok ) return false; }
		return true;
	}
}
