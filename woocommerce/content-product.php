<?php
/**
 * Custom Product Card
 * File: your-theme/woocommerce/content-product.php
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$post_id         = $product->get_id();
$title           = $product->get_name();
$permalink       = $product->get_permalink();
$excerpt         = $product->get_short_description();
$thumb_url       = get_the_post_thumbnail_url( $post_id, 'large' );
$price_html      = $product->get_price_html();
$health_benefits = get_field( 'health_benefits', $post_id );
?>

<li <?php wc_product_class( 'card', $product ); ?>>

    <!-- Product Image -->
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

    <!-- Product Content -->
    <div class="card__body">

        <!-- Product Title -->
        <h2 class="card__title">

            <a href="<?php echo esc_url( $permalink ); ?>">

                <?php echo esc_html( $title ); ?>

            </a>

        </h2>

        <!-- Product Description -->
        <?php if ( $excerpt ) : ?>

            <p class="card__desc">

                <?php echo wp_kses_post( $excerpt ); ?>

            </p>

        <?php endif; ?>

        <!-- ACF Features -->
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

        <!-- Footer -->
        <div class="card__footer">

            <!-- Price -->
            <div class="card__price">

                <?php echo wp_kses_post( $price_html ); ?>

                <sub>/ 500g</sub>

            </div>

            <!-- Add To Cart -->
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
                    esc_html__( 'Buy Now', 'woocommerce' )
                ),
                $product
            );
            ?>

        </div>

    </div>

</li>