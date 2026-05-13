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
?>

<div class="single-product-page-wrap">

    <div class="container">

        <?php while ( have_posts() ) : ?>

            <?php
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

            $attachment_ids = $product->get_gallery_image_ids();

            /*
            |--------------------------------------------------------------------------
            | CUSTOM PRODUCT FEATURES
            |--------------------------------------------------------------------------
            */

            $product_features = get_post_meta(
                $post_id,
                '_product_features',
                true
            );
            ?>

            <div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-custom', $product ); ?>>

                <!-- Back Link -->
                <div class="product-back-link">

                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
                        ← Back to Home
                    </a>

                </div>

                <!-- Product Hero -->
                <section class="product-hero">

                    <!-- LEFT -->
                    <div class="product-gallery-wrap">

                        <!-- Main Image -->
                        <div class="product-main-image">

                            <?php
                            echo wp_get_attachment_image(
                                $product->get_image_id(),
                                'large'
                            );
                            ?>

                        </div>

                        <!-- Gallery -->
                        <?php if ( ! empty( $attachment_ids ) ) : ?>

                            <div class="product-gallery-thumbs">

                                <!-- Featured -->
                                <div class="gallery-thumb active">

                                    <?php
                                    echo wp_get_attachment_image(
                                        $product->get_image_id(),
                                        'thumbnail'
                                    );
                                    ?>

                                </div>

                                <!-- Gallery Images -->
                                <?php foreach ( $attachment_ids as $attachment_id ) : ?>

                                    <div class="gallery-thumb">

                                        <?php
                                        echo wp_get_attachment_image(
                                            $attachment_id,
                                            'thumbnail'
                                        );
                                        ?>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        <?php endif; ?>

                    </div>

                    <!-- RIGHT -->
                    <div class="product-summary-wrap">

                        <!-- Title -->
                        <h1 class="product-title">

                            <?php echo esc_html( $title ); ?>

                        </h1>

                        <!-- Short Description -->
                        <?php if ( $excerpt ) : ?>

                            <div class="product-short-description">

                                <?php echo wp_kses_post( $excerpt ); ?>

                            </div>

                        <?php endif; ?>

                        <!-- Price -->
                        <div class="product-price-wrap">

                            <div class="product-price">

                                <?php echo wp_kses_post( $price_html ); ?>

                                <sub>/ 500g</sub>

                            </div>

                        </div>

                        <!-- Description -->
                        <div class="product-description">

                            <?php echo wp_kses_post( $description ); ?>

                        </div>
                      
                            
                        <!-- Add To Cart -->
                        <div class="product-cart-wrap">

                           <form
    class="cart custom-cart"
    action="<?php echo esc_url( $product->get_permalink() ); ?>"
    method="post"
    enctype="multipart/form-data"
>

    <!-- Quantity Label -->
    <label class="qty-label">
        Quantity
    </label>

    <!-- Quantity Box -->
    <div class="custom-qty-wrap">

        <!-- Minus -->
        <button
            type="button"
            class="qty-btn qty-minus"
        >
            −
        </button>

        <!-- Quantity Input -->
        <input
            type="number"
            id="quantity"
            class="qty-input"
            step="1"
            min="1"
            max=""
            name="quantity"
            value="1"
            title="Qty"
        >

        <!-- Plus -->
        <button
            type="button"
            class="qty-btn qty-plus"
        >
            +
        </button>

    </div>

    <div class="product-sizes">
                            <p>Available in 250g, 500g, and 1kg packs</p>
                        </div>

    <!-- Add To Cart -->
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


                <!-- Product Features -->
                <?php if ( ! empty( $product_features ) ) : ?>

                    <section class="product-feature-cards">

                        <?php foreach ( $product_features as $feature ) : ?>

                            <div class="feature-card">

                                <!-- Icon -->
                                <?php if ( ! empty( $feature['icon'] ) ) : ?>

                                    <div class="feature-icon feature-icon-img">

                                        <img
                                            src="<?php echo esc_url( $feature['icon'] ); ?>"
                                            alt="<?php echo esc_attr( $feature['title'] ); ?>"
                                        >

                                    </div>

                                <?php endif; ?>

                                <!-- Title -->
                                <?php if ( ! empty( $feature['title'] ) ) : ?>

                                    <h4>

                                        <?php echo esc_html( $feature['title'] ); ?>

                                    </h4>

                                <?php endif; ?>

                                <!-- Content -->
                                <?php if ( ! empty( $feature['content'] ) ) : ?>

                                    <p>

                                        <?php echo esc_html( $feature['content'] ); ?>

                                    </p>

                                <?php endif; ?>

                            </div>

                        <?php endforeach; ?>

                    </section>

                <?php endif; ?>


                <!-- Cultivation -->
                <?php if ( $cultivation ) : ?>

                    <section class="product-info-section cultivation-section">

                        <h2>
                            Cultivation
                        </h2>

                        <div class="section-content-box">

                            <?php echo wp_kses_post( $cultivation ); ?>

                        </div>

                    </section>

                <?php endif; ?>


                <!-- Health Benefits -->
                <?php if ( $health_benefits ) : ?>

                    <section class="product-info-section health-benefits-section">

                        <h2>
                            Health Benefits
                        </h2>

                        <div class="section-content-box health-benefits card__features">

                            <?php echo wp_kses_post( $health_benefits ); ?>

                        </div>

                    </section>

                <?php endif; ?>


                <!-- Nutritional Value -->
            
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

        <?php endwhile; ?>

    </div>

</div>

<?php
/**
 * Hook:
 * woocommerce_after_main_content
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook:
 * woocommerce_sidebar
 */
do_action( 'woocommerce_sidebar' );?>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const minusBtn = document.querySelector('.qty-minus');
    const plusBtn  = document.querySelector('.qty-plus');
    const qtyInput = document.querySelector('.qty-input');

    if( minusBtn ){

        minusBtn.addEventListener('click', function(){

            let current = parseInt(qtyInput.value);

            if( current > 1 ){
                qtyInput.value = current - 1;
            }

        });

    }

    if( plusBtn ){

        plusBtn.addEventListener('click', function(){

            let current = parseInt(qtyInput.value);

            qtyInput.value = current + 1;

        });

    }

});

</script>
<?php

get_footer( 'shop' );
?>