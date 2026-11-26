<?php
/**
 * Plugin Name: 360º AI Assistant PRO
 * Description: Asistente comercial privado y configurable para WordPress.
 * Version: 0.2.0-dev-r10
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Text Domain: ai-assistant-360
 */

defined( 'ABSPATH' ) || exit;

define( 'A360_VERSION', '0.2.0-dev-r10' );
define( 'A360_FILE', __FILE__ );
define( 'A360_DIR', plugin_dir_path( __FILE__ ) );
define( 'A360_URL', plugin_dir_url( __FILE__ ) );

require_once A360_DIR . 'includes/class-a360-plugin.php';
require_once A360_DIR . 'includes/class-a360-settings.php';
require_once A360_DIR . 'includes/class-a360-rate-limiter.php';
require_once A360_DIR . 'includes/class-a360-knowledge.php';
require_once A360_DIR . 'includes/class-a360-stats.php';
require_once A360_DIR . 'includes/class-a360-openai-client.php';
require_once A360_DIR . 'includes/class-a360-rest.php';

register_activation_hook( __FILE__, array( 'A360_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'A360_Plugin', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'A360_Plugin', 'boot' ) );
