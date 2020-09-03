<?php
/* ==================================================
WOOCOMERCE - CUSTOM AUTO CENCELING ORDER WHEN AFTER 1 HOUR
================================================== */
    add_action( 'restrict_manage_posts', 'cancel_unpaid_orders' );
    function cancel_unpaid_orders() {
    global $pagenow, $post_type;
    // Enable the process to be executed daily when browsing Admin order list
    if( 'shop_order' === $post_type && 'edit.php' === $pagenow) {// && get_option( unpaid_orders_daily_process' ) < time()
        )
         { // Get unpaid orders (5 days old) $unpaid_orders=(array) wc_get_orders( array( // 'limit'=> -1,
        'status' => 'on-hold',
        'date_created' => '<' . ( time() - (60 * 60) ),//menit * detik, 60menit=1 jam ) ); if ( sizeof($unpaid_orders)> 0 )
            {

            $cancelled_text = __("The order was cancelled due to no payment from customer.", "woocommerce");
            // Loop through orders
            foreach ( $unpaid_orders as $order ) {
            $order->update_status( 'cancelled', $cancelled_text );
            }
            }
            }
        }