<?php

namespace SpringDevs\PreOrder\Frontend;

use SpringDevs\PreOrder\Illuminate\Helper;

/**
 * Class Gateways
 * @package SpringDevs\PreOrder\Frontend
 */

class Gateways
{
    public function __construct()
    {
        add_filter('woocommerce_available_payment_gateways', [$this, "filter_available_gateways"], 10, 1);
        add_filter('woocommerce_gateway_title', [$this, 'change_method_title'], 10, 2);
        add_filter('woocommerce_gateway_description', [$this, "change_method_description"], 10, 2);
    }

    /**
     * @param $available_gateways
     * @return array
     */
    public function filter_available_gateways($available_gateways)
    {
        if (is_admin() || WC()->cart->get_cart_contents_count() == 0)
            return $available_gateways;

        if (!isset($available_gateways['sdevs-preorder-gateway'])) return [];

        $preorder = false;

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $preorder = Helper::has_preorder($cart_item['product_id']);
        }

        if ($preorder) {
            $preorder_gateway = $available_gateways['sdevs-preorder-gateway'];
            $available_gateways = [];
            $available_gateways['sdevs-preorder-gateway'] = $preorder_gateway;
        } else {
            unset($available_gateways['sdevs-preorder-gateway']);
        }

        return $available_gateways;
    }

    public function change_method_title($method_title, $method)
    {
        if ($method == 'sdevs-preorder-gateway') {
            $settings = get_option("woocommerce_sdevs-preorder-gateway_settings");
            if ($settings) $method_title = __($settings['title'], "sdevs_preorder");
        }
        return $method_title;
    }

    public function change_method_description($description, $method)
    {
        if ($method == 'sdevs-preorder-gateway') {
            $settings = get_option("woocommerce_sdevs-preorder-gateway_settings");
            if ($settings) $description = __($settings['description'], "sdevs_preorder");
        }
        return $description;
    }
}
