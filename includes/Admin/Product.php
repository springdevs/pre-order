<?php

namespace SpringDevs\PreOrder\Admin;

/**
 * Admin Products Handler
 *
 * Class Product
 * @package SpringDevs\PreOrder\Admin
 */
class Product
{
    /**
     * Product's constructor.
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_filter('woocommerce_product_data_tabs', array($this, 'custom_data_tabs'));
        add_filter('woocommerce_product_data_panels', array($this, 'custom_tab_data'));
        add_action("save_post_product", array($this, 'save_data'));
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('sdevs-preorder-admincss');
    }

    public function custom_data_tabs($tabs)
    {
        $class                  = apply_filters('sdevs_preorder_product_datatab_class', 'show_if_simple');
        $tabs['sdevs_preorder'] = array(
            'label'  => __('Pre-Order', 'sdevs_preorder'),
            'class'  => $class,
            'target' => 'sdevs_preorder_meta',
        );
        return $tabs;
    }

    public function custom_tab_data()
    {
        $post_id = get_the_ID();
        $enable = get_post_meta($post_id, "_has_preorder", true) ? "yes" : false;
        $add_to_cart_label = null;
        $no_date_label = null;
        $rels_date_label = "we can ship this product within [_release_date]";
        $rels_date = null;
        if ($enable) {
            $labels = get_post_meta($post_id, "_product_preorder_labels", true);
            if ($labels) {
                $add_to_cart_label = $labels['add_to_cart_label'];
                $no_date_label = $labels['no_date_label'];
                $rels_date_label = $labels['rels_date_label'];
            }
            $rels_date = get_post_meta($post_id, '_preorder_product_release_date', true);
        }
        include 'views/form.php';
    }

    public function save_data($post_id)
    {
        if (isset($_POST['_preorder_free_nonce']) && wp_verify_nonce($_POST['_preorder_free_nonce'], '_preorder_product_form_nonce')) {
            $enable_preorder = isset($_POST['enable_preorder']) ? true : false;
            $rels_date = sanitize_text_field($_POST['rels_date']);
            $add_to_cart_label = sanitize_text_field($_POST['add_to_cart_label']);
            $no_date_label = sanitize_text_field($_POST['no_date_label']);
            $rels_date_label = sanitize_text_field($_POST['rels_date_label']);
            update_post_meta($post_id, "_has_preorder", $enable_preorder);
            update_post_meta($post_id, "_product_preorder_labels", [
                "add_to_cart_label" => $add_to_cart_label,
                "no_date_label" => $no_date_label,
                "rels_date_label" => $rels_date_label,
            ]);
            update_post_meta($post_id, "_preorder_product_release_date", $rels_date);
        }
    }
}
