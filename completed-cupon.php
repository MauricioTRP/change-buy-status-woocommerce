<?php
/*
    Plugin Name:    Free Cupon Order Completed
    Description:    This Plugin sets de order state to Completed when a product has a 100% discount
    Version:        1.0
    Author:         Mauro
*/

function change_order_state( $order_id, $old_status, $new_status ) {
    $order = wc_get_order( $order_id );
    $coupons = $order->get_used_coupons();

    foreach ($coupons as $coupon_code) {
        $coupon = new WC_Coupon( $coupon_code );
        $coupon_type = $coupon->get_discount_type();
        $coupon_amount = $coupon->get_amount();

        if ( $coupon_type == 'percent' && $coupon_amount == 100 ) {
            $order->update_status( 'completed' );

            break;
        }
    }
}

add_action( 'woocommerce_order_status_changed', 'change_order_state', 10, 3 );
