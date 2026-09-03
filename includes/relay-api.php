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
function relay_permission_check() {
	// On multisite, use site_option; otherwise, use option
	$api_key = is_multisite()
		? get_site_option( 'relay_api_key', '' )
		: get_option( 'relay_api_key', '' );

	$header_key = isset( $_SERVER['HTTP_X_RELAY_API_KEY'] )
		? sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_RELAY_API_KEY'] ) )
		: '';

	if ( empty( $api_key ) || $header_key !== $api_key ) {
		return new \WP_Error( 'rest_forbidden', esc_html__( 'Invalid API key.', 'relay' ), array( 'status' => 401 ) );
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
		'directory_sizes'   => relay_get_directory_sizes(),
	);

	if ( is_multisite() ) {
		$data['multisite'] = true;

		$subsites         = get_sites();
		$data['subsites'] = array();

		foreach ( $subsites as $subsite ) {
			if ( get_main_site_id() === (int) $subsite->blog_id ) {
				continue;
			}

			$data['subsites'][] = array(
				'site_id'   => $subsite->blog_id,
				'site_url'  => get_site_url( $subsite->blog_id ),
				'site_name' => get_blog_option( $subsite->blog_id, 'blogname' ),
			);
		}
	} else {
		$data['multisite'] = false;
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
		'plugins',
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

function relay_rest_plugins(): WP_REST_Response
{
	require_once RELAY_PLUGIN_PATH . '/includes/relay-data.php';
	return new \WP_REST_Response( relay_get_plugins(), 200 );
}
