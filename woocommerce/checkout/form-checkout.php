<?php
/**
 * Checkout Form Template
 * File: your-child-theme/woocommerce/checkout/form-checkout.php
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );
?>

<main class="checkout-page">
    <div class="container">

        <!-- BACK TO CART -->
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="back-to-cart">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back to Cart
        </a>

        <!-- TITLE -->
        <h1 class="checkout-title">Checkout</h1>

        <!-- SECURE BADGE -->
        <div class="secure-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Secure checkout powered by encryption
        </div>

        <!-- CHECKOUT FORM — WooCommerce requires this form to process orders -->
        <form name="checkout"
              method="post"
              class="woocommerce-checkout checkout"
              action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
              enctype="multipart/form-data">

            <div class="checkout-layout">

                <!-- ── LEFT ── -->
                <div class="checkout-left">

                    <!-- SHIPPING INFORMATION -->
                    <div class="checkout-card">
                        <h2 class="card-title">Shipping Information</h2>

                        <!-- FIRST NAME + LAST NAME -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="billing_first_name">First Name</label>
                                <input
                                    type="text"
                                    id="billing_first_name"
                                    name="billing_first_name"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_first_name' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                            <div class="form-group">
                                <label for="billing_last_name">Last Name</label>
                                <input
                                    type="text"
                                    id="billing_last_name"
                                    name="billing_last_name"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_last_name' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="form-row full">
                            <div class="form-group">
                                <label for="billing_email">Email</label>
                                <input
                                    type="email"
                                    id="billing_email"
                                    name="billing_email"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_email' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                        </div>

                        <!-- PHONE -->
                        <div class="form-row full">
                            <div class="form-group">
                                <label for="billing_phone">Phone Number</label>
                                <input
                                    type="tel"
                                    id="billing_phone"
                                    name="billing_phone"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_phone' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                        </div>

                        <!-- ADDRESS -->
                        <div class="form-row full">
                            <div class="form-group">
                                <label for="billing_address_1">Address</label>
                                <input
                                    type="text"
                                    id="billing_address_1"
                                    name="billing_address_1"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_address_1' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                        </div>

                        <!-- CITY + STATE -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="billing_city">City</label>
                                <input
                                    type="text"
                                    id="billing_city"
                                    name="billing_city"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_city' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                            <div class="form-group">
                                <label for="billing_state">State</label>
                                <input
                                    type="text"
                                    id="billing_state"
                                    name="billing_state"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_state' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                        </div>

                        <!-- PINCODE + COUNTRY -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="billing_postcode">Pincode</label>
                                <input
                                    type="text"
                                    id="billing_postcode"
                                    name="billing_postcode"
                                    class="input-text"
                                    value="<?php echo esc_attr( $checkout->get_value( 'billing_postcode' ) ); ?>"
                                    placeholder=""
                                >
                            </div>
                            <div class="form-group">
                                <label for="billing_country">Country</label>
                                <select id="billing_country" name="billing_country" class="country_select">
                                    <?php
                                    $countries        = WC()->countries->get_allowed_countries();
                                    $selected_country = $checkout->get_value( 'billing_country' ) ?: 'IN';
                                    foreach ( $countries as $code => $name ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $code ); ?>" <?php selected( $selected_country, $code ); ?>>
                                            <?php echo esc_html( $name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Hidden required WooCommerce fields -->
                        <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                        <input type="hidden" name="woocommerce_checkout_update_totals" value="">

                    </div><!-- /.checkout-card (shipping) -->

                    <!-- PAYMENT METHOD -->
                    <div class="checkout-card">
                        <h2 class="card-title">Payment Method</h2>

                        <div class="payment-options">

                            <div class="payment-option active" onclick="selectPayment(this, 'card')">
                                <div class="radio-dot"></div>
                                <div class="payment-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                        <line x1="1" y1="10" x2="23" y2="10"/>
                                    </svg>
                                </div>
                                <span class="payment-label">Credit/Debit Card</span>
                            </div>

                            <div class="payment-option" onclick="selectPayment(this, 'upi')">
                                <div class="radio-dot"></div>
                                <div class="payment-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                        <path d="M2 17l10 5 10-5"/>
                                        <path d="M2 12l10 5 10-5"/>
                                    </svg>
                                </div>
                                <span class="payment-label">UPI</span>
                            </div>

                            <div class="payment-option" onclick="selectPayment(this, 'netbanking')">
                                <div class="radio-dot"></div>
                                <div class="payment-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <line x1="12" y1="1" x2="12" y2="23"/>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                    </svg>
                                </div>
                                <span class="payment-label">Net Banking</span>
                            </div>

                        </div><!-- /.payment-options -->

                        <!-- CARD DETAILS -->
                        <div class="card-details" id="card-details">
                            <div class="form-row full">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="text" placeholder="MM/YY" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="text" placeholder="123" maxlength="3">
                                </div>
                            </div>
                            <div class="form-row full">
                                <div class="form-group">
                                    <label>Cardholder Name</label>
                                    <input type="text" placeholder="">
                                </div>
                            </div>
                        </div>

                        <!-- UPI DETAILS -->
                        <div class="card-details" id="upi-details" style="display:none;">
                            <div class="form-row full">
                                <div class="form-group">
                                    <label>UPI ID</label>
                                    <input type="text" placeholder="yourname@upi">
                                </div>
                            </div>
                        </div>

                        <!-- NET BANKING DETAILS -->
                        <div class="card-details" id="netbanking-details" style="display:none;">
                            <div class="form-row full">
                                <div class="form-group">
                                    <label>Select Bank</label>
                                    <select>
                                        <option>State Bank of India</option>
                                        <option>HDFC Bank</option>
                                        <option>ICICI Bank</option>
                                        <option>Axis Bank</option>
                                        <option>Kotak Mahindra Bank</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- PAY BUTTON -->
                        <button type="submit" class="pay-btn" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Pay <?php echo WC()->cart->get_total(); ?>
                        </button>

                    </div><!-- /.checkout-card (payment) -->

                </div><!-- /.checkout-left -->

                <!-- ── RIGHT — ORDER SUMMARY ── -->
                <div class="checkout-right">
                    <div class="order-summary">

                        <h2 class="summary-title">Order Summary</h2>

                        <!-- CART ITEMS LOOP -->
                        <div class="order-items">
                            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :

                                $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                                if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] === 0 ) {
                                    continue;
                                }

                                $name      = $_product->get_name();
                                $thumbnail = $_product->get_image( 'thumbnail' );
                                $price     = WC()->cart->get_product_price( $_product );
                                $subtotal  = WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] );
                                $qty       = $cart_item['quantity'];
                            ?>

                                <div class="order-item">
                                    <div class="item-img">
                                        <?php echo $thumbnail; ?>
                                        <span class="item-badge"><?php echo esc_html( $qty ); ?></span>
                                    </div>
                                    <div class="item-info">
                                        <div class="item-name"><?php echo esc_html( $name ); ?></div>
                                        <div class="item-meta"><?php echo $price; ?> × <?php echo esc_html( $qty ); ?></div>
                                    </div>
                                    <div class="item-price"><?php echo $subtotal; ?></div>
                                </div>

                            <?php endforeach; ?>
                        </div><!-- /.order-items -->

                        <div class="summary-divider"></div>

                        <!-- TOTALS -->
                        <div class="summary-rows">

                            <div class="summary-row">
                                <span class="row-label">Subtotal</span>
                                <span class="row-value"><?php wc_cart_totals_subtotal_html(); ?></span>
                            </div>

                            <div class="summary-row">
                                <span class="row-label">Shipping</span>
                                <span class="row-value <?php echo ( WC()->cart->get_shipping_total() == 0 ) ? 'free' : ''; ?>">
                                    <?php
                                    if ( WC()->cart->get_shipping_total() == 0 ) {
                                        echo 'Free';
                                    } else {
                                        echo wc_price( WC()->cart->get_shipping_total() );
                                    }
                                    ?>
                                </span>
                            </div>

                            <?php if ( wc_tax_enabled() ) :
                                $taxes_total = array_sum( WC()->cart->get_taxes() );
                                if ( $taxes_total > 0 ) : ?>
                                    <div class="summary-row">
                                        <span class="row-label">Tax (18% GST)</span>
                                        <span class="row-value"><?php echo wc_price( $taxes_total ); ?></span>
                                    </div>
                            <?php endif; endif; ?>

                        </div><!-- /.summary-rows -->

                        <!-- TOTAL -->
                        <div class="summary-total">
                            <span>Total</span>
                            <span class="total-amount"><?php wc_cart_totals_order_total_html(); ?></span>
                        </div>

                        <!-- SECURE NOTE -->
                        <div class="secure-note">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                            <div class="secure-note-text">
                                <strong>Secure Payment</strong>
                                Your payment information is encrypted and secure
                            </div>
                        </div>

                    </div><!-- /.order-summary -->
                </div><!-- /.checkout-right -->

            </div><!-- /.checkout-layout -->

        </form>

    </div><!-- /.container -->
</main><!-- /.checkout-page -->

<script>
    function selectPayment(el, type) {
        document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('active'));
        el.classList.add('active');

        document.getElementById('card-details').style.display       = 'none';
        document.getElementById('upi-details').style.display        = 'none';
        document.getElementById('netbanking-details').style.display = 'none';

        if (type === 'card')       document.getElementById('card-details').style.display       = 'flex';
        if (type === 'upi')        document.getElementById('upi-details').style.display        = 'flex';
        if (type === 'netbanking') document.getElementById('netbanking-details').style.display = 'flex';
    }

    // Card number formatting
    document.querySelector('input[placeholder="1234 5678 9012 3456"]').addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '').substring(0, 16);
        e.target.value = v.replace(/(.{4})/g, '$1 ').trim();
    });

    // Expiry formatting
    document.querySelector('input[placeholder="MM/YY"]').addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '').substring(0, 4);
        if (v.length >= 2) v = v.substring(0,2) + '/' + v.substring(2);
        e.target.value = v;
    });
</script>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>