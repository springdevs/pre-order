<?php

namespace SpringDevs\PreOrder;

use SpringDevs\PreOrder\Frontend\Account;
use SpringDevs\PreOrder\Frontend\Product;
use SpringDevs\PreOrder\Frontend\Cart;
use SpringDevs\PreOrder\Frontend\Checkout;
use SpringDevs\PreOrder\Frontend\Gateways as FrontendGateways;
use SpringDevs\PreOrder\Frontend\Order;
use SpringDevs\PreOrder\Illuminate\Gateways;
use SpringDevs\PreOrder\Illuminate\Upgrade;

/**
 * Frontend handler class
 */
class Frontend
{
    /**
     * Frontend constructor.
     */
    public function __construct()
    {
        new Upgrade();
        $this->dispatch_actions();
        new Product;
        new Cart;
        new Checkout;
        new Gateways();
        new FrontendGateways();
        new Order();
        new Account();
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions()
    {
        require_once SDEVS_PREORDER_INCLUDES . "/Illuminate/PreorderGateway.php";
    }
}
