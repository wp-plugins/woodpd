<?php
/**
 * Template Function Overrides
 *
 */

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

$dpd_products_button = get_option( 'woodpd_products_button', 'read_more' );
if ( $dpd_products_button == "read_more" ) {
	add_action( 'woocommerce_after_shop_loop_item', 'woodpd_read_more', 10 );
} elseif ( $dpd_products_button == "add_to_cart" ) {
	add_action( 'woocommerce_after_shop_loop_item', 'woodpd_add_to_cart', 10 );
} elseif ( $dpd_products_button == "buy_now" ) {
	add_action( 'woocommerce_after_shop_loop_item', 'woodpd_buy_now', 10 );
}

//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );

$dpd_simple_product_button = get_option( 'woodpd_simple_product_button ', 'add_to_cart' );
if ( $dpd_simple_product_button == 'add_to_cart' ) {
	add_action( 'woocommerce_simple_add_to_cart', 'woodpd_add_to_cart', 30 );
} elseif ( $dpd_simple_product_button == 'buy_now' ) {
	add_action( 'woocommerce_simple_add_to_cart', 'woodpd_buy_now', 30 );
}

$dpd_after_product_button = get_option( 'woodpd_after_product_button ', 'none' );
if ( $dpd_after_product_button == 'add_to_cart' ) {
	add_action( 'woocommerce_after_single_product', 'woodpd_add_to_cart' );
} elseif ( $dpd_after_product_button == 'buy_now' ) {
	add_action( 'woocommerce_after_single_product', 'woodpd_buy_now' );
}

function woodpd_read_more() {
	global $product;
	$dpd_read_more_text = get_option( 'woodpd_read_more_text', __('Read More', 'woodpd') );

	echo '<form action="' . esc_url( $product->get_permalink( $product->id ) ) . '" method="get">
		<button type="submit" class="single_add_to_cart_button button alt">' . $dpd_read_more_text . '</button>
		</form>';
}

function woodpd_add_to_cart() {
	global $product;
	$dpd_id = get_post_meta( $product->id, 'dpd_id', true );
	$dpd_price_id = get_post_meta( $product->id, 'dpd_price_id', true );
	$dpd_cart_url = get_option( 'woodpd_cart_url', '' );
	$dpd_add_to_cart_text = get_option( 'woodpd_add_to_cart_text', __('Add To Cart', 'woodpd') );

	if ( $dpd_price_id ) {
		$dpd_price_id_str = '&amp;product_price_id=' . $dpd_price_id;
	}

	echo '<a class="single_add_to_cart_button button alt" href="https://' . $dpd_cart_url  . '.dpdcart.com/cart/add?product_id=' . $dpd_id . $dpd_price_id_str . '" target="_top">' . $dpd_add_to_cart_text . '</a>';
}

function woodpd_buy_now() {
	global $product;
	$dpd_id = get_post_meta( $product->id, 'dpd_id', true );
	$dpd_price_id = get_post_meta( $product->id, 'dpd_price_id', true );
	$dpd_cart_url = get_option( 'woodpd_cart_url', '' );
	$dpd_buy_now_text = get_option( 'woodpd_buy_now_text', __('Buy Now', 'woodpd') );

	if ( $dpd_price_id ) {
		$dpd_price_id_str = '&amp;product_price_id=' . $dpd_price_id;
	}

	echo '<a class="single_add_to_cart_button button alt" href="https://' . $dpd_cart_url  . '.dpdcart.com/cart/buy?product_id=' . $dpd_id . $dpd_price_id_str . '" target="_top">' . $dpd_buy_now_text . '</a>';
}
