<?php

/*
	Plugin Name: Auto Complete Paid Orders for For WooCommerce
	Author: SiteShop.ph
	Author URI: https://siteshop.ph/
 	License URI: https://siteshop.ph/eula
*/ 






/**
 * AUTO COMPLETE PAID ORDERS IN WOOCOMMERCE
 */

// Ref.:   http://stackoverflow.com/questions/35686707/woocommerce-auto-complete-paid-orders-depending-on-payment-methods



add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_paid_order', 10, 1 );
function custom_woocommerce_auto_complete_paid_order( $order_id ) {
  if ( ! $order_id ) {
    return;
  }


  // (need those two for "get_post_meta()" function).
  global $woocommerce;
  $order = new WC_Order( $order_id );



  // No updated status for orders delivered with Bank wire, Cash on delivery and Cheque payment methods.
  if ( ( get_post_meta($order->id, '_payment_method', true) == 'bacs' ) || ( get_post_meta($order->id, '_payment_method', true) == 'cod' ) || ( get_post_meta($order->id, '_payment_method', true) == 'cheque' ) ) {
    return;
  } 



  // "completed" updated status for paid Orders with all others payment methods:
  else if ($order->status == 'processing') {
    $order->update_status( 'completed' );



// Add Admin and Customer note:
sleep(2);   // for better order note listing history for being full-anti-chronological
$order->add_order_note(' -> Order status updated to COMPLETED', 1); 





  }
}
