<?php
/**
 * WooCommerce Product Archive Template
 * File: your-theme/woocommerce/archive-product.php
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook:
 * woocommerce_before_main_content
 *
 * @hooked woocommerce_output_content_wrapper - 10
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>

<div class="products-page-wrap">

    <div class="container">

        <!-- Hero -->
        <div class="page-hero">

            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

                <h1 class="woocommerce-products-header__title page-title">
                    Our Products
                </h1>
                  <p>Naturally sourced, traditionally processed, and ethically produced. Each product represents our commitment to quality and sustainability.
            </p>

            <?php endif; ?>

            <?php
            /**
             * Hook:
             * woocommerce_archive_description
             *
             * @hooked woocommerce_taxonomy_archive_description - 10
             * @hooked woocommerce_product_archive_description - 10
             */
            do_action( 'woocommerce_archive_description' );
            ?>

        </div>

        <?php if ( woocommerce_product_loop() ) : ?>

            <?php
            /**
             * Hook:
             * woocommerce_before_shop_loop
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action( 'woocommerce_before_shop_loop' );
            ?>

          <section class="products">

    <ul class="products products__grid">

        <?php
        while ( have_posts() ) :
            the_post();

            wc_get_template_part( 'content', 'product' );

        endwhile;
        ?>

    </ul>

</section>

            <?php
            /**
             * Hook:
             * woocommerce_after_shop_loop
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>

        <?php else : ?>

            <?php
            /**
             * Hook:
             * woocommerce_no_products_found
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' );
            ?>

        <?php endif; ?>

    </div>

</div>

<!-- CTA -->
<section class="cta-strip">

    <div class="cta-strip__icon">

        <img
            src="<?php echo esc_url( content_url( '/uploads/2026/05/leaf-icon.png' ) ); ?>"
            alt=""
        >

    </div>

    <h2>
        Can't Find What You're Looking For?
    </h2>

    <p>
        We work with local farmers to source a variety of natural products.
        Get in touch to discuss your requirements.
    </p>

    <a
        href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"
        class="cta-strip__btn"
    >
        Contact Us
    </a>

</section>

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
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
?>