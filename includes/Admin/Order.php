<?php

namespace SpringDevs\PreOrder\Admin;

/**
 * Admin Orders Handler
 *
 * Class Order
 * @package SpringDevs\PreOrder\Admin
 */
class Order
{
    /**
     * Order's constructor.
     */
    public function __construct()
    {
        add_filter('manage_edit-shop_order_columns', [$this, 'add_custom_columns']);
        add_action('manage_shop_order_posts_custom_column', [$this, 'add_custom_columns_data'], 10, 2);
        add_action('woocommerce_before_order_itemmeta', [$this, 'add_preorder_label'], 10, 2);
        add_filter('woocommerce_order_item_get_formatted_meta_data', [$this, 'remove_item_meta'], 10, 2);
        add_filter('woocommerce_order_item_display_meta_key', [$this, 'change_order_item_key'], 20, 3);
        add_filter('woocommerce_order_item_display_meta_value', [$this, 'change_order_item_value'], 20, 3);
    }

    public function add_custom_columns($columns)
    {
        $columns['sdevs_preorders'] = __('Pre-Order', 'sdevs_preorder');
        return $columns;
    }

    public function add_custom_columns_data($column, $order_id)
    {
        if ($column == "sdevs_preorders") :
            $preorder_items = [];

            $order = wc_get_order($order_id);
            foreach ($order->get_items() as $order_item) {
                if ($order_item->get_meta('_has_preorder', true)) {
                    $preorder_items[] = $order_item;
                }
            }

            foreach ($preorder_items as $preorder_item) :
                $rels_date = $preorder_item->get_meta('_relase_date', true) ? date('F d, Y', strtotime($preorder_item->get_meta('_relase_date', true))) : __('No date set', 'sdevs_preorder');
                include 'views/order-column.php';
            endforeach;
        endif;
    }

    public function add_preorder_label($item_id, $item)
    {
        if ($item->get_meta('_has_preorder', true)) echo '<mark>' . __(get_option('preorder_order_item_marker_txt', 'Pre-Order product'), 'sdevs_preorder') . '</mark>';
    }

    public function remove_item_meta($formatted_meta, $item)
    {
        foreach ($formatted_meta as $key => $meta) {
            if (in_array($meta->key, array('_has_preorder')))
                unset($formatted_meta[$key]);
        }

        return $formatted_meta;
    }

    public function change_order_item_key($key, $meta, $item)
    {
        if ('_relase_date' === $meta->key) {
            $key = 'Release Date';
        }

        return $key;
    }

    public function change_order_item_value($value, $meta, $item)
    {
        if ('_relase_date' === $meta->key) {
            $value = date('F d, Y', strtotime($value));
        }

        return $value;
    }
}
