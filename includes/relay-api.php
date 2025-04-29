<?php
/**
 * Relay REST API.
 *
 * @package Relay
 * @author  Verdant Studio
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if the user may access the endpoints.
 *
 * @since 1.0.0
 *
 * @return WP_Error|bool
 */
function relay_permission_check()
{
	if ( ! current_user_can( 'manage_options' )) {
		return new \WP_Error( 'rest_forbidden', esc_html__( 'You do not have permissions to manage options.', 'relay' ), array( 'status' => 401 ) );
	}

	return true;
}

function relay_rest_core(): WP_REST_Response
{
	require_once RELAY_PLUGIN_PATH . '/includes/relay-data.php';

	$data = array(
		'site_name'         => relay_get_site_name(),
		'site_url'          => relay_get_site_url(),
		'wp_version'        => relay_get_current_wp_version(),
		'health_rating'     => relay_get_site_health_rating(),
		'updates_available' => relay_get_amount_of_plugin_updates(),
	);

	if ( is_multisite() ) {
		$data['multisite'] = true;
	}

	return new \WP_REST_Response( $data, 200 );
}

/**
 * Register the REST API routes.
 *
 * @since 1.0.0
 */
function relay_register_rest_routes(): void
{
	$endpoints = array(
		'core',
	);

	foreach ( $endpoints as $endpoint ) {
		register_rest_route(
			'relay/v1',
			'/' . $endpoint,
			array(
				'methods'             => 'GET',
				'callback'            => 'relay_rest_' . $endpoint,
				'permission_callback' => 'relay_permission_check',
			)
		);
	}
}

/**
 * Initialize the REST API routes.
 *
 * @since 1.0.0
 */
add_action( 'rest_api_init', 'relay_register_rest_routes' );
