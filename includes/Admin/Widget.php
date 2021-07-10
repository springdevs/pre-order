<?php

namespace SpringDevs\PreOrder\Admin;

/**
 * Extend Woocommerce Widgets
 *
 * Class Widget
 * @package SpringDevs\PreOrder\Admin
 */
class Widget
{
    public function __construct()
    {
        add_action('woocommerce_after_dashboard_status_widget', [$this, "dashboard_status_widget"]);
    }

    public function dashboard_status_widget($reports)
    {
        $confirmed_items = $this->get_confirmed_items(0);
        $pending_items = $this->get_pending_items(0);
        include 'views/widget.php';
    }

    public function get_confirmed_items($default)
    {
        $args = array(
            'post_type'   => 'sdevs_preorder'
        );
        $preorders = get_posts($args);
        foreach ($preorders as $preorder) {
            $order_id = get_post_meta($preorder->ID, "_order_id", true);
            $order = wc_get_order($order_id);
            if (!$order->has_status("processing")) $default++;
        }
        return $default;
    }

    public function get_pending_items($default)
    {
        $args = array(
            'post_type'   => 'sdevs_preorder'
        );
        $preorders = get_posts($args);
        foreach ($preorders as $preorder) {
            $order_id = get_post_meta($preorder->ID, "_order_id", true);
            $order = wc_get_order($order_id);
            if ($order->has_status("processing")) $default++;
        }
        return $default;
    }
}
