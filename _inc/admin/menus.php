<?php
add_action('admin_menu', 'wpa_register_menu');
function wpa_register_menu()
{
    add_menu_page(
        'مدیریت محصولات',
        'مدیریت محصولات',
        'manage_options',
        'wpa-product-home',
        'wpa_product_handler',
        'dashicons-products'

    );
}
function wpa_product_handler()
{
    include WPA_PLUGIN_VIEW.'admin/product-list.php';
}
