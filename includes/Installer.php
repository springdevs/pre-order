<?php

namespace SpringDevs\PreOrder;

/**
 * Class Installer
 * @package SpringDevs\PreOrder
 */
class Installer
{
    /**
     * Run the installer
     *
     * @return void
     */
    public function run()
    {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version()
    {
        $installed = get_option('sdevs_preorder_installed');

        if (!$installed) {
            update_option('sdevs_preorder_installed', time());
        }

        $gateway_settings = get_option("woocommerce_sdevs-preorder-gateway_settings");
        if (!$gateway_settings) {
            update_option("woocommerce_sdevs-preorder-gateway_settings", [
                "enabled" => "yes",
                "title" => "Pay Later",
                "description" => "When product is confirmed then You need to Pay."
            ]);
        }

        update_option('sdevs_preorder_version', SDEVS_PREORDER_VERSION);
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables()
    {
        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }
    }
}
