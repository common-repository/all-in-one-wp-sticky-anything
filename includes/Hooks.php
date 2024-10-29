<?php

namespace AI1WPSA;

defined( 'ABSPATH' ) || exit();

class Hooks {

	private static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action('wp_print_styles', array( $this, 'render_custom_css'));
	}

	/**
	 * Render Custom CSS
	 *
	 * @return void
	 */
	public function render_custom_css(){
	$css = ai1wpsa_get_settings( 'customCss' );
	if ( ! empty( $css ) ) {
		echo '<style type="text/css">' . $css . '</style>';
	}
	}

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

Hooks::instance();