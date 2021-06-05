<?php

namespace SpringDevs\PreOrder\Admin;

/**
 * Admin Preorder Handler
 *
 * Class Preorder
 * @package SpringDevs\PreOrder\Admin
 */
class Preorder
{
    /**
     * Preorder constructor.
     */
    public function __construct()
    {
        add_action("init", [$this, "create_post_type"]);
        // add_action("admin_menu", [$this, "create_admin_menu"]);
    }

    /**
     *Create Custom Post Type : sdevs_preorder
     */
    public function create_post_type()
    {
        $labels = array(
            "name" => __("Preorders", "sdevs_wea"),
            "singular_name" => __("Preorder", "sdevs_wea"),
            'name_admin_bar'        => __('Preorder\'s', 'sdevs_wea'),
            'archives'              => __('Item Archives', 'sdevs_wea'),
            'attributes'            => __('Item Attributes', 'sdevs_wea'),
            'parent_item_colon'     => __('Parent :', 'sdevs_wea'),
            'all_items'             => __('Bookings', 'sdevs_wea'),
            'add_new_item'          => __('Add New Preorder', 'sdevs_wea'),
            'add_new'               => __('Add Preorder', 'sdevs_wea'),
            'new_item'              => __('New Preorder', 'sdevs_wea'),
            'edit_item'             => __('Edit Preorder', 'sdevs_wea'),
            'update_item'           => __('Update Preorder', 'sdevs_wea'),
            'view_item'             => __('View Preorder', 'sdevs_wea'),
            'view_items'            => __('View Preorder', 'sdevs_wea'),
            'search_items'          => __('Search Preorder', 'sdevs_wea'),
        );

        $args = array(
            "label" => __("Preorders", "sdevs_wea"),
            "labels" => $labels,
            "description" => "",
            "public" => false,
            "publicly_queryable" => true,
            "show_ui" => true,
            "delete_with_user" => false,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive" => false,
            "show_in_menu" => false,
            "show_in_nav_menus" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            'capabilities' => array(
                'create_posts' => false
            ),
            "hierarchical" => false,
            "rewrite" => array("slug" => "sdevs_preorder", "with_front" => true),
            "query_var" => true,
            "supports" => array("title"),
        );

        register_post_type("sdevs_preorder", $args);
    }

    public function create_admin_menu()
    {
        $parent_slug = "edit.php?post_type=sdevs_preorder";
        add_menu_page("Preorders", "Preorders", "manage_options", $parent_slug, false, "dashicons-calendar", 55);
    }
}
