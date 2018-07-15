<?php

namespace CN\Film;

// Add to cart and redirect to Checkout
add_action( 'wp_loaded', function () {

    if ( isset($_GET['buy_film']) && function_exists('wc') ) {
        wc()->cart->add_to_cart( absint($_GET['buy_film']), 1 );

        wp_redirect( wc_get_checkout_url() );
        die;
    }

    // Make FILMs as a Shop page
    add_filter( 'woocommerce_get_shop_page_permalink', function($permalink){
        return site_url('/film/');
    }, 11, 1 );
}, 11 );


