<div id="sdevs_preorder_meta" class="panel sdevs_panel sdevs-form woocommerce_options_panel">
    <strong><?php _e('Pre-Order Settings', 'sdevs_wea'); ?></strong>
    <?php
    wp_nonce_field('_preorder_product_form_nonce', '_preorder_free_nonce', false);
    woocommerce_wp_checkbox([
        "id"          => "enable_preorder",
        "label"       => __("Enable PreOrder", "sdevs_wea"),
        "value"       => $enable,
        "cbvalue"     => "yes",
        "description" => __("check this box to enable PreOrder for this product", "sdevs_wea"),
        "desc_tip"    => true,
    ]);
    woocommerce_wp_text_input([
        "id"    => "rels_date",
        "label" => __('Release Date', 'sdevs_wea'),
        "type"  => "date",
        "value" => $rels_date,
    ]);
    woocommerce_wp_text_input([
        "id"    => "add_to_cart_label",
        "label" => __('Add to Cart Label', 'sdevs_wea'),
        "type"  => "text",
        "value" => $add_to_cart_label,
    ]);
    woocommerce_wp_text_input([
        "id"    => "no_date_label",
        "label" => __('No Date Label', 'sdevs_wea'),
        "type"  => "text",
        "value" => $no_date_label,
    ]);
    woocommerce_wp_text_input([
        "id"    => "rels_date_label",
        "label" => __('Release Date Label', 'sdevs_wea'),
        "type"  => "text",
        "value" => $rels_date_label,
    ]);
    ?>
</div>