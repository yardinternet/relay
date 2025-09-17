<?php
/**
 * Relay WP-CLI Command.
 *
 * @package Relay
 * @author  Verdant Studio
 * @since   1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register WP-CLI Command.
 *
 * @since 1.4.0
 */
class Relay_CLI_Command
{
	/**
	 * Activates the Relay plugin.
	 *
	 * ## EXAMPLES
	 *
	 *     wp relay activate
	 *
	 * @subcommand activate
	 */
	public function activate() {
		$plugin_file = plugin_basename( dirname( __DIR__ ) . '/relay.php' );

		if ( is_plugin_active( $plugin_file ) ) {
			WP_CLI::success( 'Relay plugin is already active.' );
			return;
		}

		activate_plugin( $plugin_file );

		if ( is_plugin_active( $plugin_file ) ) {
			WP_CLI::success( 'Relay plugin activated.' );
		} else {
			WP_CLI::error( 'Failed to activate Relay plugin.' );
		}
	}

	/**
	 * Generates and saves a new API key in the database.
	 *
	 * ## OPTIONS
	 *
	 * [--porcelain]
	 * : Output only the API key.
	 *
	 * ## EXAMPLES
	 *
	 *     wp relay generate-api-key
	 *
	 * @subcommand generate-api-key
	 */
	public function generate_api_key( $args, $assoc_args ) {
		$api_key = wp_generate_password( 32, false );

		if ( ! update_option( 'relay_api_key', $api_key ) ) {
			WP_CLI::error( 'Failed to save API key.' );
		}

		if ( isset( $assoc_args['porcelain'] ) ) {
			WP_CLI::line( $api_key );
		} else {
			WP_CLI::success( "API key generated: $api_key" );
		}
	}
}
