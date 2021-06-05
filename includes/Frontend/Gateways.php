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
    }

    /**
     * @param $available_gateways
     * @return array
     */
    public function filter_available_gateways($available_gateways)
    {
        if (is_admin())
            return $available_gateways;

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
}
