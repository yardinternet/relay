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
	public function generate_api_key( array $args, array $assoc_args ) {
		$api_key = wp_generate_password( 32, false );

		if ( is_multisite() ) {
			$updated = update_site_option( 'relay_api_key', $api_key );
		} else {
			$updated = update_option( 'relay_api_key', $api_key );
		}

		if ( ! $updated ) {
			WP_CLI::error( 'Failed to save API key.' );
		}

		if ( isset( $assoc_args['porcelain'] ) ) {
			WP_CLI::line( $api_key );
		} else {
			WP_CLI::success( "New API key generated: $api_key" );
		}
	}

	/**
	 * Retrieves the current API key.
	 *
	 * ## OPTIONS
	 *
	 * [--porcelain]
	 * : Output only the API key.
	 *
	 * ## EXAMPLES
	 *
	 *     wp relay get-api-key
	 *
	 * @subcommand get-api-key
	 *
	 * @since 1.5.0
	 */
	public function get_api_key( array $args, array $assoc_args ) {
		if ( is_multisite() ) {
			$api_key = get_site_option( 'relay_api_key' );
		} else {
			$api_key = get_option( 'relay_api_key' );
		}

		if ( ! $api_key ) {
			return WP_CLI::warning( 'No API key found.' );
		}

		if ( isset( $assoc_args['porcelain'] ) ) {
			WP_CLI::line( $api_key );
		} else {
			WP_CLI::success( "Current API key: $api_key" );
		}
	}
}
