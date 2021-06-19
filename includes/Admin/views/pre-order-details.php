<style>
    #titlewrap>input {
        pointer-events: none;
    }
</style>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php esc_html_e('Product :', 'sdevs_preorder'); ?> </th>
            <td>
                <a href="<?php echo esc_html(get_the_permalink($product_id)); ?>" target="_blank">
                    <?php esc_html_e($order_item->get_name()); ?>
                </a>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Qty :', 'sdevs_preorder'); ?> </th>
            <td>
                x<?php echo esc_html($order_item->get_quantity()); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Price :', 'sdevs_preorder'); ?> </th>
            <td>
                <?php echo wc_price($order_item->get_total()); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Order ID :', 'sdevs_preorder'); ?> </th>
            <td>
                <a href="<?php echo get_edit_post_link($order_id); ?>"><?php echo $order_id; ?></a>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Order Status :', 'sdevs_preorder'); ?> </th>
            <td>
                <?php esc_html_e($order->get_status(), 'sdevs_preorder'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Order Date :', 'sdevs_preorder'); ?> </th>
            <td>
                <?php esc_html_e(date('F d, Y', strtotime($order->get_date_created())), 'sdevs_preorder'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Release Date :', 'sdevs_preorder'); ?> </th>
            <td>
                <?php esc_html_e($rels_date, 'sdevs_preorder'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php esc_html_e('Payment Method :', 'sdevs_preorder'); ?> </th>
            <td>
                <?php esc_html_e($order->get_payment_method_title(), 'sdevs_preorder'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e('Billing :', 'sdevs_preorder'); ?></th>
            <td><?php echo $order->get_formatted_billing_address(); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e('Shipping :', 'sdevs_preorder') ?></th>
            <td><?php echo $order->get_formatted_shipping_address() ? $order->get_formatted_shipping_address() : esc_html("No shipping address set.", 'sdevs_preorder'); ?></td>
        </tr>
    </tbody>
</table>