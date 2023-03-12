<?php

namespace SpringDevs\PreOrder\Frontend;

use SpringDevs\PreOrder\Illuminate\Helper;

/**
 * Class Product
 *
 * @package SpringDevs\PreOrder\Frontend
 */
class Product {


	public function __construct() {
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'change_add_to_cart_text' ) );
		add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'change_add_to_cart_text' ) );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'filter_add_to_cart_validation' ), 20, 4 );

		$position = get_option( 'preorder_label_position', 'default' );
		if ( 'default' === $position ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'put_product_txt' ), 20 );
		} elseif ( 'after_product_image' === $position ) {
			add_action( 'woocommerce_product_thumbnails', array( $this, 'put_product_txt' ) );
		} elseif ( 'after_product_title' === $position ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'put_product_txt' ), 7 );
		} elseif ( 'before_product_title' === $position ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'put_product_txt' ), 1 );
		} elseif ( 'after_add_to_cart_button' === $position ) {
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'put_product_txt' ) );
		} elseif ( 'inside_description' === $position ) {
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'put_product_txt' ) );
		}
	}

	public function change_add_to_cart_text( $text ) {
		global $product;
		if ( ! $product ) {
			return $text;
		}
		$has_preorder = $product->get_meta( '_has_preorder', true );
		if ( $has_preorder ) {
			$labels    = $product->get_meta( '_product_preorder_labels', true );
			$cart_text = $labels['add_to_cart_label'];
			if ( $cart_text || $cart_text != '' ) {
				return $cart_text;
			}
			return get_option( 'preorder_default_add_to_cart_txt', 'Pre-order Now' );
		}
		return $text;
	}

	public function put_product_txt() {
		global $product;
		$has_preorder = Helper::has_preorder( $product->get_id() );
		if ( $has_preorder ) {
			$this->display_txt( $product );
		}
	}

	public function filter_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = 0 ) {
		$has_preorder = Helper::has_preorder( $product_id );
		if ( $has_preorder ) {
			$cartProducts = WC()->cart->get_cart();
			foreach ( $cartProducts as $key => $values ) {
				$cart_product      = $values['data'];
				$has_cart_preorder = Helper::has_preorder( $cart_product->get_id() );
				if ( ! $has_cart_preorder ) {
					wc_add_notice( __( 'Currently You have Non-Preorder product on cart !!', 'sdevs_preorder' ), 'error' );
					return false;
				}
			}
		} else {
			$cartProducts = WC()->cart->get_cart();
			foreach ( $cartProducts as $key => $values ) {
				$cart_product      = $values['data'];
				$has_cart_preorder = Helper::has_preorder( $cart_product->get_id() );
				if ( $has_cart_preorder ) {
					wc_add_notice( __( 'Currently You have Preorder product on cart !!', 'sdevs_preorder' ), 'error' );
					return false;
				}
			}
		}
		return $passed;
	}

	public function display_txt( $product, $echo = true ) {
		$labels       = $product->get_meta( '_product_preorder_labels', true );
		$rels_date    = $product->get_meta( '_preorder_product_release_date', true );
		$summery_text = null;
		$attr         = null;
		if ( $rels_date ) {
			$rels_txt = $labels['rels_date_label'];
			$rels_txt = nl2br( $rels_txt );
			preg_match_all( '/\[([^\]]*)\]/', $rels_txt, $matches );
			$matches = $matches[1];
			foreach ( $matches as $meta_key ) {
				if ( '_release_date' === $meta_key ) {
					$replaced_txt = date( 'F d, Y', strtotime( $rels_date ) );
					$rels_txt     = str_replace( '[' . $meta_key . ']', $replaced_txt, $rels_txt );
				}
			}
			$summery_text = $rels_txt;
			$attr         = 'style="color: ' . get_option( 'preorder_rels_date_label_color', '#000000' ) . '"';
		} else {
			$summery_text = $labels['no_date_label'];
			$attr         = 'style="color: ' . get_option( 'preorder_no_date_label_color', '#47aeea' ) . '"';
		}
		if ( $echo ) :
			?>
			<p class="sdevs_preorder_single_notice">
				<strong <?php echo $attr; ?>><?php _e( $summery_text, 'sdevs_preorder' ); ?></strong>
			</p>
			<?php
		else :
			return $summery_text;
		endif;
	}
}
