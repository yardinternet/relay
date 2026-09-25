<?php
/**
 * Consumer supplied polling data.
 *
 * @package Relay
 * @author  Verdant Studio
 * @since   1.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Collect the extra data a consumer wants included in an endpoint's payload.
 *
 * Add values from code:
 *
 *     add_filter( 'relay_extra_data', function ( array $data, string $endpoint ): array {
 *         $data['framework'] = 'brave';
 *         return $data;
 *     }, 10, 2 );
 *
 * Or without code, which is what deploy tooling uses:
 *
 *     wp option update relay_extra_data '{"branch":"main"}' --format=json
 *
 * @since 1.6.0
 *
 * @param string $endpoint Endpoint the data is collected for.
 * @return array<string, scalar|array<scalar>>
 */
function relay_get_extra_data( string $endpoint ): array {
	$data = apply_filters( 'relay_extra_data', [], $endpoint );

	return is_array( $data ) ? relay_sanitize_extra_data( $data ) : [];
}

/**
 * Keep the payload to scalars and flat arrays of scalars.
 *
 * @since 1.6.0
 *
 * @param array<mixed> $data
 * @return array<string, scalar|array<scalar>>
 */
function relay_sanitize_extra_data( array $data ): array {
	$sanitized = [];

	foreach ( $data as $key => $value ) {
		$key = sanitize_key( (string) $key );

		if ( '' === $key ) {
			continue;
		}

		if ( is_array( $value ) ) {
			$value = array_values( array_filter( $value, 'is_scalar' ) );

			$sanitized[ $key ] = array_map( 'relay_sanitize_extra_value', $value );
		} elseif ( is_scalar( $value ) ) {
			$sanitized[ $key ] = relay_sanitize_extra_value( $value );
		}
	}

	return $sanitized;
}

/**
 * @since 1.6.0
 *
 * @param scalar $value
 * @return scalar
 */
function relay_sanitize_extra_value( $value ) {
	return is_string( $value ) ? sanitize_text_field( $value ) : $value;
}

/**
 * Expose the stored option so tooling without PHP access can supply data.
 *
 * @since 1.6.0
 *
 * @param array<mixed> $data
 * @return array<mixed>
 */
function relay_extra_data_from_option( array $data ): array {
	$stored = is_multisite()
		? get_site_option( 'relay_extra_data', [] )
		: get_option( 'relay_extra_data', [] );

	return is_array( $stored ) ? array_merge( $data, $stored ) : $data;
}

add_filter( 'relay_extra_data', 'relay_extra_data_from_option' );
