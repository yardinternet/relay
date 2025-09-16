<?php
/**
 * Relay data.
 *
 * @package Relay
 * @author  Verdant Studio
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the site name.
 *
 * @since 1.0.0
 */
function relay_get_site_name(): ?string {
	return get_bloginfo( 'name' ) ?? __( 'N/A', 'relay' );
}

/**
 * Get the site URL.
 *
 * @since 1.0.0
 */
function relay_get_site_url(): ?string {
	return get_bloginfo( 'url' ) ?? __( 'N/A', 'relay' );
}

/**
 * Get the current WP version installed on the site.
 *
 * @since 1.0.0
 */
function relay_get_current_wp_version(): ?string {
	return get_bloginfo( 'version' ) ?? __( 'N/A', 'relay' );
}

/**
 * Get the site health and turn it into a rating.
 *
 * @since 1.0.0
 */
function relay_get_site_health_rating(): int {
	$summary = get_transient( 'health-check-site-status-result' );

	if ( false === $summary ) {
		return 0;
	}

	$summary = json_decode( $summary, true );

	if ( is_array( $summary ) ) {
		$good        = $summary['good'] ?? 0;
		$recommended = $summary['recommended'] ?? 0;
		$critical    = $summary['critical'] ?? 0;

		$total = $good + $recommended + $critical;

		if ( 0 === $total ) {
			return 0;
		}

		$rating = ( 5 * $good + 3 * $recommended + 1 * $critical ) / $total;
		return (int) round( $rating );
	}

	return 0;
}

/**
 * Get the amount of plugin updates.
 *
 * @since 1.0.0
 */
function relay_get_amount_of_plugin_updates(): int {
	if ( ! function_exists( 'wp_update_plugins' ) ) {
		require_once ABSPATH . WPINC . '/update.php';
	}

	wp_update_plugins();
	$update_plugins = get_site_transient( 'update_plugins' );

	return isset( $update_plugins->response ) ? count( $update_plugins->response ) : 0;
}

/**
 * Get directory sizes.
 *
 * @since 1.2.0
 */
function relay_get_directory_sizes(): array {
	// Try to get cached data first.
	$cached = get_transient('relay_directory_sizes');
	if ($cached !== false) {
		return $cached;
	}

	if (!class_exists('WP_Debug_Data')) {
		require_once ABSPATH . 'wp-admin/includes/class-wp-debug-data.php';
	}

	if (class_exists('WP_Debug_Data')) {
		$sizes_data = WP_Debug_Data::get_sizes();
		$all_sizes  = array();

		foreach ($sizes_data as $name => $value) {
			$name       = sanitize_text_field($name);
			$data_entry = array();

			if (isset($value['size'])) {
				$data_entry['size'] = is_string($value['size'])
					? sanitize_text_field($value['size'])
					: (int) $value['size'];
			}

			if (isset($value['debug'])) {
				$data_entry['debug'] = is_string($value['debug'])
					? sanitize_text_field($value['debug'])
					: (int) $value['debug'];
			}

			if (!empty($value['raw'])) {
				$data_entry['raw'] = (int) $value['raw'];
			}

			$all_sizes[$name] = $data_entry;
		}

		// Cache for 1 hour.
		set_transient('relay_directory_sizes', $all_sizes, HOUR_IN_SECONDS);

		return $all_sizes;
	}

	return [
		'wp_content' => 0,
		'uploads'    => 0,
		'themes'     => 0,
		'plugins'    => 0,
	];
}


