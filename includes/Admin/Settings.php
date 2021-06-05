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
        add_filter('woocommerce_get_sections_wcma', [$this, 'add_section'], 50);
        add_filter('woocommerce_get_settings_wcma', [$this, 'settings_content']);
    }

    public function add_section($sections)
    {
        $sections['pre_order'] = __('Pre-Order', 'sdevs_wea');
        return $sections;
    }

    public function settings_content($settings)
    {
        global $current_section;
        if ($current_section == 'pre_order') :
            $invoice_settings = array(
                array(
                    'name' => __('Pre-Order Settings', 'sdevs_wea'),
                    'type' => 'title',
                    'desc' => __('The following options are used to configure Pre-Order Module', 'sdevs_wea'),
                    'id'   => 'pre_order',
                ),
                // array(
                //     'name' => __('Remove Pre-Order status', 'sdevs_wea'),
                //     'id'   => 'preorder_remove_status_relsdate_pass',
                //     'type' => 'checkbox',
                //     'desc' => __('Remove Pre-Order status when the release date passes', 'sdevs_wea'),
                // ),
                array(
                    'name' => __('Default Add to Cart text', 'sdevs_wea'),
                    'id'   => 'preorder_default_add_to_cart_txt',
                    'type' => 'text',
                    'default' => 'Pre-order Now',
                    'desc' => __("This text will be replaced on 'Add to Cart' button. By leaving it blank.", 'sdevs_wea'),
                ),
                array(
                    'title'    => __('No Date Label Color', 'sdevs_wea'),
                    'desc'     => sprintf(__('Text color for No Date Label. Default %s.', 'sdevs_wea'), '<code>#47aeea</code>'),
                    'id'       => 'preorder_no_date_label_color',
                    'type'     => 'color',
                    'css'      => 'width:6em;',
                    'default'  => '#47aeea',
                    'desc_tip' => true,
                ),
                array(
                    'title'    => __('Release Date Label Color', 'sdevs_wea'),
                    'desc'     => sprintf(__('Text color for Release Date Label Color. Default %s.', 'sdevs_wea'), '<code>#000000</code>'),
                    'id'       => 'preorder_rels_date_label_color',
                    'type'     => 'color',
                    'css'      => 'width:6em;',
                    'default'  => '#000000',
                    'desc_tip' => true,
                ),
                array(
                    'name' => __('Order item marker Text', 'sdevs_wea'),
                    'id'   => 'preorder_order_item_marker_txt',
                    'type' => 'text',
                    'default' => 'Pre-Order product'
                ),
                array(
                    'type' => 'sectionend',
                    'id'   => 'pre_order',
                ),
            );
            return $invoice_settings;
        endif;
        return $settings;
    }
}
