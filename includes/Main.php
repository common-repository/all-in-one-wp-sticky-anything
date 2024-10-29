<?php

namespace AI1WPSA;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main
 * @since 1.0.1
 */
final class Main {
    /**
     * The single instance of the class.
     * @var Main
     * @since 1.0.1
     */
    protected static $instance = null;

    public function __construct() {

        $this->includes();
        $this->init_hooks();

        do_action('ai1wpsa_loaded');
    }

    /**
     * Include required core files used in admin and on the frontend.
     *
     * @return void
     * @since 1.0.1
     *
     */
    public function includes() {
        include_once AI1WPSA_INCLUDES . '/Enqueue.php';
        include_once AI1WPSA_INCLUDES . '/Hooks.php';
        include_once AI1WPSA_INCLUDES . '/Ajax.php';
        include_once AI1WPSA_INCLUDES . '/functions.php';

        if (is_admin()) {
            include_once AI1WPSA_INCLUDES . '/Admin.php';
        }
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.1
     */
    private function init_hooks() {

        // migrate old data
        add_action('admin_init', [$this, 'migrate_old_data']);

        add_action('admin_notices', [$this, 'print_notices'], 15);

        // Localize our plugin
        add_action('init', [$this, 'localization_setup']);

        // Plugin action links
        add_filter('plugin_action_links_' . plugin_basename(AI1WPSA_FILE), [$this, 'plugin_action_links']);
    }

    /**
     * Migrate Data
     *
     * @return void
     */
    public function migrate_old_data(){
        if ( ! class_exists( 'AI1WPSA\Install' ) ) {
            require_once AI1WPSA_INCLUDES . '/Install.php';
        }
    
        Install::upgrade();
    }

    /**
     * Admin notice
     *
     * @return void
     * @since 1.0.1
     *
     */
    public function print_notices() {
        $notices = get_option(sanitize_key('ai1wpsa_notices'), []);

        foreach ($notices as $notice) { ?>
            <div class="notice notice-large is-dismissible wpforms-extended-admin-notice notice-<?php echo esc_attr($notice['class']); ?>">
                <?php esc_html_e($notice['message'], 'all-in-one-wp-sticky-anything'); ?>
            </div>
<?php
            update_option(sanitize_key('ai1wpsa_notices'), []);
        }
    }

    /**
     * Initialize plugin for localization
     *
     * @return void
     * @since 1.0.1
     *
     */
    public function localization_setup() {
        load_plugin_textdomain('all-in-one-wp-sticky-anything', false, dirname(plugin_basename(AI1WPSA_FILE)) . '/languages/');
    }

    /**
     * Plugin links
     * @since 1.0.1
     */
    public function plugin_action_links($links) {
        $links[] = '<a href="' . admin_url('admin.php?page=all-in-one-wp-sticky-anything') . '" >' . __('Settings', 'all-in-one-wp-sticky-anything') . '</a>';

        return $links;
    }


    /**
     * Main Instance
     * 
     * Ensure only one instance of the Main is loaded or can be loaded.
     * @return Main
     * @since 1.0.1
     * @static
     */
    static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

// kickof wpforms extended
if (!function_exists('ai1wpsa')) {
    function ai1wpsa() {
        return Main::instance();
    }
}

ai1wpsa();
