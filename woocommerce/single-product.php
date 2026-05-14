<?php

/**
 * Single Product Template
 * File: your-theme/woocommerce/single-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook:
 * woocommerce_before_main_content
 */
do_action('woocommerce_before_main_content');
?>

<div class="single-product-page-wrap">

    <div class="container">

        <?php while (have_posts()) : ?>

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0
            <?php
            the_post();

            global $product;

            $post_id = $product->get_id();
<<<<<<< HEAD
=======
    a {
        color: inherit;
        text-decoration: none;
    }

    img {
        display: block;
        max-width: 100%;
    }

    /* ──────────────────────────────────────────────
   CONTAINER
────────────────────────────────────────────── */
    .sp-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }
>>>>>>> 727437bc187b492baa854f69694d67bea70bb491
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0

            $title       = $product->get_name();
            $price_html  = $product->get_price_html();
            $excerpt     = $product->get_short_description();
            $description = $product->get_description();

            $cultivation       = get_field('cultivation', $post_id);
            $health_benefits   = get_field('health_benefits', $post_id);
            $nutritional_value = get_field('nutritional_value', $post_id);

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0
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
<<<<<<< HEAD
=======
    .sp-breadcrumb a:hover {
        color: var(--green-dark);
    }
>>>>>>> 727437bc187b492baa854f69694d67bea70bb491
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0

            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('single-product-custom', $product); ?>>

                <!-- Back Link -->
                <div class="product-back-link">

                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
                        ← Back to Home
                    </a>

                </div>

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0
                <!-- Product Hero -->
                <section class="product-hero">

                    <!-- LEFT -->
                    <div class="product-gallery-wrap">

                        <!-- Main Image -->
                        <div class="product-main-image">
<<<<<<< HEAD
=======
                <!-- Thumbnails -->
                <?php if (! empty($gallery_ids) || $thumb_id) : ?>
                    <div class="sp-gallery__thumbs">
                        <?php
                        // Always include the featured image as first thumb
                        $all_thumb_ids = array_merge(array($thumb_id), $gallery_ids);
                        $all_thumb_ids = array_unique(array_filter($all_thumb_ids));
                        foreach ($all_thumb_ids as $idx => $img_id) :
                            $t_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                            $f_url = wp_get_attachment_image_url($img_id, 'large');
                            if (! $t_url) continue;
                        ?>
                            <div class="sp-gallery__thumb <?php echo $idx === 0 ? 'is-active' : ''; ?>"
                                data-full="<?php echo esc_url($f_url); ?>"
                                onclick="spSwitchImg(this)">
                                <img src="<?php echo esc_url($t_url); ?>" alt="" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="sp-info">
                <p class="sp-info__tagline">Naturally processed, rich in nutrients</p>
                <h1 class="sp-info__title"><?php echo esc_html($title); ?></h1>

                <div class="sp-info__price">
                    <?php echo $price_html; ?><sub>&nbsp;/ 500g</sub>
                </div>
>>>>>>> 727437bc187b492baa854f69694d67bea70bb491
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0

                            <?php
                            echo wp_get_attachment_image(
                                $product->get_image_id(),
                                'large'
                            );
                            ?>

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0
                        </div>

                        <!-- Gallery -->
                        <?php if (! empty($attachment_ids)) : ?>

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
                                <?php foreach ($attachment_ids as $attachment_id) : ?>

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

                            <?php echo esc_html($title); ?>

                        </h1>

                        <!-- Short Description -->
                        <?php if ($excerpt) : ?>

                            <div class="product-short-description">

                                <?php echo wp_kses_post($excerpt); ?>

                            </div>

                        <?php endif; ?>

                        <!-- Price -->
                        <div class="product-price-wrap">

                            <div class="product-price">

                                <?php echo wp_kses_post($price_html); ?>

                                <sub>/ 500g</sub>

                            </div>

                        </div>

                        <!-- Description -->
                        <div class="product-description">

                            <?php echo wp_kses_post($description); ?>

                        </div>


                        <!-- Add To Cart -->
                        <div class="product-cart-wrap">

                            <form
                                class="cart custom-cart"
                                action="<?php echo esc_url($product->get_permalink()); ?>"
                                method="post"
                                enctype="multipart/form-data">

                                <!-- Quantity Label -->
                                <label class="qty-label">
                                    Quantity
                                </label>

                                <!-- Quantity Box -->
                                <div class="custom-qty-wrap">

                                    <!-- Minus -->
                                    <button
                                        type="button"
                                        class="qty-btn qty-minus">
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
                                        title="Qty">

                                    <!-- Plus -->
                                    <button
                                        type="button"
                                        class="qty-btn qty-plus">
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
                                    value="<?php echo esc_attr($product->get_id()); ?>"
                                    class="single_add_to_cart_button button alt custom-cart-btn">
                                    Buy Now
                                </button>

                            </form>

                        </div>



                    </div>

                </section>


                <!-- Product Features -->
                <?php if (! empty($product_features)) : ?>

                    <section class="product-feature-cards">

                        <?php foreach ($product_features as $feature) : ?>

                            <div class="feature-card">

                                <!-- Icon -->
                                <?php if (! empty($feature['icon'])) : ?>

                                    <div class="feature-icon feature-icon-img">

                                        <img
                                            src="<?php echo esc_url($feature['icon']); ?>"
                                            alt="<?php echo esc_attr($feature['title']); ?>">

                                    </div>

                                <?php endif; ?>

                                <!-- Title -->
                                <?php if (! empty($feature['title'])) : ?>

                                    <h4>

                                        <?php echo esc_html($feature['title']); ?>

                                    </h4>

                                <?php endif; ?>

                                <!-- Content -->
                                <?php if (! empty($feature['content'])) : ?>

                                    <p>

                                        <?php echo esc_html($feature['content']); ?>

                                    </p>

                                <?php endif; ?>

                            </div>

                        <?php endforeach; ?>

                    </section>

                <?php endif; ?>


                <!-- Cultivation -->
                <?php if ($cultivation) : ?>

                    <section class="product-info-section cultivation-section">

                        <h2>
                            Cultivation
                        </h2>

                        <div class="section-content-box">

                            <?php echo wp_kses_post($cultivation); ?>

                        </div>

                    </section>

                <?php endif; ?>


                <!-- Health Benefits -->
                <?php if ($health_benefits) : ?>

                    <section class="product-info-section health-benefits-section">

                        <h2>
                            Health Benefits
                        </h2>

                        <div class="section-content-box health-benefits card__features">

                            <?php echo wp_kses_post($health_benefits); ?>

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

                        foreach ($nutrition_fields as $field_name => $label) :

                            $value = get_field(
                                $field_name,
                                $post_id
                            );

                            if (! empty($value)) :
                        ?>

                                <div class="nutrition-box">

                                    <span>

                                        <?php echo esc_html($label); ?>

                                    </span>

                                    <strong>

                                        <?php echo esc_html($value); ?>

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
                                href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                                class="btn-primary">
                                View All Products
                            </a>

                        </div>

                    </div>

                </section>
