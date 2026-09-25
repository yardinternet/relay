<?php
/**
 * @package Relay
 * @author  Verdant Studio
 *
 * Plugin Name: Relay
 * Plugin URI: https://www.verdant.studio/plugins/relay
 * Description: A secure bridge between your WordPress site's internals and your monitoring tools.
 * Version: 1.5.1
 * Author: Verdant Studio
 * Author URI: https://www.verdant.studio
 * License: GPLv2 or later
 * Text Domain: relay
 * Domain Path: /languages
 * Requires at least: 6.6
 * Network: true
 */

/**
 * Exit when accessed directly.
 */
if ( ! defined( 'ABSPATH' )) {
	exit;
}

/**
 * Constants.
 */
const RELAY_PLUGIN_VERSION = '1.5.1';

define( 'RELAY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Initialize the plugin.
 *
 * @since 1.0.0
 */
function relay_plugin_init(): void {
	relay_activation();

	require_once RELAY_PLUGIN_PATH . '/includes/relay-data.php';
}

/**
 * Add WP-CLI command.
 *
 * @since 1.4.0
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once RELAY_PLUGIN_PATH . '/includes/relay-cli.php';

	WP_CLI::add_command( 'relay', 'Relay_CLI_Command' );
}

require_once RELAY_PLUGIN_PATH . '/includes/relay-extra.php';
require_once RELAY_PLUGIN_PATH . '/includes/relay-settings.php';
require_once RELAY_PLUGIN_PATH . '/includes/relay-api.php';
