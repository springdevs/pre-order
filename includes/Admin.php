<?php

namespace SpringDevs\PreOrder;

use SpringDevs\PreOrder\Admin\Order;
use SpringDevs\PreOrder\Admin\Preorder;
use SpringDevs\PreOrder\Admin\Product;
use SpringDevs\PreOrder\Admin\Settings;
use SpringDevs\PreOrder\Frontend\Order as FrontendOrder;
use SpringDevs\PreOrder\Illuminate\Gateways;

/**
 * The admin class
 */
class Admin
{

    /**
     * Initialize the class
     */
    public function __construct()
    {
        $this->dispatch_actions();
        new Product();
        new Gateways();
        new Preorder();
        new Settings();
        new Order();
        new FrontendOrder();
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
