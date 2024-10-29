<?php
/**
 * Plugin Name:       All-in-One WP Sticky Anything
 * Plugin URI:        https://wordpress.org/plugins/all-in-one-all-in-one-wp-sticky-anything
 * Description:       All-in-One WP Sticky Anything plugin will make stick to the side of page after when scrolled up & down.
 * Version:           1.0.2
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Monzur Alam
 * Author URI:        https://profiles.wordpress.org/monzuralam
 * Text Domain:       all-in-one-wp-sticky-anything
 * Domain Path:       /languages/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/** define constants */
define( 'AI1WPSA_VERSION', '1.0.2' );
define( 'AI1WPSA_FILE', __FILE__ );
define( 'AI1WPSA_PATH', dirname( AI1WPSA_FILE ) );
define( 'AI1WPSA_INCLUDES', AI1WPSA_PATH . '/includes' );
define( 'AI1WPSA_URL', plugins_url( '', AI1WPSA_FILE ) );
define( 'AI1WPSA_ASSETS', AI1WPSA_URL . '/assets' );

/*
 * The code that runs during plugin activation
 *
 * @since 1.0.1
 */
register_activation_hook( AI1WPSA_FILE, function () {

	if ( ! class_exists( 'AI1WPSA\Install' ) ) {
		require_once AI1WPSA_INCLUDES . '/Install.php';
	}

	AI1WPSA\Install::activate();
} );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 *
 * @since 1.0.1
 */
add_action( 'plugins_loaded', function () {
	include_once AI1WPSA_INCLUDES . '/Main.php';
} );