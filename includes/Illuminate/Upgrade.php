<?php

namespace SpringDevs\PreOrder\Illuminate;

/**
 * Class Upgrade
 * @package SpringDevs\PreOrder\Illuminate
 */

class Upgrade
{
    public function __construct()
    {
        add_action('upgrader_process_complete', [$this, 'upgrade_plugin'], 10, 2);
    }

    /**
     * This function runs when WordPress completes its upgrade process
     * It iterates through each plugin updated to see if ours is included
     * @param $upgrader_object Array
     * @param $options Array
     */
    public function upgrade_plugin($upgrader_object, $options)
    {
        $our_plugin = plugin_basename(SDEVS_PREORDER_FILE);
        if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset($options['plugins'])) {
            if (in_array($our_plugin, $options['plugins'])) {
                $this->do_upgrade();
            }
        }
    }

    public function do_upgrade()
    {
        $current_version = get_option('sdevs_preorder_version');
        update_option('sdevs_preorder_version', SDEVS_PREORDER_VERSION);

        $first_versions = ["1.0.0", "1.0.1"];
        if (!$current_version || in_array($current_version, $first_versions)) {
            $gateway_settings = get_option("woocommerce_sdevs-preorder-gateway_settings");
            if (!$gateway_settings) {
                update_option("woocommerce_sdevs-preorder-gateway_settings", [
                    "enabled" => "yes",
                    "title" => "Pay Later",
                    "description" => "When product is confirmed then You need to Pay."
                ]);
            }
        }
    }
}
