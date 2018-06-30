<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! defined( 'WC_PLUGIN_FILE' ) ) {
    return; // Exit if no Woocommerce
}

add_filter( 'woocommerce_product_class',  function ( $classname, $product_type, $post_type, $product_id ) {

    if ( get_post_type($product_id) == 'film' ) {
        $classname = 'WC_Film';
    }

    return $classname;
}, 10, 4 );

add_filter( 'woocommerce_data_stores', function ( $stores ) {
    
        $stores['product-film'] = 'WC_Film_CPT';

    return $stores;
});

/**
 * Simple Product Class.
 *
 * The default product type kinda product.
 *
 * @class 		WC_Product_Simple
 * @package		WooCommerce/Classes/Products
 * @category	Class
 * @author 		WooThemes
 */
class WC_Film extends WC_Product_Simple {

    /**
     * Initialize simple product.
     *
     * @param mixed $product
     */
    public function __construct( $product = 0 ) {
        $this->supports[]   = 'ajax_add_to_cart';
        parent::__construct( $product );
    }

    /**
     * Get internal type.
     * @return string
     */
    public function get_type() {
        return 'film';
    }

    /**
     * Get the add to url used mainly in loops.
     *
     * @return string
     */
    public function add_to_cart_url() {
        $url = $this->is_purchasable() && $this->is_in_stock() ? remove_query_arg( 'added-to-cart', add_query_arg( 'add-to-cart', $this->id ) ) : get_permalink( $this->id );

        return apply_filters( 'woocommerce_product_add_to_cart_url', $url, $this );
    }

    /**
     * Get the add to cart button text.
     *
     * @return string
     */
    public function add_to_cart_text() {
        $text = $this->is_purchasable() && $this->is_in_stock() ? __( 'Add to cart', 'woocommerce' ) : __( 'Read more', 'woocommerce' );

        return apply_filters( 'woocommerce_product_add_to_cart_text', $text, $this );
    }
}


class WC_Film_CPT extends WC_Product_Data_Store_CPT {
    /**
     * Method to read a product from the database.
     * @param WC_Product $product
     * @throws Exception
     */
    public function read( &$product ) {
        $product->set_defaults();

        if ( ! $product->get_id() || ! $post_object = get_post( $product->get_id() ) ) {
            throw new Exception( __( 'Invalid product.', 'woocommerce' ) );
        }

        $id = $product->get_id();

        $product->set_props( array(
            'name'              => $post_object->post_title,
            'slug'              => $post_object->post_name,
            'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
            'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
            'status'            => $post_object->post_status,
            'description'       => $post_object->post_content,
            'short_description' => $post_object->post_excerpt,
            'parent_id'         => $post_object->post_parent,
            'menu_order'        => $post_object->menu_order,
            'reviews_allowed'   => 'open' === $post_object->comment_status,
        ) );

        $this->read_attributes( $product );
        $this->read_downloads( $product );
        $this->read_visibility( $product );
        $this->read_product_data( $product );
        $this->read_extra_data( $product );
        $product->set_object_read( true );
    }
    
}