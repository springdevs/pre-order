<?php

namespace SpringDevs\PreOrder\Admin;

/**
 * Admin Preorder Handler
 *
 * Class Preorder
 * @package SpringDevs\PreOrder\Admin
 */
class Preorder
{
    /**
     * Preorder constructor.
     */
    public function __construct()
    {
        add_action("init", [$this, "create_post_type"]);
        add_action("admin_menu", [$this, "create_admin_menu"]);
        add_filter('bulk_actions-edit-sdevs_preorder', [$this, 'remove_bulk_action']);
        add_filter('post_row_actions', [$this, 'post_row_actions'], 10, 2);
        add_action('add_meta_boxes', [$this, "create_meta_boxes"]);
        add_filter('manage_edit-sdevs_preorder_columns', [$this, 'add_custom_columns']);
        add_action('manage_sdevs_preorder_posts_custom_column', [$this, 'add_custom_columns_data'], 10, 2);
    }

    /**
     *Create Custom Post Type : sdevs_preorder
     */
    public function create_post_type()
    {
        $labels = array(
            "name" => __("Preorders", "sdevs_preorder"),
            "singular_name" => __("Preorder", "sdevs_preorder"),
            'name_admin_bar'        => __('Preorder\'s', 'sdevs_preorder'),
            'archives'              => __('Item Archives', 'sdevs_preorder'),
            'attributes'            => __('Item Attributes', 'sdevs_preorder'),
            'parent_item_colon'     => __('Parent :', 'sdevs_preorder'),
            'all_items'             => __('Preorders', 'sdevs_preorder'),
            'add_new_item'          => __('Add New Preorder', 'sdevs_preorder'),
            'add_new'               => __('Add Preorder', 'sdevs_preorder'),
            'new_item'              => __('New Preorder', 'sdevs_preorder'),
            'edit_item'             => __('View Preorder', 'sdevs_preorder'),
            'update_item'           => __('Update Preorder', 'sdevs_preorder'),
            'view_item'             => __('View Preorder', 'sdevs_preorder'),
            'view_items'            => __('View Preorder', 'sdevs_preorder'),
            'search_items'          => __('Search Preorder', 'sdevs_preorder'),
        );

        $args = array(
            "label" => __("Preorders", "sdevs_preorder"),
            "labels" => $labels,
            "description" => "",
            "public" => false,
            "publicly_queryable" => true,
            "show_ui" => true,
            "delete_with_user" => false,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => false,
            "show_in_nav_menus" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            'capabilities' => array(
                'create_posts' => false
            ),
            "hierarchical" => false,
            "rewrite" => array("slug" => "sdevs_preorder", "with_front" => true),
            "query_var" => true,
            "supports" => array("title"),
        );

        register_post_type("sdevs_preorder", $args);
    }

    public function create_admin_menu()
    {
        $parent_slug = "edit.php?post_type=sdevs_preorder";
        add_menu_page("Preorders", "Preorders", "manage_options", $parent_slug, false, "dashicons-cart", 55);
        remove_meta_box('submitdiv', 'sdevs_preorder', 'side');
    }

    public function remove_bulk_action($actions)
    {
        unset($actions['edit']);
        return $actions;
    }

    /**
     * @param $unset_actions
     * @param $post
     * @return mixed
     */
    public function post_row_actions($unset_actions, $post)
    {
        global $current_screen;
        if ($current_screen->post_type != 'sdevs_preorder')
            return $unset_actions;
        unset($unset_actions['inline hide-if-no-js']);
        unset($unset_actions['view']);
        unset($unset_actions['edit']);
        return $unset_actions;
    }

    public function create_meta_boxes()
    {
        // Details
        add_meta_box(
            'sdevs_preorder_meta_fields',
            'Details',
            [$this, 'preorder_meta_fields'],
            'sdevs_preorder',
            'normal',
            'default'
        );

        // customer_info
        add_meta_box(
            'sdevs_preorder_customer_info',
            __('Customer Info', 'sdevs_preorder'),
            [$this, 'preorder_customer_info'],
            'sdevs_preorder',
            'side',
            'default'
        );
    }

    public function preorder_meta_fields()
    {
        $post_id = get_the_ID();
        $order_id = get_post_meta($post_id, '_order_id', true);
        $product_id = intval(get_post_meta($post_id, '_product_id', true));

        $order = wc_get_order($order_id);
        if ($order) :
            foreach ((array)$order->get_items() as $order_item) :
                if ($order_item['product_id'] === $product_id) :
                    $rels_date = 'N/A';
                    $item_rels_date = $order_item->get_meta('_relase_date', true);
                    if ($item_rels_date) {
                        $rels_date = date('F d, Y', strtotime($item_rels_date));
                    }
                    include 'views/pre-order-details.php';
                endif;
            endforeach;
        endif;
    }

    public function preorder_customer_info()
    {
        $order_id = get_post_meta(get_the_ID(), '_order_id', true);
        $order = wc_get_order($order_id);
        if (!$order) return;
        include 'views/pre-order-customer.php';
    }

    public function add_custom_columns($columns)
    {
        $columns['order'] = __('Order', 'sdevs_preorder');
        $columns['price'] = __('Price', 'sdevs_preorder');
        $columns['rels_date'] = __('Release date', 'sdevs_preorder');
        unset($columns['date']);
        $columns['date'] = __('Date', 'sdevs_preorder');
        return $columns;
    }

    public function add_custom_columns_data($column, $post_id)
    {
        $order_id = get_post_meta($post_id, '_order_id', true);
        $order = wc_get_order($order_id);
        if ($column === 'order') {
            if ($order) {
                echo '<a href="' . get_edit_post_link($order_id) . '" target="_blank">#' . $order_id . '</a>';
            } else {
                esc_html_e('Order not exixts !!', 'sdevs_preorder');
            }
        } elseif ($column === 'price') {
            if ($order) {
                $product_id = intval(get_post_meta($post_id, '_product_id', true));
                foreach ($order->get_items() as $order_item) {
                    if ($order_item['product_id'] === $product_id) {
                        echo wc_price($order_item->get_total());
                    }
                }
            } else {
                esc_html_e('Order not exixts !!', 'sdevs_preorder');
            }
        } elseif ($column === 'rels_date') {
            if ($order) {
                $product_id = intval(get_post_meta($post_id, '_product_id', true));
                foreach ($order->get_items() as $order_item) {
                    if ($order_item['product_id'] === $product_id) {
                        $rels_date = 'N/A';
                        $item_rels_date = $order_item->get_meta('_relase_date', true);
                        if ($item_rels_date) {
                            $rels_date = date('F d, Y', strtotime($item_rels_date));
                        }
                        echo $rels_date;
                    }
                }
            } else {
                esc_html_e('Order not exixts !!', 'sdevs_preorder');
            }
        }
    }
}
