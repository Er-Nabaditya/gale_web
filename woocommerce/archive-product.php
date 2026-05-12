<?php
/**
 * Template Name: Product Archive
 * Template Post Type: page
 */
get_header();
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
      <div class="products__grid">

        <?php
        $products_query = new WP_Query( array(
          'post_type'      => 'product',
          'posts_per_page' => -1,
          'post_status'    => 'publish',
          'orderby'        => 'date',
          'order'          => 'asc',
        ) );

        if ( $products_query->have_posts() ) :
          while ( $products_query->have_posts() ) : $products_query->the_post();

            $post_id         = get_the_ID();
            $product         = wc_get_product( $post_id );
            $title           = get_the_title();
            $permalink       = get_permalink();
            $excerpt = $product ? $product->get_short_description() : '';
            $thumb_url       = get_the_post_thumbnail_url( $post_id, 'large' );
            $price_html      = $product ? $product->get_price_html() : '';
            $cart_url        = $product ? esc_url( $product->add_to_cart_url() ) : '#';


            $health_benefits = get_field( 'health_benefits', $post_id );
        ?>

        <article class="card">

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

            <?php
            $health_benefits = get_field( 'health_benefits', $post_id );
            if ( ! empty( $health_benefits ) ) : ?>
            <ul class="card__features">
                <?php echo wp_kses( $health_benefits, array( 'li' => array() ) ); ?>
            </ul>
            <?php endif; 
            ?>

            <div class="card__footer">
              <div class="card__price"><?php echo $price_html; ?><sub>/ 500g</sub></div>
              <a href="<?php echo $cart_url; ?>" class="card__btn">Buy Now</a>
            </div>

          </div>
        </article>

        <?php
          endwhile;
          wp_reset_postdata();
        else : ?>
          <p class="no-products">No products found.</p>
        <?php endif; ?>

      </div>
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

<?php get_footer(); ?>