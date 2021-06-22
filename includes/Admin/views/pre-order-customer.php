<table class="booking-customer-details" style="width: 100%;">
    <tbody>
        <tr>
            <th><?php esc_html_e('Name:', 'sdevs_preorder') ?></th>
            <td><?php echo $order->get_formatted_billing_full_name(); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e('Email:', 'sdevs_preorder'); ?></th>
            <td><a href="mailto:<?php echo esc_html($order->get_billing_email()); ?>"><?php echo esc_html($order->get_billing_email()); ?></a></td>
        </tr>
        <tr>
            <th><?php esc_html_e('Phone:', 'sdevs_preorder'); ?></th>
            <td><?php echo esc_html($order->get_billing_phone()); ?></td>
        </tr>
        <tr class="view">
            <th>&nbsp;</th>
            <td><br><a class="button button-small" target="_blank" href="<?php echo esc_html(get_edit_post_link($order_id)); ?>"><?php esc_html_e('View Order', 'sdevs_preorder'); ?></a></td>
        </tr>
    </tbody>
</table>