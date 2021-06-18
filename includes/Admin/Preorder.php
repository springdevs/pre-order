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
        add_filter('post_row_actions', [$this, 'post_row_actions'], 10, 2);
        add_action('add_meta_boxes', [$this, "create_meta_boxes"]);
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
?>
                    <style>
                        #titlewrap>input {
                            pointer-events: none;
                        }
                    </style>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th scope="row"><?php esc_html_e('Product :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    <a href="<?php echo esc_html(get_the_permalink($product_id)); ?>" target="_blank">
                                        <?php esc_html_e($order_item->get_name()); ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e('Qty :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    x<?php echo esc_html($order_item->get_quantity()); ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e('Price :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    <?php echo wc_price($order_item->get_total()); ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e('Order ID :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    <a href="<?php echo get_edit_post_link($order_id); ?>"><?php echo $order_id; ?></a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e('Order Status :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    <?php esc_html_e($order->get_status(), 'sdevs_preorder'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e('Order Date :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    <?php esc_html_e(date('F d, Y', strtotime($order->get_date_created())), 'sdevs_preorder'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e('Release Date :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    <?php esc_html_e($rels_date, 'sdevs_preorder'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e('Payment Method :', 'sdevs_preorder'); ?> </th>
                                <td>
                                    <?php esc_html_e($order->get_payment_method_title(), 'sdevs_preorder'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Billing :', 'sdevs_preorder'); ?></th>
                                <td><?php echo $order->get_formatted_billing_address(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?php esc_html_e('Shipping :', 'sdevs_preorder') ?></th>
                                <td><?php echo $order->get_formatted_shipping_address() ? $order->get_formatted_shipping_address() : esc_html("No shipping address set.", 'sdevs_preorder'); ?></td>
                            </tr>
                        </tbody>
                    </table>
        <?php
                endif;
            endforeach;
        endif;
    }

    public function preorder_customer_info()
    {
        $order_id = get_post_meta(get_the_ID(), '_order_id', true);
        $order = wc_get_order($order_id);
        if (!$order) return;
        ?>
        <table class="booking-customer-details" style="width: 100%;">
            <tbody>
                <tr>
                    <th><?php esc_html_e('Name:', 'sdevs_preorder') ?></th>
                    <td><?php echo $order->get_formatted_billing_full_name(); ?></td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Email:', 'sdevs_preorder'); ?></th>
                    <td><a href="mailto:<?php echo esc_html($order->get_billing_email()); ?>"><?php echo esc_html($order->get_billing_email()); ?></a></td>
                </tr>
                <tr>
                    <th><?php esc_html_e('Phone:', 'sdevs_preorder'); ?></th>
                    <td><?php echo esc_html($order->get_billing_phone()); ?></td>
                </tr>
                <tr class="view">
                    <th>&nbsp;</th>
                    <td><br><a class="button button-small" target="_blank" href="<?php echo esc_html(get_edit_post_link($order_id)); ?>"><?php esc_html_e('View Order', 'sdevs_preorder'); ?></a></td>
                </tr>
            </tbody>
        </table>
<?php
    }
}
