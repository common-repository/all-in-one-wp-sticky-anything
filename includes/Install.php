<?php

namespace AI1WPSA;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Install
 * @since 1.0.1
 */
class Install {
    /**
     * Plugin activation stuffs
     *
     * @since 1.0.1
     */
    public static function activate() {
        self::create_default_data();
    }

    /**
     * Plugin upgrade
     * 
     * @since 1.0.2
     */
    public static function upgrade() {
        // Check if the upgrade has already been done
        $upgrade_done = get_option('ai1wpsa_upgrade');

        // If the upgrade hasn't been done yet, proceed
        if (!$upgrade_done) {
            // sticky class
            $sticky_class = get_option('stickyclass');

            if (!empty($sticky_class)) {
                $data = array(
                    'stickyClass' => $sticky_class
                );

                update_option('ai1wpsa_settings', $data);
            }

            // Set the flag to indicate the upgrade has been completed
            update_option('ai1wpsa_upgrade', 1);
        }
    }

    /**
     * Create plugin settings default data
     *
     * @since 1.0.1
     */
    private static function create_default_data() {

        $version      = get_option('ai1wpsa_version');
        $install_time = get_option('ai1wpsa_install_time', '');
        $settings     = get_option('ai1wpsa_settings');

        if (empty($version)) {
            update_option('ai1wpsa_version', AI1WPSA_VERSION);
        }

        if (empty($settings)) {
            update_option('ai1wpsa_settings', '');
        }

        if (empty($install_time)) {
            $date_format = get_option('date_format');
            $time_format = get_option('time_format');
            update_option('ai1wpsa_install_time', date($date_format . ' ' . $time_format));
        }
    }
}