<<<<<<< HEAD
=======
        <!-- NUTRITIONAL VALUE -->
        <?php
        // Fallback nutritional data if ACF not set
        $nutrition = ! empty($nutritional_value) ? $nutritional_value : array(
            array('label' => 'Energy',       'value' => '475g'),
            array('label' => 'Fat',          'value' => '60.81g'),
            array('label' => 'Total Sugar',  'value' => '35.21g'),
            array('label' => 'Protein',      'value' => '21-69g'),
            array('label' => 'Carbohydrates', 'value' => '49.5g'),
            array('label' => 'Saturated Fat', 'value' => '8.57'),
        );
        ?>
        <section class="sp-section">
            <h2 class="sp-section__title">Nutritional Value</h2>
            <div class="sp-nutrition__grid">
                <?php foreach ($nutrition as $item) :
                    $lbl = is_array($item) ? ($item['label'] ?? '') : $item;
                    $val = is_array($item) ? ($item['value'] ?? '') : '';
                ?>
                    <div class="sp-nutrition__cell">
                        <div class="sp-nutrition__cell-label"><?php echo esc_html($lbl); ?></div>
                        <div class="sp-nutrition__cell-value"><?php echo esc_html($val); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </div><!-- /.sp-container -->
>>>>>>> 727437bc187b492baa854f69694d67bea70bb491
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0

            </div>

        <?php endwhile; ?>

    </div>

</div>

<?php
/**
 * Hook:
 * woocommerce_after_main_content
 */
do_action('woocommerce_after_main_content');

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0
/**
 * Hook:
 * woocommerce_sidebar
 */
do_action('woocommerce_sidebar'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const minusBtn = document.querySelector('.qty-minus');
        const plusBtn = document.querySelector('.qty-plus');
        const qtyInput = document.querySelector('.qty-input');

        if (minusBtn) {

            minusBtn.addEventListener('click', function() {

                let current = parseInt(qtyInput.value);

                if (current > 1) {
                    qtyInput.value = current - 1;
                }

            });

        }

        if (plusBtn) {

            plusBtn.addEventListener('click', function() {

                let current = parseInt(qtyInput.value);

                qtyInput.value = current + 1;

            });

        }

    });
</script>
<?php

<<<<<<< HEAD
get_footer( 'shop' );
?>
=======
    /* Quantity stepper */
    function spQty(delta) {
        var inp = document.getElementById('sp-qty');
        var val = parseInt(inp.value, 10) + delta;
        if (val < 1) val = 1;
        if (val > 99) val = 99;
        inp.value = val;
    }

    /* Weight toggle */
    function spToggleWeight(btn) {
        var siblings = btn.parentElement.querySelectorAll('.sp-weight-btn');
        siblings.forEach(function(s) {
            s.classList.remove('is-active');
        });
        btn.classList.add('is-active');
    }
</script>

<?php get_footer(); ?>
>>>>>>> 727437bc187b492baa854f69694d67bea70bb491
=======
get_footer('shop');
?>
>>>>>>> a275d3b04c98a11d147c27bb620728fc0762c9c0
