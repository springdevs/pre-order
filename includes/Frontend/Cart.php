<?php

namespace SpringDevs\PreOrder\Frontend;

use SpringDevs\PreOrder\Illuminate\Helper;

/**
 * Class Cart
 *
 * @package SpringDevs\PreOrder\Frontend
 */
class Cart {


	public function __construct() {
		add_filter( 'woocommerce_cart_item_name', array( $this, 'change_cart_item_name' ), 10, 3 );
	}

	public function change_cart_item_name( $item_name, $cart_item, $cart_item_key ) {
		$product      = wc_get_product( $cart_item['product_id'] );
		$has_preorder = Helper::has_preorder( $product->get_id() );
		if ( $has_preorder ) {
			$item_name  .= '<br /><small class="sdevs_preorder_cart_marker">' . __( get_option( 'preorder_order_item_marker_txt', 'Pre-Order product' ), 'sdevs_preorder' ) . '</small>';
			$product_cls = new Product();
			$summery_txt = $product_cls->display_txt( $product, false );
			$item_name  .= '<br /><small class="sdevs_preorder_cart_label">' . __( $summery_txt, 'sdevs_preorder' ) . '</small>';
		}
		return $item_name;
	}
}
