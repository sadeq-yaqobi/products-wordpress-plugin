<?php
// Registering the admin menu
add_action('admin_menu', 'wpa_register_menu');

/**
 * Function to register the admin menu.
 */
function wpa_register_menu()
{
    // Adding the menu page
    add_menu_page(
        'مدیریت محصولات',        // Page title displayed in the menu
        'مدیریت محصولات',        // Menu title
        'manage_options',           // Capability required to access the menu
        'wpa-product-home',         // Menu slug
        'wpa_product_handler',      // Callback function to handle the menu page content
        'dashicons-products'        // Icon for the menu
    );
}

/**
 * Callback function to handle the content of the menu page.
 */
function wpa_product_handler()
{
    // Including the file responsible for displaying the product list
    include WPA_PLUGIN_VIEW . 'admin/product-list.php';
}
