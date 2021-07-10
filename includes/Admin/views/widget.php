<li class="processing-orders">
    <a href="javascript:void();">
        <strong>
            <?php echo $confirmed_items == 1 ? esc_html($confirmed_items . " product") : esc_html($confirmed_items . " products"); ?>
        </strong> <?php echo esc_html("pre-order confirmed"); ?> </a>
</li>
<li class="pending-orders">
    <a href="javascript:void();">
        <strong>
            <?php echo $pending_items == 1 ? esc_html($pending_items . " product") : esc_html($pending_items . " products"); ?>
        </strong> <?php echo esc_html("pre-order for confirmation"); ?></a>
</li>