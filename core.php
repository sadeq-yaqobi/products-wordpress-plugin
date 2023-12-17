<?php
/* Plugin Name: Products Plugin
 * Plugin URI: https://github.com/sadeq-yaqobi/products-wordpress-plugin/
 * Description: پلاگین محصولات ساخته شده با ایجکس (Products plugin created with AJAX)
 * Author: Sadeq Yaqobi
 * Version: 1.0.0
 * License: GPLv2 or later
 * Author URI: https://github.com/sadeq-yaqobi/
 */

defined('ABSPATH') || exit();

// Defining required constants
define('WPA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPA_PLUGIN_URL', plugin_dir_url(__FILE__));
const WPA_PLUGIN_INC = WPA_PLUGIN_DIR . '_inc/';
const WPA_PLUGIN_VIEW = WPA_PLUGIN_DIR . 'view/';
const WPA_PLUGIN_ASSETS_DIR = WPA_PLUGIN_DIR . 'assets/';
const WPA_PLUGIN_ASSETS_URL = WPA_PLUGIN_URL . 'assets/';

// Creating table for custom products
function create_custom_products_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'products';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        ID int(11) NOT NULL,
        p_name varchar(255) NOT NULL,
        p_brand varchar(255) NOT NULL,
        p_model varchar(255) NOT NULL,
        p_price varchar(255) NOT NULL,
        p_status int(1) NOT NULL DEFAULT 0 COMMENT '0:unavailable 1:available',
        create_at datetime NOT NULL DEFAULT current_timestamp(),
        update_at datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (ID)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Registering activation hook
register_activation_hook(__FILE__, 'activate_wp_ajax_plugin');

// Activation hook callback
function activate_wp_ajax_plugin()
{
    // Create custom products table
    create_custom_products_table();
}

// Registering styles and scripts
function wps_register_style_js()
{
    // Registering styles
    if (is_admin()) {
        wp_register_style('bootstrap-5', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css', '', '5.0.2');
        wp_register_style('bootstrap-icon', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css', '', '1.11.2');
        wp_register_style('fontawesome-icon', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', '', '5.15.4');
        wp_register_style('main-style', WPA_PLUGIN_ASSETS_URL . 'css/main-style.css', '', '1.0.0');
        wp_enqueue_style('bootstrap-5');
        wp_enqueue_style('bootstrap-icon');
        wp_enqueue_style('fontawesome-icon');
        wp_enqueue_style('main-style');
    }
    // Registering scripts
    if (is_admin()) {
        wp_register_script('sweet-alert-js', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', '', '2.11.0', ['strategy' => 'async', 'in_footer' => true]);
        wp_register_script('dashboard-js', WPA_PLUGIN_ASSETS_URL . 'js/dashboard-js.js', ['jquery'], '1.0.0', ['strategy' => 'defer', 'in_footer' => false]);
        wp_register_script('dashboard-ajax-js', WPA_PLUGIN_ASSETS_URL . 'js/dashboard-ajax.js', ['jquery'], '1.0.0', ['strategy' => 'defer', 'in_footer' => true]);
        wp_enqueue_script('sweet-alert-js');
        wp_enqueue_script('dashboard-js');
        wp_enqueue_script('dashboard-ajax-js');
    } else {
        wp_register_script('main-js', WPA_PLUGIN_ASSETS_URL . 'js/main-js.js', ['jquery'], '1.0.0', ['strategy' => 'defer', 'in_footer' => false]);
        wp_enqueue_script('main-js');
    }
    wp_register_script('bootstrap-5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', '', '5.3.2', ['strategy' => 'defer', 'in_footer' => false]);
    wp_enqueue_script('bootstrap-5-js');

    // Localize script for AJAX
    wp_localize_script('dashboard-ajax-js', 'ajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        '_nonce' => wp_create_nonce()
    ]);
}

add_action('wp_enqueue_scripts', 'wps_register_style_js');
add_action('admin_enqueue_scripts', 'wps_register_style_js');

// Include necessary files for the admin section
if (is_admin()) {
    include WPA_PLUGIN_INC . 'admin/menus.php';
    include WPA_PLUGIN_INC . 'admin/products.php';
}
