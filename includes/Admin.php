<?php

namespace AI1WPSA;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin
 * @since 1.0.1
 */
class Admin {

    private static $instance = null;

    public function __construct() {
        add_action('admin_menu', array($this, 'register_menu'));
    }

    public function register_menu() {
        $slug = 'all-in-one-wp-sticky-anything';
        $capability = 'manage_options';

        add_menu_page(
            __('All-in-One WP Sticky Anything', 'all-in-one-wp-sticky-anything'),
            __('Sticky Anything', 'all-in-one-wp-sticky-anything'),
            $capability,
            $slug,
            array($this, 'render_ai1wpsa_settings'),
            'dashicons-sticky',
            89
        );

        add_submenu_page(
            $slug,
            __('Settings - All-in-One Sticky Anything', 'all-in-one-wp-sticky-anything'),
            __('Settings', 'all-in-one-wp-sticky-anything'),
            $capability,
            $slug,
        );

        add_submenu_page(
            $slug,
            __('Getting Started - All-in-One Sticky Anything', 'all-in-one-wp-sticky-anything'),
            __('Getting Started', 'all-in-one-wp-sticky-anything'),
            $capability,
            'sticky-anything-getting-started',
            array($this, 'render_ai1wpsa_getting_started'),
        );
    }

    public function render_ai1wpsa_settings() {
        echo '<div id="ai1wpsa-settings" class="ai1wpsa-settings"></div>';
    }

    public function render_ai1wpsa_getting_started() {
        echo '<div id="ai1wpsa-getting-started" class="ai1wpsa-getting-started"></div>';
    }

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}

Admin::instance();
