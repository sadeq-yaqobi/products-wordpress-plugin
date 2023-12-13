<?php
add_action('wp_ajax_insert_product', 'insert_product');
add_action('wp_ajax_delete_product', 'delete_product');
add_action('wp_ajax_find_product_by_ID', 'find_product_by_ID');
add_action('wp_ajax_update_product', 'update_product');

function all_product()
{
    global $wpdb;
    $table = $wpdb->prefix . 'products';
    $stmt = $wpdb->get_results("SELECT ID,p_name,p_brand,p_model,p_price,p_status FROM {$table}");
    if (!$stmt)
        return false;
    return $stmt;
}

function insert_product()
{
    if (!wp_verify_nonce($_POST['_nonce'])) {
        wp_send_json([
            'error' => true,
            'message' => 'access denied'
        ], 403);
    }
    global $wpdb;
    $table = $wpdb->prefix . 'products';
    $data = [
        'p_name' => sanitize_text_field($_POST['productName']),
        'p_brand' => sanitize_text_field($_POST['productBrand']),
        'p_model' => sanitize_text_field($_POST['productModel']),
        'p_price' => sanitize_text_field($_POST['productPrice']),
        'p_status' => intval($_POST['productStatus']),
    ];
    $format = ['%s', '%s', '%s', '%s', '%d'];
    $stmt = $wpdb->insert($table, $data, $format);
    if ($stmt) {
        $ID = $wpdb->insert_id;
        $data['ID'] = $ID;
        wp_send_json([
            'success' => true,
            'message' => 'محصول جدید با موفقیت اضافه گردید',
            'data' => $data
        ], 200);

    } else {
        wp_send_json([
            'error' => true,
            'message' => 'در اضافه کردن محصول خطایی رخ داده است'
        ], 403);
    }
}

function delete_product()
{
    if (!wp_verify_nonce($_POST['_nonce'])) {
        wp_send_json([
            'error' => true,
            'message' => 'access denied'
        ], 403);
    }
    global $wpdb;
    $table = $wpdb->prefix . 'products';
    $where = ['ID' => intval($_POST['product_id'])];
    $where_format = ['%d'];
    $stmt = $wpdb->delete($table, $where, $where_format);
    if ($stmt) {
        wp_send_json([
            'success' => true,
            'message' => 'محصول شما با موفقیت حذف شد'
        ], 200);
    } else {
        wp_send_json([
            'error' => true,
            'message' => 'در حذف کردن محصول خطایی رخ داده است'
        ], 403);
    }

}

function find_product_by_ID()
{
    if (!wp_verify_nonce($_POST['_nonce'])) {
        wp_send_json([
            'error' => true,
            'message' => 'access denied'
        ], 403);
    }
    global $wpdb;
    $table = $wpdb->prefix . 'products';
    $ID = intval($_POST['product_id']);

    $stmt = $wpdb->get_row($wpdb->prepare("SELECT ID,p_name,p_brand,p_model,p_price,p_status FROM {$table} WHERE ID='%d'", $ID));
    $out_put = [
        'ID' => $stmt->ID,
        'p_name' => $stmt->p_name,
        'p_brand' => $stmt->p_brand,
        'p_model' => $stmt->p_model,
        'p_price' => $stmt->p_price,
        'p_status' => $stmt->p_status
    ];
    echo json_encode($out_put);
    wp_die(); // if not used ,zero is returned in the response
}

function update_product()
{
    if (!wp_verify_nonce($_POST['_nonce'])) {
        wp_send_json([
            'error' => true,
            'message' => 'access denied'
        ], 403);
    }
    global $wpdb;
    $table = $wpdb->prefix . 'products';
    $ID = intval($_POST['updateID']);
    $data = [
        'p_name' => sanitize_text_field($_POST['updateName']),
        'p_brand' => sanitize_text_field($_POST['updateBrand']),
        'p_model' => sanitize_text_field($_POST['updateModel']),
        'p_price' => sanitize_text_field($_POST['updatePrice']),
        'p_status' => intval($_POST['updateStatus'])
    ];

    $where = ['ID' => $ID];
    $format = ['%s', '%s', '%s', '%s', '%d'];
    $where_format = ['%d'];
    $stmt = $wpdb->update($table, $data, $where, $format, $where_format);
    if ($stmt) {
        $data['ID'] = $ID;
        wp_send_json([
            'success' => true,
            'message' => 'به روزرسانی با موفقیت انجام شد',
            'data'=>$data
        ], 200);
    } else {
        wp_send_json([
            'error' => true,
            'message' => 'خطایی در به روزرسانی صورت گرفته است'
        ], 403);
    }

}
