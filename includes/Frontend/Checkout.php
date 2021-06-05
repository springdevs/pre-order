<?php

namespace SpringDevs\PreOrder\Frontend;

use SpringDevs\PreOrder\Illuminate\Helper;

/**
 * Class Checkout
 * @package SpringDevs\PreOrder\Frontend
 */
class Checkout
{

    public function __construct()
    {
        add_action('woocommerce_checkout_update_order_meta', [$this, 'save_order_meta']);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'save_order_item_product_meta'], 10, 4);
    }

    public function save_order_meta($order_id)
    {
        $order = wc_get_order($order_id);
        foreach ($order->get_items() as $order_item) {
            $has_preorder = Helper::has_preorder((int)$order_item['product_id']);
            if ($has_preorder) {
                $args = [
                    "post_title" => get_the_title((int)$order_item['product_id']),
                    "post_type" => "sdevs_preorder",
                    'post_status' =>  'publish'
                ];
                $post_id = wp_insert_post($args);
                if ($post_id) {
                    update_post_meta($post_id, '_order_id', $order_id);
                    update_post_meta($post_id, '_product_id', $order_item['product_id']);
                    $post_ids = get_post_meta($order_id, '_preorders', true);
                    if (!is_array($post_ids)) $post_ids = [];
                    if (!in_array($post_id, $post_ids)) $post_ids[] = $post_id;
                    update_post_meta($order_id, '_preorders', $post_ids);
                }
            }
        }
    }

    public function save_order_item_product_meta($item, $cart_item_key, $cart_item, $order)
    {
        $has_preorder = Helper::has_preorder((int)$cart_item['product_id']);
        if ($has_preorder) {
            $rels_date = get_post_meta($cart_item['product_id'], '_preorder_product_release_date', true);
            $item->update_meta_data('_has_preorder', 'yes');
            $item->update_meta_data('_relase_date', $rels_date);
        }
    }
}
