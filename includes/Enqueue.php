<?php

namespace AI1WPSA;

if (! defined('ABSPATH')) exit;

class Enqueue {

	private static $instance = null;

	public function __construct() {
		// Frontend scripts
		add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));

		// Admin scripts
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
	}

	public function frontend_scripts() {

		// Styles
		wp_register_style('ai1wpsa-frontend', AI1WPSA_ASSETS . '/css/frontend.css', array(), AI1WPSA_VERSION);

		// Scripts
		wp_register_script('ai1wpsa-stickr', AI1WPSA_ASSETS . '/vendor/stickr.min.js', [
			'jquery',
			'wp-plupload',
			'wp-util',
		], AI1WPSA_VERSION, true);

		wp_register_script('ai1wpsa-frontend', AI1WPSA_ASSETS . '/js/frontend.js', [
			'jquery',
			'wp-plupload',
			'wp-util',
		], AI1WPSA_VERSION, true);

		wp_enqueue_script('ai1wpsa-stickr');

		wp_enqueue_script('ai1wpsa-frontend');

		wp_localize_script('ai1wpsa-frontend', 'ai1wpsa', $this->get_localize_data());
	}

	/**
	 * Admin Assets
	 *
	 * @param [type] $hook
	 * @return void
	 */
	public function admin_scripts($hook) {

		// Styles
		$style_deps = array('wp-components',);

		if ('toplevel_page_all-in-one-wp-sticky-anything' == $hook) {
			$style_deps[] = 'wp-codemirror';
		}

		wp_enqueue_style('ai1wpsa-swal', AI1WPSA_URL . '/assets/vendor/sweetalert2/sweetalert2.min.css', $style_deps, '11.12.4');

		wp_enqueue_style('ai1wpsa-admin', AI1WPSA_URL . '/assets/css/admin.css', $style_deps, AI1WPSA_VERSION);

		// default dependencies
		$deps = array(
			'jquery',
			'wp-util',
			'wp-i18n',
			'wp-element',
			'wp-components',
		);

		if ('toplevel_page_all-in-one-wp-sticky-anything' == $hook) {
			wp_enqueue_script('wp-theme-plugin-editor');

			wp_enqueue_code_editor(array(
				'type'  => 'text/css',
			));
		}

		wp_enqueue_script('ai1wpsa-swal', AI1WPSA_URL . '/assets/vendor/sweetalert2/sweetalert2.min.js', $deps, '11.12.4', true);

		wp_enqueue_script('ai1wpsa-admin', AI1WPSA_URL . '/assets/js/admin.js', $deps, AI1WPSA_VERSION, true);
		wp_localize_script('ai1wpsa-admin', 'ai1wpsa', $this->get_localize_data($hook));
	}

	public function get_localize_data($hook = null) {

		$data = [
			'nonce'     	=> wp_create_nonce('ai1wpsa'),
			'isPro'     	=> true,
			'isLoggedIn'	=> is_user_logged_in(),
			'stickyData' 	=> get_option('ai1wpsa_settings'),
		];

		if (is_admin()) {
			$data['homeUrl'] 	= home_url();
			$data['ajaxUrl'] 	= admin_url('admin-ajax.php');
			$data['pluginUrl'] 	= AI1WPSA_URL;
			$data['adminUrl'] 	= admin_url();
		}

		return apply_filters('ai1wpsa_localize_data', $data, $hook);
	}

	public static function instance() {
		if (null === self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

Enqueue::instance();
