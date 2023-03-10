<?php

/**
 * Pre-Order lists template
 *
 * This template can be overridden by copying it to yourtheme/preorder/myaccount/preorders.php
 */

$page = isset($_GET['pg']) ? sanitize_text_field($_GET['pg']) : 1;

$args = [
    'author' => get_current_user_id(),
    'posts_per_page' => 10,
    'paged' => $page,
    'post_type' => 'sdevs_preorder',
    'post_status' => ["publish"]
];

$postslist = new WP_Query($args);


$total_pages = ceil($postslist->found_posts / 10);
?>

<table class="shop_table my_account_preorder">
    <thead>
        <tr>
            <th scope="col"><?php esc_html_e('Product', 'sdevs_preorder'); ?></th>
            <th scope="col"><?php esc_html_e('Order', 'sdevs_preorder'); ?></th>
            <th scope="col"><?php esc_html_e('Price', 'sdevs_preorder'); ?></th>
            <th scope="col"><?php esc_html_e('Release date', 'sdevs_preorder'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($postslist->have_posts()) :
            while ($postslist->have_posts()) : $postslist->the_post();
                $order_id = get_post_meta(get_the_ID(), '_order_id', true);
                $product_id = get_post_meta(get_the_ID(), '_product_id', true);
                $order = wc_get_order($order_id);
                $price = null;
                $rels_date = 'N/A';
                foreach ($order->get_items() as $order_item) {
                    if ($order_item['product_id'] == $product_id) {
                        $price = wc_price(
                            $order_item->get_subtotal(), [
                            'currency' => $order->get_currency()
                            ]
                        );
                        $item_rels_date = $order_item->get_meta('_relase_date', true);
                        if ($item_rels_date) {
                            $rels_date = date('F d, Y', strtotime($item_rels_date));
                        }
                    }
                }
                ?>
                <tr>
                    <td>
                        <a href="<?php the_permalink($product_id); ?>" target="_blank"><?php the_title(); ?></a>
                    </td>
                    <td>
                        <a href="<?php echo esc_html("../view-order/" . $order_id); ?>" target="_blank"><?php echo esc_html('#' . $order_id); ?></a>
                    </td>
                    <td>
                        <?php echo $price; ?>
                    </td>
                    <td>
                        <?php echo esc_html($rels_date); ?>
                    </td>
                </tr>
                <?php
            endwhile;
        endif;
        ?>
    </tbody>
</table>

<p>
    <?php
    // Previous page
    if ($page > 1) {
        echo '<a class="woocommerce-button button" href="' . add_query_arg(array('pg' => $page - 1)) . '">Previous Page</a>';
    }

    // Next page
    if ($page < $total_pages) {
        echo '<a class="woocommerce-button button" style="float: right;" href="' . add_query_arg(array('pg' => $page + 1)) . '">Next Page</a>';
    }
    wp_reset_postdata();
    ?>
</p>