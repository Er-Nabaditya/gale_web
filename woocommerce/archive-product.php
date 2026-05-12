<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * Override by copying to: yourtheme/woocommerce/archive-product.php
 *
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper     - 10 (opens .woocommerce wrapper divs)
 * @hooked woocommerce_breadcrumb                 - 20 (default WC breadcrumb — we hide via CSS and use our own below)
 * @hooked WC_Structured_Data::generate_website_data() - 30 (SEO structured data — keep this)
 */
do_action( 'woocommerce_before_main_content' );

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 * @hooked woocommerce_product_taxonomy_archive_header - 10 (renders category image + description)
 */
do_action( 'woocommerce_shop_loop_header' );
?>

<div class="products-page-wrap">
  <div class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="<?php echo esc_url( home_url('/') ); ?>">Home</a>
      <span class="breadcrumb__sep">›</span>
      <span>Products</span>
    </nav>

    <!-- Page Hero -->
    <div class="page-hero">
      <h1>Our Products</h1>
      <p>Naturally sourced, traditionally processed, and ethically produced. Each product represents our commitment to quality and sustainability.</p>
    </div>

    <!-- PRODUCT GRID -->
    <section class="products" aria-label="Product listing">

      <?php if ( woocommerce_product_loop() ) : ?>

        <?php
        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10 (stock/error notices)
         * @hooked woocommerce_result_count       - 20 (e.g. "Showing 1–12 of 24 results")
         * @hooked woocommerce_catalog_ordering   - 30 (sort by dropdown)
         */
        do_action( 'woocommerce_before_shop_loop' );
        ?>

        <div class="products__grid">

          <?php
          if ( wc_get_loop_prop( 'total' ) ) :
            while ( have_posts() ) :
              the_post();

              $post_id         = get_the_ID();
              $product         = wc_get_product( $post_id );

              if ( ! $product ) continue;

              $title           = get_the_title();
              $permalink       = get_permalink();
              $excerpt         = $product->get_short_description();
              $thumb_url       = get_the_post_thumbnail_url( $post_id, 'large' );
              $price_html      = $product->get_price_html();
              $cart_url        = esc_url( $product->add_to_cart_url() );
              $health_benefits = get_field( 'health_benefits', $post_id );

              /**
               * Hook: woocommerce_shop_loop.
               * Allows plugins (wishlists, quick-view, badges) to fire per product.
               */
              do_action( 'woocommerce_shop_loop' );
          ?>

          <article class="card" <?php wc_product_class( '', $product ); ?>>

            <!-- Image -->
            <div class="card__img-wrap">
              <a href="<?php echo esc_url( $permalink ); ?>">
                <?php if ( $thumb_url ) : ?>
                  <img
                    src="<?php echo esc_url( $thumb_url ); ?>"
                    alt="<?php echo esc_attr( $title ); ?>"
                    loading="lazy" />
                <?php else : ?>
                  <div class="card__img-placeholder"></div>
                <?php endif; ?>
              </a>
            </div>

            <!-- Body -->
            <div class="card__body">

              <h2 class="card__title">
                <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
              </h2>

              <p class="card__desc"><?php echo wp_kses_post( $excerpt ); ?></p>

              <?php if ( ! empty( $health_benefits ) ) : ?>
              <ul class="card__features">
                <?php echo wp_kses( $health_benefits, array( 'li' => array() ) ); ?>
              </ul>
              <?php endif; ?>

              <div class="card__footer">
                <div class="card__price"><?php echo $price_html; ?><sub>/ 500g</sub></div>
                <a href="<?php echo $cart_url; ?>" class="card__btn">Buy Now</a>
              </div>

            </div>
          </article>

          <?php
            endwhile;
          endif;
          ?>

        </div><!-- .products__grid -->

        <?php
        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action( 'woocommerce_after_shop_loop' );
        ?>

      <?php else : ?>

        <?php
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action( 'woocommerce_no_products_found' );
        ?>

      <?php endif; ?>

    </section>

  </div>
</div>

<!-- CAN'T FIND CTA -->
<section class="cta-strip">
  <div class="cta-strip__icon" aria-hidden="true">
    <img src="<?php echo esc_url( content_url( '/uploads/2026/05/leaf-icon.png' ) ); ?>" alt="icon" />
  </div>
  <h2>Can't Find What You're Looking For?</h2>
  <p>We work with local farmers to source a variety of natural products. Get in touch to discuss your requirements.</p>
  <a href="<?php echo esc_url( home_url('/#contact') ); ?>" class="cta-strip__btn">Contact Us</a>
</section>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (closes .woocommerce wrapper divs)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );