<?php
/**
 * @package Relay
 * @author  Verdant Studio
 *
 * Plugin Name: Relay
 * Plugin URI: https://www.verdant.studio/plugins/relay
 * Description: A secure bridge between your WordPress site's internals and your monitoring tools.
 * Version: 1.1.0
 * Author: Verdant Studio
 * Author URI: https://www.verdant.studio
 * License: GPLv2 or later
 * Text Domain: relay
 * Domain Path: /languages
 * Requires at least: 6.6
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
const RELAY_PLUGIN_VERSION = '1.1.0';

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

require_once RELAY_PLUGIN_PATH . '/includes/relay-api.php';
