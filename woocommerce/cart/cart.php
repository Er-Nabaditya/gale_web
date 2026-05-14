<form
    class="woocommerce-cart-form custom-cart-form"
    action="<?php echo esc_url( wc_get_cart_url() ); ?>"
    method="post"
>

    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

    <div class="custom-cart-page">

        <div class="container">

            <!-- TOP -->
            <div class="cart-page-top">

                <a
                    href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                    class="continue-shopping"
                >
                    ← Continue Shopping
                </a>

                <h1 class="cart-page-title">
                    Shopping Cart
                </h1>

                <p class="cart-count">
                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                    items in your cart
                </p>

            </div>

            <!-- LAYOUT -->
            <div class="cart-layout">

                <!-- LEFT -->
                <div class="cart-left">

                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>

                        <?php
                        $_product = apply_filters(
                            'woocommerce_cart_item_product',
                            $cart_item['data'],
                            $cart_item,
                            $cart_item_key
                        );

                        $product_id = apply_filters(
                            'woocommerce_cart_item_product_id',
                            $cart_item['product_id'],
                            $cart_item,
                            $cart_item_key
                        );

                        if (
                            $_product &&
                            $_product->exists() &&
                            $cart_item['quantity'] > 0 &&
                            apply_filters(
                                'woocommerce_cart_item_visible',
                                true,
                                $cart_item,
                                $cart_item_key
                            )
                        ) :

                            $product_permalink = apply_filters(
                                'woocommerce_cart_item_permalink',
                                $_product->is_visible()
                                    ? $_product->get_permalink( $cart_item )
                                    : '',
                                $cart_item,
                                $cart_item_key
                            );

                            $thumbnail = apply_filters(
                                'woocommerce_cart_item_thumbnail',
                                $_product->get_image(),
                                $cart_item,
                                $cart_item_key
                            );

                            $name = apply_filters(
                                'woocommerce_cart_item_name',
                                $_product->get_name(),
                                $cart_item,
                                $cart_item_key
                            );

                            $price = WC()->cart->get_product_price( $_product );

                            $subtotal = WC()->cart->get_product_subtotal(
                                $_product,
                                $cart_item['quantity']
                            );
                        ?>

                            <!-- CART CARD -->
                            <div class="cart-card">

                                <!-- IMAGE -->
                                <div class="cart-card-image">

                                    <?php if ( $product_permalink ) : ?>

                                        <a href="<?php echo esc_url( $product_permalink ); ?>">

                                            <?php echo $thumbnail; ?>

                                        </a>

                                    <?php else : ?>

                                        <?php echo $thumbnail; ?>

                                    <?php endif; ?>

                                </div>

                                <!-- CONTENT -->
                                <div class="cart-card-content">

                                    <h3 class="cart-product-title">

                                        <a href="<?php echo esc_url( $product_permalink ); ?>">

                                            <?php echo esc_html( $name ); ?>

                                        </a>

                                    </h3>

                                    <!-- PRICE -->
                                    <div class="cart-price">

                                        <?php echo $price; ?>

                                        <sub>/ 500g</sub>

                                    </div>

                                    <!-- QUANTITY -->
                                    <div class="cart-qty-wrap">

                                        <?php
                                        echo woocommerce_quantity_input(
                                            array(
                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                'input_value'  => $cart_item['quantity'],
                                                'max_value'    => $_product->get_max_purchase_quantity(),
                                                'min_value'    => 0,
                                                'product_name' => $name,
                                            ),
                                            $_product,
                                            false
                                        );
                                        ?>

                                    </div>

                                    <!-- REMOVE -->
                                    <div class="cart-remove">

                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove-product">Remove</a>',
                                                esc_url(
                                                    wc_get_cart_remove_url(
                                                        $cart_item_key
                                                    )
                                                )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>

                                    </div>

                                </div>

                                <!-- SUBTOTAL -->
                                <div class="cart-subtotal">

                                    <span class="subtotal-label">
                                        Subtotal
                                    </span>

                                    <div class="subtotal-price">

                                        <?php echo $subtotal; ?>

                                    </div>

                                </div>

                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                    <!-- UPDATE CART -->
                    <div class="cart-update-btn-wrap">

                        <button
                            type="submit"
                            class="update-cart-btn"
                            name="update_cart"
                            value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"
                        >
                            Update Cart
                        </button>

                    </div>

                </div>

                <!-- RIGHT -->
                <!-- RIGHT -->
<div class="cart-right">

    <div class="cart-summary">

        <h2 class="summary-title">
            Order Summary
        </h2>

        <div class="summary-box">

            <!-- SUBTOTAL -->
            <div class="summary-row">

                <span>
                    Subtotal
                </span>

                <span>
                    <?php wc_cart_totals_subtotal_html(); ?>
                </span>

            </div>

            <!-- SHIPPING -->
            <div class="summary-row">

                <span>
                    Shipping
                </span>

                <span>
                    <?php wc_cart_totals_shipping_html(); ?>
                </span>

            </div>

            <!-- TAX -->
            <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>

                <div class="summary-row">

                    <span>
                        <?php echo esc_html( $tax->label ); ?>
                    </span>

                    <span>
                        <?php echo wp_kses_post( $tax->formatted_amount ); ?>
                    </span>

                </div>

            <?php endforeach; ?>

            <!-- TOTAL -->
            <div class="summary-total">

                <span>
                    Total
                </span>

                <span>
                    <?php wc_cart_totals_order_total_html(); ?>
                </span>

            </div>

            <!-- CHECKOUT BUTTON -->
            <a
                href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
                class="checkout-btn"
            >
                Proceed to Checkout
            </a>

            <!-- NOTE -->
            <div class="summary-note">

                Every purchase supports tribal communities
                in Palghar

            </div>

        </div>

    </div>

</div>

            </div>

        </div>

    </div>

</form>