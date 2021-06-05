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
        $installed = get_option('Pre Order_installed');

        if (!$installed) {
            update_option('Pre Order_installed', time());
        }

        update_option('Pre Order_version', SDEVS_PREORDER_VERSION);
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

        // global $wpdb;

        // $charset_collate = $wpdb->get_charset_collate();
        // $table_name      = $wpdb->prefix . 'preorder_lists';

        // $schema = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
        //               `id` INT(11) NOT NULL AUTO_INCREMENT,
        //               `order_id` INT(11) NOT NULL,
        //               `product_id` INT(11) NOT NULL,
        //               PRIMARY KEY (`id`)
        //             ) $charset_collate";

        // dbDelta($schema);
    }
}
