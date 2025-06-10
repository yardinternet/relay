<?php
/**
 * Relay settings.
 *
 * @package Relay
 * @author  Verdant Studio
 * @since   1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the settings page.
 *
 * @since 1.3.0
 */
function relay_register_settings_page(): void {
	$parent     = is_multisite() ? 'settings.php' : 'options-general.php';
	$capability = is_multisite() ? 'manage_network_options' : 'manage_options';

	add_submenu_page(
		$parent,
		esc_html__( 'Relay Settings', 'relay' ),
		esc_html__( 'Relay', 'relay' ),
		$capability,
		'relay-settings',
		'relay_render_settings_page'
	);
}
add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', 'relay_register_settings_page' );

/**
 * Render the settings page.
 *
 * @since 1.3.0
 */
function relay_render_settings_page(): void {
	$action = is_multisite()
		? network_admin_url( 'edit.php?action=relay_save_settings' )
		: 'options.php';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Relay Settings', 'relay' ); ?></h1>

		<?php // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
		<?php if ( isset( $_GET['settings-updated'] ) || isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings saved.', 'relay' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( $action ); ?>">
			<?php
			if ( is_multisite() ) {
				// Add nonce field for multisite custom save handler.
				wp_nonce_field( 'relay_settings-options' );
			} else {
				settings_fields( 'relay_settings' );
			}

			do_settings_sections( 'relay_settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Register the API key setting.
 *
 * @since 1.3.0
 */
function relay_register_settings(): void {
	register_setting(
		'relay_settings',
		'relay_api_key',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '',
		)
	);

	add_settings_section(
		'relay_settings_section',
		'', // Intentionally left blank.
		'__return_empty_string',
		'relay_settings'
	);

	add_settings_field(
		'relay_api_key',
		esc_html__( 'API Key', 'relay' ),
		'relay_render_api_key_field',
		'relay_settings',
		'relay_settings_section'
	);
}
add_action( 'admin_init', 'relay_register_settings' );

/**
 * Render the API key field with a generator button.
 *
 * @since 1.3.0
 */
function relay_render_api_key_field(): void {
	$api_key = is_network_admin()
		? get_site_option( 'relay_api_key', '' )
		: get_option( 'relay_api_key', '' );
	?>
	<input type="text" id="relay_api_key" name="relay_api_key" value="<?php echo esc_attr( $api_key ); ?>" class="regular-text" autocomplete="off" spellcheck="false">
	<button type="button" id="generate_api_key" class="button"><?php esc_html_e( 'Generate API Key', 'relay' ); ?></button>
	<p class="description"><?php esc_html_e( 'Enter or generate the API key used for authenticating REST API requests.', 'relay' ); ?></p>
	<script>
		document.getElementById('generate_api_key').addEventListener('click', function () {
			const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			let result = '';
			const arr = new Uint8Array(16);
			crypto.getRandomValues(arr);
			arr.forEach(n => result += chars[n % chars.length]);
			document.getElementById('relay_api_key').value = result;
		});
	</script>
	<?php
}

/**
 * Multisite: intercept the save via custom handler.
 *
 * @since 1.3.1
 */
if ( is_multisite() ) {
	add_action( 'network_admin_edit_relay_save_settings', 'relay_save_network_settings' );
}

/**
 * Save network settings on multisite.
 *
 * @since 1.3.1
 */
function relay_save_network_settings(): void {
	check_admin_referer( 'relay_settings-options' );

	$key = isset( $_POST['relay_api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['relay_api_key'] ) ) : '';
	update_site_option( 'relay_api_key', $key );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'             => 'relay-settings',
				'settings-updated' => 'true',
			),
			network_admin_url( 'settings.php' )
		)
	);
	exit;
}
