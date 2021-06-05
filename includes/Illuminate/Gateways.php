<?php

namespace SpringDevs\PreOrder\Illuminate;

/**
 * Class Gateways
 * @package SpringDevs\PreOrder\Illuminate
 */

class Gateways
{
    public function __construct()
    {
        add_filter('woocommerce_payment_gateways', [$this, "include_gateway"]);
    }

    public function include_gateway($gateways)
    {
        $gateways[] = 'PreorderGateway'; // gateway class
        return $gateways;
    }
}
