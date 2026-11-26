<?php
defined( 'ABSPATH' ) || exit;

final class A360_Plugin {
	public static function boot() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		add_action( 'admin_post_a360_save_knowledge', array( __CLASS__, 'save_knowledge' ) );
		add_action( 'admin_post_a360_delete_knowledge', array( __CLASS__, 'delete_knowledge' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
		A360_REST::register();
	}

	public static function activate() {
		global $wpdb;
		$charset = $wpdb->get_charset_collate();
		$limits = $wpdb->prefix . 'a360_limits';
		$stats = $wpdb->prefix . 'a360_stats';
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( "CREATE TABLE $limits (scope varchar(100) NOT NULL, bucket varchar(16) NOT NULL, requests bigint unsigned NOT NULL DEFAULT 0, reserved_microusd bigint unsigned NOT NULL DEFAULT 0, updated_at datetime NOT NULL, PRIMARY KEY (scope,bucket)) $charset;" );
		dbDelta( "CREATE TABLE $stats (id bigint unsigned NOT NULL AUTO_INCREMENT, created_at datetime NOT NULL, event varchar(32) NOT NULL, tokens_in int unsigned NOT NULL DEFAULT 0, tokens_out int unsigned NOT NULL DEFAULT 0, cost_microusd bigint unsigned NOT NULL DEFAULT 0, PRIMARY KEY (id), KEY created_at (created_at), KEY event (event)) $charset;" );
		A360_Knowledge::create_table();
		add_option( A360_Settings::OPTION, A360_Settings::defaults(), '', false );
	}

	public static function deactivate() { wp_clear_scheduled_hook( 'a360_daily_cleanup' ); }

	public static function assets() {
		if ( ! A360_Settings::ready() || is_admin() ) return;
		$s = A360_Settings::get();
		wp_enqueue_style( 'a360-public', A360_URL . 'assets/public.css', array(), A360_VERSION );
		wp_enqueue_script( 'a360-public', A360_URL . 'assets/public.js', array(), A360_VERSION, true );
		wp_add_inline_script( 'a360-public', 'window.A360_PUBLIC=' . wp_json_encode( array( 'bootstrap' => esc_url_raw( rest_url( 'a360/v1/bootstrap' ) ), 'name' => $s['name'], 'privacy' => esc_url_raw( $s['privacy_url'] ), 'whatsapp' => 'https://wa.me/' . rawurlencode( preg_replace( '/\D+/', '', $s['phone'] ) ) ) ) . ';', 'before' );
	}

	public static function admin_menu() {
		add_menu_page( 'Asistente 360º', 'Asistente 360º', 'manage_options', 'a360', array( __CLASS__, 'screen' ), 'dashicons-format-chat', 58 );
		add_submenu_page( 'a360', 'Base de conocimiento', 'Base de conocimiento', 'manage_options', 'a360-knowledge', array( __CLASS__, 'knowledge_screen' ) );
	}
	public static function register_settings() { register_setting( 'a360', A360_Settings::OPTION, array( 'sanitize_callback' => array( __CLASS__, 'sanitize' ) ) ); }
	public static function sanitize( $raw ) {
		$old = A360_Settings::get(); $raw = is_array( $raw ) ? $raw : array();
		$old['enabled'] = ! empty( $raw['enabled'] ); $old['mode'] = in_array( $raw['mode'] ?? '', array( 'test', 'live' ), true ) ? $raw['mode'] : 'test';
		$old['name'] = sanitize_text_field( $raw['name'] ?? $old['name'] ); $old['privacy_url'] = esc_url_raw( $raw['privacy_url'] ?? '' );
		$old['daily_budget_usd'] = number_format( max( 0, min( 100, (float) ( $raw['daily_budget_usd'] ?? $old['daily_budget_usd'] ) ) ), 2, '.', '' );
		$old['monthly_budget_usd'] = number_format( max( 0, min( 1000, (float) ( $raw['monthly_budget_usd'] ?? $old['monthly_budget_usd'] ) ) ), 2, '.', '' );
		return $old;
	}
	public static function screen() { $s = A360_Settings::get(); $stats = A360_Stats::summary(); ?>
		<div class="wrap"><h1>Asistente 360º</h1><p><strong>Estado:</strong> desarrollo local. La IA no se activa sin configuración segura.</p><h2>Últimos 30 días</h2><table class="widefat striped"><thead><tr><th>Evento</th><th>Total</th><th>Tokens entrada</th><th>Tokens salida</th><th>Coste estimado</th></tr></thead><tbody><?php if ( ! $stats ) { ?><tr><td colspan="5">Sin actividad registrada.</td></tr><?php } foreach ( $stats as $stat ) { ?><tr><td><?php echo esc_html( $stat['event'] ); ?></td><td><?php echo esc_html( $stat['total'] ); ?></td><td><?php echo esc_html( $stat['tokens_in'] ); ?></td><td><?php echo esc_html( $stat['tokens_out'] ); ?></td><td><?php echo esc_html( number_format_i18n( $stat['cost_microusd'] / 1000000, 4 ) ); ?> USD</td></tr><?php } ?></tbody></table><form method="post" action="options.php"><?php settings_fields( 'a360' ); ?><table class="form-table"><tr><th>Activar</th><td><input type="checkbox" name="a360_settings[enabled]" value="1" <?php checked( $s['enabled'] ); ?>></td></tr><tr><th>Modo</th><td><select name="a360_settings[mode]"><option value="test" <?php selected( $s['mode'], 'test' ); ?>>Pruebas</option><option value="live" <?php selected( $s['mode'], 'live' ); ?>>Producción</option></select></td></tr><tr><th>Presupuesto diario (USD)</th><td><input type="number" min="0" step="0.01" name="a360_settings[daily_budget_usd]" value="<?php echo esc_attr( $s['daily_budget_usd'] ); ?>"></td></tr><tr><th>Presupuesto mensual (USD)</th><td><input type="number" min="0" step="0.01" name="a360_settings[monthly_budget_usd]" value="<?php echo esc_attr( $s['monthly_budget_usd'] ); ?>"></td></tr><tr><th>Privacidad</th><td><input class="regular-text" type="url" name="a360_settings[privacy_url]" value="<?php echo esc_attr( $s['privacy_url'] ); ?>"></td></tr></table><?php submit_button(); ?></form></div>
	<?php }
	public static function knowledge_screen() {
		if ( ! current_user_can( 'manage_options' ) ) return; global $wpdb; $table = A360_Knowledge::table();
		$editing = isset( $_GET['id'] ) ? $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id=%d", absint( $_GET['id'] ) ), ARRAY_A ) : array( 'id' => 0, 'title' => '', 'category' => '', 'content' => '', 'source_url' => '', 'status' => 'draft' );
		$items = $wpdb->get_results( "SELECT id,title,category,source_url,status,updated_at FROM $table ORDER BY updated_at DESC LIMIT 100", ARRAY_A ); ?>
		<div class="wrap"><h1>Base de conocimiento</h1><p>Solo los documentos aprobados se usarán como contexto. No incluyas datos personales, precios, plazos ni condiciones no validadas.</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"><?php wp_nonce_field( 'a360_save_knowledge' ); ?><input type="hidden" name="action" value="a360_save_knowledge"><input type="hidden" name="id" value="<?php echo absint( $editing['id'] ); ?>"><table class="form-table"><tr><th>Título</th><td><input required class="regular-text" name="title" value="<?php echo esc_attr( $editing['title'] ); ?>"></td></tr><tr><th>Categoría</th><td><input class="regular-text" name="category" value="<?php echo esc_attr( $editing['category'] ); ?>"></td></tr><tr><th>URL pública de origen</th><td><input type="url" class="large-text" name="source_url" value="<?php echo esc_url( $editing['source_url'] ); ?>"></td></tr><tr><th>Estado</th><td><select name="status"><option value="draft" <?php selected( $editing['status'], 'draft' ); ?>>Borrador</option><option value="approved" <?php selected( $editing['status'], 'approved' ); ?>>Aprobado</option></select></td></tr><tr><th>Información autorizada</th><td><textarea required class="large-text" rows="10" name="content"><?php echo esc_textarea( $editing['content'] ); ?></textarea></td></tr></table><?php submit_button( $editing['id'] ? 'Actualizar documento' : 'Añadir documento' ); ?></form>
		<h2>Documentos</h2><table class="widefat striped"><thead><tr><th>Título</th><th>Categoría</th><th>Estado</th><th>Actualización</th><th>Acciones</th></tr></thead><tbody><?php foreach ( $items as $item ) { $edit = add_query_arg( array( 'page' => 'a360-knowledge', 'id' => $item['id'] ), admin_url( 'admin.php' ) ); $delete = wp_nonce_url( add_query_arg( array( 'action' => 'a360_delete_knowledge', 'id' => $item['id'] ), admin_url( 'admin-post.php' ) ), 'a360_delete_knowledge_' . $item['id'] ); ?><tr><td><?php echo esc_html( $item['title'] ); ?></td><td><?php echo esc_html( $item['category'] ); ?></td><td><?php echo esc_html( $item['status'] ); ?></td><td><?php echo esc_html( $item['updated_at'] ); ?></td><td><a href="<?php echo esc_url( $edit ); ?>">Editar</a> · <a href="<?php echo esc_url( $delete ); ?>" onclick="return confirm('¿Eliminar este documento?');">Eliminar</a></td></tr><?php } ?></tbody></table></div>
	<?php }
	public static function save_knowledge() {
		if ( ! current_user_can( 'manage_options' ) ) wp_die( 'No autorizado.' ); check_admin_referer( 'a360_save_knowledge' ); global $wpdb; $table = A360_Knowledge::table();
		$data = array( 'title' => sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) ), 'category' => sanitize_text_field( wp_unslash( $_POST['category'] ?? '' ) ), 'content' => wp_kses_post( wp_unslash( $_POST['content'] ?? '' ) ), 'source_url' => esc_url_raw( wp_unslash( $_POST['source_url'] ?? '' ) ), 'status' => in_array( $_POST['status'] ?? '', array( 'draft', 'approved' ), true ) ? $_POST['status'] : 'draft', 'updated_at' => current_time( 'mysql', true ) );
		$id = absint( $_POST['id'] ?? 0 ); if ( $id ) $wpdb->update( $table, $data, array( 'id' => $id ) ); else $wpdb->insert( $table, $data ); wp_safe_redirect( admin_url( 'admin.php?page=a360-knowledge&updated=1' ) ); exit;
	}
	public static function delete_knowledge() { if ( ! current_user_can( 'manage_options' ) ) wp_die( 'No autorizado.' ); $id = absint( $_GET['id'] ?? 0 ); check_admin_referer( 'a360_delete_knowledge_' . $id ); global $wpdb; $wpdb->delete( A360_Knowledge::table(), array( 'id' => $id ), array( '%d' ) ); wp_safe_redirect( admin_url( 'admin.php?page=a360-knowledge&deleted=1' ) ); exit; }
}
