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
	add_options_page(
		esc_html__( 'Relay Settings', 'relay' ),
		esc_html__( 'Relay', 'relay' ),
		'manage_options',
		'relay-settings',
		'relay_render_settings_page'
	);
}
add_action( 'admin_menu', 'relay_register_settings_page' );

/**
 * Render the settings page.
 *
 * @since 1.3.0
 */
function relay_render_settings_page(): void {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Relay Settings', 'relay' ); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'relay_settings' );
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
		'',
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
	$api_key = get_option( 'relay_api_key', '' );
	?>
	<input type="text" id="relay_api_key" name="relay_api_key" value="<?php echo esc_attr( $api_key ); ?>" class="regular-text">
	<button type="button" id="generate_api_key" class="button"><?php esc_html_e( 'Generate API Key', 'relay' ); ?></button>
	<p class="description"><?php esc_html_e( 'Enter or generate the API key used for authenticating REST API requests.', 'relay' ); ?></p>
	<script>
		function createRandomString(length) {
			const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			let result = '';
			const randomArray = new Uint8Array(length);
			crypto.getRandomValues(randomArray);
			randomArray.forEach((number) => {
				result += chars[number % chars.length];
			});
			return result;
		}

		document.getElementById('generate_api_key').addEventListener('click', function() {
			const length = 16;
			document.getElementById('relay_api_key').value = createRandomString(length);
		});
	</script>
	<?php
}
