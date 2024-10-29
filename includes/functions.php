<?php

/**
 * Get ai1wpsa settings
 *
 * @param string $key
 * @param string $default
 * @return void
 */
function ai1wpsa_get_settings($key = null, $default = null) {

    $settings = get_option('ai1wpsa_settings');

    if ($key === null) {
        return $settings;
    }

    return isset($settings[$key]) ? $settings[$key] : $default;
}
