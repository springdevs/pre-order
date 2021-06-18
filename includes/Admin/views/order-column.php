<a href="<?php echo esc_html(get_edit_post_link($preorder_item['product_id'])); ?>" target="_blank">
    <?php echo esc_html('(#' . $preorder_item['product_id'] . ') ' . $preorder_item->get_name()); ?>
</a>
- <span><?php echo esc_html($rels_date); ?></span>
<br />