<?php
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

            <h1>
                Our Products
            </h1>

            <p>
                Naturally sourced, traditionally processed,
                and ethically produced.
                Each product represents our commitment
                to quality and sustainability.
            </p>

        </div>

        <?php if ( woocommerce_product_loop() ) : ?>

            <?php
            /**
             * Hook:
             * notices
             * result count
             * ordering
             */
            do_action( 'woocommerce_before_shop_loop' );
            ?>

            <section class="products" aria-label="Product listing">

                <div class="products__grid">

                    <?php
                    if ( wc_get_loop_prop( 'total' ) ) :

                        while ( have_posts() ) :

                            the_post();

                            global $product;

                            if ( ! $product ) {
                                $product = wc_get_product( get_the_ID() );
                            }

                            if ( ! $product ) {
                                continue;
                            }

                            $post_id         = $product->get_id();
                            $title           = $product->get_name();
                            $permalink       = $product->get_permalink();
                            $excerpt         = $product->get_short_description();
                            $thumb_url       = get_the_post_thumbnail_url( $post_id, 'large' );
                            $price_html      = $product->get_price_html();
                            $cart_url        = $product->add_to_cart_url();
                            $health_benefits = get_field( 'health_benefits', $post_id );

                            /**
                             * Hook:
                             * woocommerce_shop_loop
                             */
                            do_action( 'woocommerce_shop_loop' );
                    ?>

                    <article <?php wc_product_class( 'card', $product ); ?>>

                        <!-- Image -->
                        <div class="card__img-wrap">

                            <a href="<?php echo esc_url( $permalink ); ?>">

                                <?php if ( $thumb_url ) : ?>

                                    <img
                                        src="<?php echo esc_url( $thumb_url ); ?>"
                                        alt="<?php echo esc_attr( $title ); ?>"
                                        loading="lazy"
                                    >

                                <?php else : ?>

                                    <div class="card__img-placeholder"></div>

                                <?php endif; ?>

                            </a>

                        </div>

                        <!-- Body -->
                        <div class="card__body">

                            <h2 class="card__title">

                                <a href="<?php echo esc_url( $permalink ); ?>">
                                    <?php echo esc_html( $title ); ?>
                                </a>

                            </h2>

                            <?php if ( $excerpt ) : ?>

                                <p class="card__desc">
                                    <?php echo wp_kses_post( $excerpt ); ?>
                                </p>

                            <?php endif; ?>

                            <?php if ( ! empty( $health_benefits ) ) : ?>

                                <ul class="card__features">

                                    <?php
                                    echo wp_kses(
                                        $health_benefits,
                                        array(
                                            'li' => array(),
                                        )
                                    );
                                    ?>

                                </ul>

                            <?php endif; ?>

                            <div class="card__footer">

                                <div class="card__price">

                                    <?php echo wp_kses_post( $price_html ); ?>

                                    <sub>/ 500g</sub>

                                </div>

                                <?php
                                echo apply_filters(
                                    'woocommerce_loop_add_to_cart_link',
                                    sprintf(
                                        '<a href="%s" data-quantity="1" class="card__btn button %s" %s>%s</a>',
                                        esc_url( $product->add_to_cart_url() ),
                                        esc_attr(
                                            implode(
                                                ' ',
                                                array_filter(
                                                    array(
                                                        'product_type_' . $product->get_type(),
                                                        $product->supports( 'ajax_add_to_cart' )
                                                            ? 'ajax_add_to_cart'
                                                            : '',
                                                    )
                                                )
                                            )
                                        ),
                                        wc_implode_html_attributes(
                                            array(
                                                'data-product_id'  => $product->get_id(),
                                                'data-product_sku' => $product->get_sku(),
                                                'aria-label'       => $product->add_to_cart_description(),
                                                'rel'              => 'nofollow',
                                            )
                                        ),
                                        'Buy Now'
                                    ),
                                    $product
                                );
                                ?>

                            </div>

                        </div>

                    </article>

                    <?php
                        endwhile;

                    endif;
                    ?>

                </div>

            </section>

            <?php
            /**
             * Hook:
             * pagination
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>

        <?php else : ?>

            <?php
            /**
             * Hook:
             * no products found
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

    <h2>Can't Find What You're Looking For?</h2>

    <p>
        We work with local farmers to source a variety of natural products.
        Get in touch to discuss your requirements.
    </p>

    <a
        href="<?php echo esc_url( home_url('/#contact') ); ?>"
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