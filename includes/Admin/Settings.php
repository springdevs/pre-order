<?php

namespace SpringDevs\PreOrder\Admin;

/**
 * Admin Settings Handler
 *
 * Class Settings
 * @package SpringDevs\PreOrder\Admin
 */
class Settings
{
    /**
     * Settings constructor.
     */
    public function __construct()
    {
        add_action("admin_menu", [$this, "create_admin_menu"]);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function create_admin_menu()
    {
        $parent_slug = "edit.php?post_type=sdevs_preorder";
        $hook = add_submenu_page($parent_slug, __('Settings >> Pre-Order', 'sdevs_preorder'), __('Settings', 'sdevs_preorder'), 'manage_options', 'sdevs-preorder-settings', [$this, 'settings_content']);

        add_action('load-' . $hook, [$this, 'init_hooks']);
    }

    /**
     * Initialize our hooks for the settings page
     *
     * @return void
     */
    public function init_hooks()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('sdevs-preorder-adminjs');
    }

    /**
     * register settings options
     **/
    public function register_settings()
    {
        register_setting('preorder_settings', 'preorder_default_add_to_cart_txt');
        register_setting('preorder_settings', 'preorder_no_date_label_color');
        register_setting('preorder_settings', 'preorder_rels_date_label_color');
        register_setting('preorder_settings', 'preorder_order_item_marker_txt');
        do_action('sdevs_preorder_register_settings', 'preorder_settings');
    }

    public function settings_content()
    {
        include 'views/settings.php';
    }
}
