<?php
/**
 * Single Product Template
 * File: your-theme/woocommerce/single-product.php
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook:
 * woocommerce_before_main_content
 */
do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) :

    the_post();

    global $product;

    $post_id = $product->get_id();

    $title       = $product->get_name();
    $price_html  = $product->get_price_html();
    $excerpt     = $product->get_short_description();
    $description = $product->get_description();

    $cultivation       = get_field( 'cultivation', $post_id );
    $health_benefits   = get_field( 'health_benefits', $post_id );
    $nutritional_value = get_field( 'nutritional_value', $post_id );

    $product_features = get_post_meta(
        $post_id,
        '_product_features',
        true
    );

    $thumb_id     = $product->get_image_id();
    $gallery_ids  = $product->get_gallery_image_ids();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-custom' ); ?>>

    <div class="single-product-page-wrap">

        <div class="container">

            <!-- Back -->
            <div class="product-back-link">

                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
                    ← Back to Shop
                </a>

            </div>

            <!-- PRODUCT HERO -->
            <section class="product-hero">

                <!-- LEFT -->
                <div class="product-gallery-wrap">

                    <!-- MAIN IMAGE -->
                    <div class="product-main-image">

                        <img
                            id="main-product-image"
                            src="<?php echo esc_url( wp_get_attachment_image_url( $thumb_id, 'large' ) ); ?>"
                            alt="<?php echo esc_attr( $title ); ?>"
                        >

                    </div>

                    <!-- THUMBNAILS -->
                    <?php if ( ! empty( $gallery_ids ) || $thumb_id ) : ?>

                        <div class="product-gallery-thumbs">

                            <?php
                            $all_images = array_merge(
                                array( $thumb_id ),
                                $gallery_ids
                            );

                            $all_images = array_unique( $all_images );

                            foreach ( $all_images as $index => $image_id ) :

                                $thumb_url = wp_get_attachment_image_url(
                                    $image_id,
                                    'thumbnail'
                                );

                                $large_url = wp_get_attachment_image_url(
                                    $image_id,
                                    'large'
                                );
                            ?>

                                <div
                                    class="gallery-thumb <?php echo $index === 0 ? 'active' : ''; ?>"
                                    data-image="<?php echo esc_url( $large_url ); ?>"
                                >

                                    <img
                                        src="<?php echo esc_url( $thumb_url ); ?>"
                                        alt=""
                                    >

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>

                <!-- RIGHT -->
                <div class="product-summary-wrap">

                    <!-- TITLE -->
                    <h1 class="product-title">

                        <?php echo esc_html( $title ); ?>

                    </h1>

                    <!-- SHORT DESC -->
                    <?php if ( $excerpt ) : ?>

                        <div class="product-short-description">

                            <?php echo wp_kses_post( $excerpt ); ?>

                        </div>

                    <?php endif; ?>

                    <!-- PRICE -->
                    <div class="product-price-wrap">

                        <div class="product-price">

                            <?php echo wp_kses_post( $price_html ); ?>

                            <sub>per 500g</sub>

                        </div>

                    </div>

                    <!-- DESCRIPTION -->
                    <div class="product-description">

                        <?php echo wp_kses_post( $description ); ?>

                    </div>


                    <!-- CART -->
                    <div class="product-cart-wrap">

                        <form
                            class="cart custom-cart"
                            action="<?php echo esc_url( $product->get_permalink() ); ?>"
                            method="post"
                            enctype="multipart/form-data"
                        >

                            <!-- QTY -->
                             <p>Quantity</p>
                            <div class="custom-qty-wrap">
                            
                                <button
                                    type="button"
                                    class="qty-btn qty-minus"
                                >
                                    −
                                </button>

                                <input
                                    type="number"
                                    id="quantity"
                                    class="qty-input"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                >

                                <button
                                    type="button"
                                    class="qty-btn qty-plus"
                                >
                                    +
                                </button>

                            </div>
                            <!-- SIZES -->
                    <div class="product-sizes">

                        <p>
                            Available in 250g, 500g, and 1kg packs
                        </p>

                    </div>

                            <!-- BUTTON -->
                            <button
                                type="submit"
                                name="add-to-cart"
                                value="<?php echo esc_attr( $product->get_id() ); ?>"
                                class="single_add_to_cart_button button alt custom-cart-btn"
                            >

                                Buy Now

                            </button>

                        </form>

                    </div>

                     

                </div>

            </section>

            <!-- FEATURES -->
            <?php if ( ! empty( $product_features ) ) : ?>

                <section class="product-feature-cards">

                    <?php foreach ( $product_features as $feature ) : ?>

                        <div class="feature-card">

                            <?php if ( ! empty( $feature['icon'] ) ) : ?>

                                <div class="feature-icon">

                                    <img
                                        src="<?php echo esc_url( $feature['icon'] ); ?>"
                                        alt="<?php echo esc_attr( $feature['title'] ); ?>"
                                    >

                                </div>

                            <?php endif; ?>

                            <?php if ( ! empty( $feature['title'] ) ) : ?>

                                <h4>

                                    <?php echo esc_html( $feature['title'] ); ?>

                                </h4>

                            <?php endif; ?>

                            <?php if ( ! empty( $feature['content'] ) ) : ?>

                                <p>

                                    <?php echo esc_html( $feature['content'] ); ?>

                                </p>

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                </section>

            <?php endif; ?>

            <!-- CULTIVATION -->
            <?php if ( $cultivation ) : ?>

                <section class="product-info-section">

                    <h2>
                        Cultivation
                    </h2>

                    <div class="section-content-box">

                        <?php echo wp_kses_post( $cultivation ); ?>

                    </div>

                </section>

            <?php endif; ?>

            <!-- HEALTH BENEFITS -->
            <?php if ( $health_benefits ) : ?>

                <section class="product-info-section">

                    <h2>
                        Health Benefits
                    </h2>

                    <div class="section-content-box health-benefits">

                        <?php echo wp_kses_post( $health_benefits ); ?>

                    </div>

                </section>

            <?php endif; ?>

            <!-- NUTRITION -->
            <section class="product-info-section nutrition-section">

                <h2>
                    Nutritional Value
                </h2>

                <div class="nutrition-table-wrap">

                    <?php
                    $nutrition_fields = array(

                        'energy'         => 'Energy',
                        'fat'            => 'Fat',
                        'total_sugar'    => 'Total Sugar',
                        'protein'        => 'Protein',
                        'carbohydrates'  => 'Carbohydrates',
                        'saturated_fat'  => 'Saturated Fat',

                    );

                    foreach ( $nutrition_fields as $field_name => $label ) :

                        $value = get_field(
                            $field_name,
                            $post_id
                        );

                        if ( ! empty( $value ) ) :
                    ?>

                            <div class="nutrition-box">

                                <span>

                                    <?php echo esc_html( $label ); ?>

                                </span>

                                <strong>

                                    <?php echo esc_html( $value ); ?>

                                </strong>

                            </div>

                    <?php
                        endif;

                    endforeach;
                    ?>

                </div>

            </section>

            <!-- CTA -->
            <section class="single-product-cta">

                <div class="cta-content">

                    <h2>
                        Be a Part of the Change
                    </h2>

                    <p>
                        Support sustainable livelihoods while choosing natural products. Every<br> purchase makes a difference.
                    </p>

                    <div class="cta-buttons">

                        <a href="#contact" class="btn-outline">
                            Enquire Now
                        </a>

                        <a
                            href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                            class="btn-primary"
                        >
                            View All Products
                        </a>

                    </div>

                </div>

            </section>

        </div>

    </div>

</div>

<?php endwhile; ?>

<?php
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
?>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        // QUANTITY
        const minusBtn = document.querySelector('.qty-minus');
        const plusBtn  = document.querySelector('.qty-plus');
        const qtyInput = document.querySelector('.qty-input');

        if ( minusBtn ) {

            minusBtn.addEventListener(
                'click',
                function () {

                    let current = parseInt( qtyInput.value );

                    if ( current > 1 ) {

                        qtyInput.value = current - 1;

                    }

                }
            );

        }

        if ( plusBtn ) {

            plusBtn.addEventListener(
                'click',
                function () {

                    let current = parseInt( qtyInput.value );

                    qtyInput.value = current + 1;

                }
            );

        }

        // GALLERY
        const thumbs = document.querySelectorAll('.gallery-thumb');

        thumbs.forEach(function(thumb){

            thumb.addEventListener(
                'click',
                function(){

                    const image = this.getAttribute('data-image');

                    document.getElementById(
                        'main-product-image'
                    ).src = image;

                    thumbs.forEach(function(item){

                        item.classList.remove('active');

                    });

                    this.classList.add('active');

                }
            );

        });

    }
);

</script>