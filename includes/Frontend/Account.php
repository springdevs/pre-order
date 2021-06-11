<?php

namespace SpringDevs\PreOrder\Frontend;

/**
 * Class Account
 * @package SpringDevs\PreOrder\Frontend
 */
class Account
{

    public function __construct()
    {
        add_action("init", [$this, "flush_rewrite_rules"]);
        add_filter('the_title', [$this, 'change_endpoint_title']);
        add_filter('woocommerce_account_menu_items', [$this, 'custom_my_account_menu_items']);
        add_action('woocommerce_account_preorder-endpoint_endpoint', [$this, 'preorder_endpoint_content']);
    }

    /**
     * Re-write flush
     */
    public function flush_rewrite_rules()
    {
        add_rewrite_endpoint('preorder-endpoint', EP_ROOT | EP_PAGES);
        flush_rewrite_rules();
    }

    /**
     * @param $title
     * @return string|void
     */
    public function change_endpoint_title($title)
    {
        global $wp_query;
        $is_endpoint = isset($wp_query->query_vars['preorder-endpoint']);
        if ($is_endpoint && !is_admin() && is_main_query() && in_the_loop() && is_account_page()) {
            $title = __('Pre-Orders', 'woocommerce');
            remove_filter('the_title', [$this, 'change_endpoint_title']);
        }
        return $title;
    }

    /**
     * @param $items
     * @return mixed
     */
    public function custom_my_account_menu_items($items)
    {
        $logout = $items['customer-logout'];
        unset($items['customer-logout']);
        $items['preorder-endpoint'] = __('Pre-Orders', 'sdevs_preorder');
        $items['customer-logout'] = $logout;
        return $items;
    }

    /**
     * PreOrder EndPoint Content
     */
    public function preorder_endpoint_content()
    {
        wc_get_template('myaccount/preorders.php', [], 'preorder', SDEVS_PREORDER_TEMPLATES);
    }
}
