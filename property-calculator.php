<?php
defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

/*
Plugin Name: Property Calculator
Plugin URI: https://archangeldev.com/
Description: Plugin for calculating property value
Author: Rafal Martinez-Marjanski
Author URI: https://github.com/ArchangelDesign
Version: 1.0.1
*/

const ADPC_VERSION = '1.0.0';
const ADPC_REQUIRED_WP_VERSION = '5.3';

define( 'ADPC_PLUGIN', __FILE__ );

define( 'ADPC_PLUGIN_BASENAME', plugin_basename( ADPC_PLUGIN ) );

define( 'ADPC_PLUGIN_NAME', trim( dirname( ADPC_PLUGIN_BASENAME ), '/' ) );

define( 'ADPC_PLUGIN_DIR', untrailingslashit( dirname( ADPC_PLUGIN ) ) );

require_once ADPC_PLUGIN_DIR . '/lib/AdpcRenderer.php';
$renderer = new AdpcRenderer();

add_shortcode('adpc_form', [$renderer, 'displayForm']);

function adpc_add_settings_init() {
    global $renderer;
    add_menu_page(
        'Property Calculator Settings',
        'Property Calculator',
        'manage_options',
        'adpc_settings',
        [$renderer, 'displaySettingsPage']
    );
}

function adpc_setup_settings() {
    global $renderer;
    add_settings_section('adpc_cap_rate', 'Cap Rate', false, 'adpc_settings');
    add_settings_field('adpc_cap_class_a', 'Class A minimum income', [$renderer, 'fieldClassAcap'], 'adpc_settings', 'adpc_cap_rate');
    register_setting('adpc_settings', 'class_a_min');
}

add_action('admin_menu', 'adpc_add_settings_init');
add_action('admin_init', 'adpc_setup_settings');
