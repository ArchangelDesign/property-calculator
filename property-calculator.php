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
require_once ADPC_PLUGIN_DIR . '/lib/Adpc.php';
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
    add_settings_section(Adpc::SETTINGS_SECTION_CAP_RATE, 'Cap Rate', false, Adpc::SETTINGS_PAGE);
    // class A minimum income
    add_settings_field(Adpc::OPTION_CLASS_A_MIN, 'Class A minimum income', [$renderer, 'optionClassAmin'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_A_MIN);
    // class B minimum income
    add_settings_field(Adpc::OPTION_CLASS_B_MIN, 'Class B minimum income', [$renderer, 'optionClassBmin'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_B_MIN);
    // class C minimum income
    add_settings_field(Adpc::OPTION_CLASS_C_MIN, 'Class C minimum income', [$renderer, 'optionClassCmin'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_C_MIN);
    // class A cap rate
    add_settings_field(Adpc::OPTION_CLASS_A_CAP_RATE, 'Class A cap rate', [$renderer, 'optionClassAcapRate'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_A_CAP_RATE);
    // class B cap rate
    add_settings_field(Adpc::OPTION_CLASS_B_CAP_RATE, 'Class B cap rate', [$renderer, 'optionClassBcapRate'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_B_CAP_RATE);
    // class C cap rate
    add_settings_field(Adpc::OPTION_CLASS_C_CAP_RATE, 'Class C cap rate', [$renderer, 'optionClassCcapRate'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_C_CAP_RATE);
    // class D cap rate
    add_settings_field(Adpc::OPTION_CLASS_D_CAP_RATE, 'Class D cap rate', [$renderer, 'optionClassDcapRate'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_D_CAP_RATE);
    // class A max age
    add_settings_field(Adpc::OPTION_CLASS_A_MAX_AGE, 'Class A max age', [$renderer, 'optionClassAmaxAge'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_A_MAX_AGE);
    // class B max age
    add_settings_field(Adpc::OPTION_CLASS_B_MAX_AGE, 'Class B max age', [$renderer, 'optionClassBmaxAge'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_B_MAX_AGE);
    // class B min age
    add_settings_field(Adpc::OPTION_CLASS_B_MIN_AGE, 'Class B min age', [$renderer, 'optionClassBminAge'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_B_MIN_AGE);
    // class C max age
    add_settings_field(Adpc::OPTION_CLASS_C_MAX_AGE, 'Class C max age', [$renderer, 'optionClassCmaxAge'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_C_MAX_AGE);
    // class C min age
    add_settings_field(Adpc::OPTION_CLASS_C_MIN_AGE, 'Class C min age', [$renderer, 'optionClassCminAge'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_C_MIN_AGE);
    // class D min age
    add_settings_field(Adpc::OPTION_CLASS_D_MIN_AGE, 'Class D min age', [$renderer, 'optionClassDminAge'], Adpc::SETTINGS_PAGE, Adpc::SETTINGS_SECTION_CAP_RATE);
    register_setting(Adpc::SETTINGS_PAGE, Adpc::OPTION_CLASS_D_MIN_AGE);

}

add_action('admin_menu', 'adpc_add_settings_init');
add_action('admin_init', 'adpc_setup_settings');
