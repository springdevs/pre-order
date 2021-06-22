<div class="wrap">
    <?php settings_errors(); ?>
    <h1><?php _e('Pre-Order Settings', 'sdevs_preorder'); ?></h1>
    <p><?php _e('Customize pre-order options', 'sdevs_preorder'); ?></p>
    <form method="post" action="options.php">
        <?php settings_fields('preorder_settings'); ?>
        <?php do_settings_sections('preorder_settings'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="preorder_default_add_to_cart_txt">
                            <?php esc_html_e('Default Add to Cart text', 'sdevs_preorder'); ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" id="preorder_default_add_to_cart_txt" name="preorder_default_add_to_cart_txt" value="<?php echo esc_html(get_option('preorder_default_add_to_cart_txt', 'Pre-order Now')); ?>" />
                        <p class="description"><?php _e("This text will be replaced on 'Add to Cart' button. By leaving it blank.", 'sdevs_preorder'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="preorder_no_date_label_color">
                            <?php esc_html_e('No Date Label Color', 'sdevs_preorder'); ?>
                        </label>
                    </th>
                    <td>
                        <input id="preorder_no_date_label_color" class="sdevs-color-field" type="text" value="<?php echo get_option('preorder_no_date_label_color', '#47aeea'); ?>" name="preorder_no_date_label_color" data-default-color="#47aeea" />
                        <p class="description"><?php echo sprintf(__('Text color for No Date Label. Default %s.', 'sdevs_preorder'), '<code>#47aeea</code>'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="preorder_rels_date_label_color">
                            <?php esc_html_e('Release Date Label Color', 'sdevs_preorder'); ?>
                        </label>
                    </th>
                    <td>
                        <input id="preorder_rels_date_label_color" class="sdevs-color-field" type="text" value="<?php echo get_option('preorder_rels_date_label_color', '#000000'); ?>" name="preorder_rels_date_label_color" data-default-color="#000000" />
                        <p class="description"><?php echo sprintf(__('Text color for Release Date Label Color. Default %s.', 'sdevs_preorder'), '<code>#000000</code>'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="preorder_order_item_marker_txt">
                            <?php esc_html_e('Order item marker Text', 'sdevs_preorder'); ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" id="preorder_order_item_marker_txt" name="preorder_order_item_marker_txt" value="<?php echo esc_html(get_option('preorder_order_item_marker_txt', 'Pre-Order product')); ?>" />
                    </td>
                </tr>

                <?php do_action("sdevs_preorder_setting_fields"); ?>
            </tbody>
        </table>

        <?php submit_button(); ?>

    </form>
</div>