<?php

namespace SpringDevs\PreOrder\Frontend;

/**
 * Class Order
 *
 * @package SpringDevs\PreOrder\Frontend
 */
class Order {


	public function __construct() {
		add_action( 'woocommerce_order_item_meta_start', array( $this, 'add_meta_data' ), 10, 3 );
		add_action( 'woocommerce_my_account_my_orders_column_order-status', array( $this, 'add_preorder_marker' ) );
	}

	public function add_meta_data( $item_id, $item, $order ) {
		$has_preorder = $item->get_meta( '_has_preorder', true );
		if ( $has_preorder ) {
			echo '<br /><small class="sdevs_preorder_marker_label">' . __( get_option( 'preorder_order_item_marker_txt', 'Pre-Order Product' ), 'sdevs_preorder' ) . '</small>';
			$rels_date = $item->get_meta( '_relase_date', true );
			if ( $rels_date ) {
				echo '<br /><small class="sdevs_preorder_order_label">' . __( 'Release date: ', 'sdevs_preorder' ) . date( 'F d, Y', strtotime( $rels_date ) ) . '</small>';
			} else {
				echo '<br /><small>' . __( 'Release date: N/A', 'sdevs_preorder' ) . '</small>';
			}
		}
	}

	public function add_preorder_marker( $order ) {
		$post_ids = get_post_meta( $order->get_id(), '_preorders', true );
		if ( $post_ids && is_array( $post_ids ) && count( $post_ids ) > 0 ) {
			echo wc_get_order_status_name( $order->get_status() );
			echo '<br><mark>' . esc_html( esc_html__( 'Has Pre-Orders', 'sdevs_preorder' ) ) . '</mark>';
		} else {
			echo wc_get_order_status_name( $order->get_status() );
		}
	}
}
