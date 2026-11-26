<?php
defined( 'ABSPATH' ) || exit;

final class A360_Knowledge {
	public static function table() { global $wpdb; return $wpdb->prefix . 'a360_knowledge'; }
	public static function create_table() {
		global $wpdb; $charset = $wpdb->get_charset_collate(); $table = self::table();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( "CREATE TABLE $table (id bigint unsigned NOT NULL AUTO_INCREMENT,title text NOT NULL,category varchar(80) NOT NULL DEFAULT '',content longtext NOT NULL,source_url text NOT NULL,status varchar(16) NOT NULL DEFAULT 'draft',updated_at datetime NOT NULL,PRIMARY KEY (id),KEY status (status),KEY category (category)) $charset;" );
	}
	public static function retrieve( $query, $limit = 3 ) {
		global $wpdb; $table = self::table(); $tokens = preg_split( '/[^\\pL\\pN]+/u', mb_strtolower( $query ), -1, PREG_SPLIT_NO_EMPTY ); $tokens = array_slice( array_filter( $tokens, function( $t ) { return mb_strlen( $t ) > 2; } ), 0, 8 );
		$rows = $wpdb->get_results( "SELECT title,content,source_url FROM $table WHERE status='approved' ORDER BY updated_at DESC LIMIT 60", ARRAY_A ); $ranked = array();
		foreach ( $rows as $row ) { $haystack = mb_strtolower( $row['title'] . ' ' . $row['content'] ); $score = 0; foreach ( $tokens as $token ) $score += substr_count( $haystack, $token ); if ( $score ) { $row['score'] = $score; $ranked[] = $row; } }
		usort( $ranked, function( $a, $b ) { return $b['score'] <=> $a['score']; } ); $ranked = array_slice( $ranked, 0, $limit ); $context = array();
		foreach ( $ranked as $row ) $context[] = "Título: {$row['title']}\nInformación autorizada: " . mb_substr( wp_strip_all_tags( $row['content'] ), 0, 1400 ) . "\nURL: {$row['source_url']}";
		return implode( "\n\n---\n\n", $context );
	}
}
