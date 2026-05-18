<?php
/**
 * Custom Cart Template
 * File: your-theme/woocommerce/cart/cart.php
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<div class="cart-page">

    <div class="container">

        <!-- TOP -->
        <div class="cart-page-top">

            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="continue-shopping">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Continue Shopping
            </a>

            <h1 class="cart-page-title">Shopping Cart</h1>

            <p class="cart-count">
                <?php echo WC()->cart->get_cart_contents_count(); ?> items in your cart
            </p>

        </div>

        <!-- FORM -->
        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

            <div class="cart-layout">

                <!-- LEFT -->
                <div class="cart-left">

                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>

                        <?php
                        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :

                            $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
                            $thumbnail         = $_product->get_image();
                            $product_name      = $_product->get_name();
                            $price             = WC()->cart->get_product_price( $_product );
                            $subtotal          = WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] );
                        ?>

                            <!-- CARD -->
                            <div class="cart-card">

                                <!-- IMAGE -->
                                <div class="cart-card-image">
                                    <a href="<?php echo esc_url( $product_permalink ); ?>">
                                        <?php echo $thumbnail; ?>
                                    </a>
                                </div>

                                <!-- CONTENT -->
                                <div class="cart-card-content">

                                    <h3 class="cart-product-title">
                                        <a href="<?php echo esc_url( $product_permalink ); ?>">
                                            <?php echo esc_html( $product_name ); ?>
                                        </a>
                                    </h3>

                                    <!-- PRICE -->
                                    <div class="cart-price">
                                        <?php echo $price; ?><sub>/ 500g</sub>
                                    </div>

                                    <!-- QUANTITY + REMOVE (side by side) -->
                                    <div class="cart-qty-remove-row">

                                        <!-- QUANTITY -->
                                        <div class="custom-qty-wrap-cart">

                                            <button type="button" class="qty-btn-cart qty-minus">−</button>

                                            <input
                                                type="hidden"
                                                class="qty-input"
                                                name="cart[<?php echo $cart_item_key; ?>][qty]"
                                                value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
                                                min="1"
                                            >

                                            <span class="qty-number"><?php echo esc_html( $cart_item['quantity'] ); ?></span>

                                            <button type="button" class="qty-btn-cart qty-plus">+</button>

                                        </div>

                                        <!-- REMOVE -->
                                        <div class="cart-remove">
                                            <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove-product">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6l-1 14H6L5 6"></path>
                                                    <path d="M10 11v6"></path>
                                                    <path d="M14 11v6"></path>
                                                    <path d="M9 6V4h6v2"></path>
                                                </svg>
                                                Remove
                                            </a>
                                        </div>

                                    </div><!-- /.cart-qty-remove-row -->

                                </div><!-- /.cart-card-content -->

                                <!-- SUBTOTAL -->
                                <div class="cart-subtotal">
                                    <span class="subtotal-label">Subtotal</span>
                                    <div class="subtotal-price"><?php echo $subtotal; ?></div>
                                </div>

                            </div><!-- /.cart-card -->

                        <?php endif; ?>

                    <?php endforeach; ?>

                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

                </div><!-- /.cart-left -->

                <!-- RIGHT -->
                <div class="cart-right">

                    <div class="cart-summary">

                        <h2 class="summary-title">Order Summary</h2>

                        <div class="summary-box">

                            <!-- SUBTOTAL -->
                            <div class="summary-row">
                                <span class="row-label">Subtotal</span>
                                <span class="row-value"><?php wc_cart_totals_subtotal_html(); ?></span>
                            </div>

                            <!-- SHIPPING -->
                            <div class="summary-row">
                                <span class="row-label">Shipping</span>
                                <span class="row-value <?php echo ( WC()->cart->get_shipping_total() == 0 ) ? 'free' : ''; ?>">
                                    <?php
                                    if ( WC()->cart->get_shipping_total() == 0 ) {
                                        esc_html_e( 'Free', 'woocommerce' );
                                    } else {
                                        wc_cart_totals_shipping_html();
                                    }
                                    ?>
                                </span>
                            </div>

                            <!-- TAX ROWS -->
                            <?php
                            if ( wc_tax_enabled() ) {
                                $cart_taxes = WC()->cart->get_taxes();
                                if ( ! empty( $cart_taxes ) ) {
                                    $taxes_total = array_sum( $cart_taxes );
                                    ?>
                                    <div class="summary-row">
                                        <span class="row-label">Tax (18% GST)</span>
                                        <span class="row-value"><?php echo wc_price( $taxes_total ); ?></span>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                            <!-- TOTAL -->
                            <div class="summary-total">
                                <span>Total</span>
                                <span class="total-amount"><?php wc_cart_totals_order_total_html(); ?></span>
                            </div>

                            <!-- CHECKOUT -->
                            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-btn">
                                Proceed to Checkout
                            </a>

                            <!-- NOTE -->
                            <div class="summary-note">
                                Every purchase supports tribal communities in Palghar
                            </div>

                        </div>

                    </div>

                </div><!-- /.cart-right -->

            </div><!-- /.cart-layout -->

        </form>

    </div><!-- /.container -->

</div><!-- /.cart-page -->

<script>
jQuery(function($){

    /* PLUS */
    $(document).on('click', '.qty-plus', function(){
        let wrap  = $(this).closest('.custom-qty-wrap-cart');
        let input = wrap.find('.qty-input');
        let qty   = parseInt(input.val());
        qty++;
        input.val(qty);
        wrap.find('.qty-number').text(qty);
        updateCart();
    });

    /* MINUS */
    $(document).on('click', '.qty-minus', function(){
        let wrap  = $(this).closest('.custom-qty-wrap-cart');
        let input = wrap.find('.qty-input');
        let qty   = parseInt(input.val());
        if(qty > 1){
            qty--;
            input.val(qty);
            wrap.find('.qty-number').text(qty);
            updateCart();
        }
    });

    /* AJAX UPDATE CART */
    function updateCart(){
        let form     = $('.woocommerce-cart-form');
        let formData = form.serialize();
        formData    += '&update_cart=Update+Cart';

        $.ajax({
            type: 'POST',
            url: wc_cart_params.cart_url,
            data: formData,
            beforeSend: function(){
                $('.cart-page').addClass('loading');
            },
            success: function(){
                $('.cart-page').load(
                    window.location.href + ' .cart-page > *',
                    function(){
                        $('.cart-page').removeClass('loading');
                    }
                );
            }
        });
    }

});
</script>

<?php do_action( 'woocommerce_after_cart' ); ?>