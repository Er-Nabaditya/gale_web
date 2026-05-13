<?php

/**
 * Template Name: Gale Home
 * Template Post Type: page
 */
get_header();
?>

<!-- ══════════════════════════════════════════
     SECTION 1 — HERO
════════════════════════════════════════════ -->

<section class="gale-hero">
  <div class="container">
    <div class="hero-inner">

      <!-- Left Content -->
      <div class="hero-content">
        <h1><?php echo esc_html(get_field('hero_heading') ?: 'Empowering Lives Through Sustainable Livelihoods'); ?></h1>
        <p><?php echo esc_html(get_field('hero_subheading') ?: 'The Gale Livelihood Processing Centre was established to create decentralized livelihood opportunities for rural and tribal communities through value-added processing.'); ?></p>
        <a href="<?php echo esc_url(get_field('hero_cta_link') ?: get_permalink(wc_get_page_id('shop'))); ?>" class="btn-explore">
          <?php echo esc_html(get_field('hero_cta_text') ?: 'Explore Products'); ?>
        </a>
      </div>

      <!-- Right Image -->
      <div class="hero-image-wrap">
        <div class="hero-image-inner">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/home_right_side.png"
            alt="Gale Livelihood">
        </div>
        <div class="hero-badge">
          <small>Livelihood Impact</small>
          <span class="num_bold">50+ </span><span>Rural women and youth engaged</span>
        </div>
      </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 2 — WHO ARE WE
════════════════════════════════════════════ -->
<section class="gale-who">
  <div class="container">
    <div class="who-inner">

      <div class="who-image">
        <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/who_are_we.jpg" alt="Who Are We">
      </div>

      <!-- <div class="who-image">
        <?php
        $who_img = get_field('who_image');
        if ($who_img) : ?>
          <img src="<?php echo esc_url($who_img); ?>" alt="Who Are We">
        <?php else : ?>
          <div class="who-img-placeholder"></div>
        <?php endif; ?>
      </div> -->

      <div class="who-content">
        <h2>Who Are We?</h2>
        <p><?php echo esc_html(get_field('who_description') ?: 'We are tribal farmers from Palghar, a region rich in natural resources yet plagued by poverty. Determined to transform our lives, we have received support from generous benefactors who have helped bring water to our once barren lands. Now, we proudly offer you the fruits of our labor, cultivated with care and commitment to sustainability.'); ?></p>
        <div class="who-stats">
          <div class="stat-block">
            <div class="num">230+</div>
            <div class="label">Indirect Beneficiaries</div>
          </div>
          <div class="stat-block">
            <div class="num">168+</div>
            <div class="label">Farmers linked</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 3 — OUR MISSION
════════════════════════════════════════════ -->
<section class="gale-mission">
  <div class="container">
    <h2>Our Mission</h2>
    <p class="section-sub">To uplift rural and tribal communities by creating self-sustaining livelihood opportunities through ethical, environmentally conscious practices.</p>

    <div class="mission-grid">
      <?php
      $default_cards = [
        ['icon' => 'http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_2.png',  'title' => 'Supporting Local Farmers', 'desc' => 'Working directly with tribal farmers to ensure fair practices and sustainable livelihoods.'],
        ['icon' => 'http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_3.png',    'title' => 'Empowering Tribal Women',  'desc' => 'Creating skill development opportunities and dignified employment for women.'],
        ['icon' => 'http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_4.png',  'title' => 'Sustainable Development', 'desc' => 'Promoting environmentally conscious resource management.'],
        ['icon' => 'http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_5.png',   'title' => 'Local Employment',        'desc' => 'Establishing processing facilities that create jobs within the community.'],
      ];

      if (have_rows('mission_cards')) :
        while (have_rows('mission_cards')) : the_row(); ?>
          <div class="mission-card">
            <div class="mission-icon">
              <img src="<?php echo esc_url(get_sub_field('card_icon')); ?>" alt="<?php echo esc_attr(get_sub_field('card_title')); ?>">
            </div>
            <h4><?php echo esc_html(get_sub_field('card_title')); ?></h4>
            <p><?php echo esc_html(get_sub_field('card_desc')); ?></p>
          </div>
        <?php endwhile;
      else :
        foreach ($default_cards as $card) : ?>
          <div class="mission-card">
            <div class="mission-icon">
              <img src="<?php echo esc_url($card['icon']); ?>" alt="<?php echo esc_attr($card['title']); ?>">
            </div>
            <h4><?php echo esc_html($card['title']); ?></h4>
            <p><?php echo esc_html($card['desc']); ?></p>
          </div>
      <?php endforeach;
      endif; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 4 — PRODUCTS SLIDER
════════════════════════════════════════════ -->

<!-- $productss = gale_enqueue_product_styles('product', 6, 'date', 'DESC');
 print_r($productss); -->


<section class="gale-products">
  <div class="container">
    <h2>Products</h2>
    <p class="section-sub">Naturally sourced, traditionally processed, and ethically produced</p>

    <div class="products-slider-wrap">

      <button class="slider-arrow prev" id="sliderPrev">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-left.png" alt="prev">
      </button>

      <div class="products-slider" id="productsSlider">
        <?php
        $args = array(
          'post_type'      => 'product',
          'posts_per_page' => 10,
          'orderby'        => 'date',
          'order'          => 'DESC',
          'post_status'    => 'publish',
        );
        $products = new WP_Query($args);

        if ($products->have_posts()) :
          while ($products->have_posts()) : $products->the_post();
            global $product;
            $product = wc_get_product(get_the_ID());
        ?>
            <div class="product-slide">

              <!-- Product Image -->
              <div class="product-img-wrap">
                <?php if (has_post_thumbnail()) : ?>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium_large', ['class' => 'product-thumb']); ?>
                  </a>
                <?php else : ?>
                  <div class="product-img-placeholder"></div>
                <?php endif; ?>
              </div>

              <!-- Product Info -->
              <div class="product-info">
                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <p class="product-short-desc"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>

                <!-- ACF Features -->
                <?php if (have_rows('product_features')) : ?>
                  <ul class="product-features-list">
                    <?php while (have_rows('product_features')) : the_row(); ?>
                      <li><?php echo esc_html(get_sub_field('feature_text')); ?></li>
                    <?php endwhile; ?>
                  </ul>
                <?php endif; ?>

                <!-- Price + Button -->
                <div class="product-bottom">
                  <div class="product-price">
                    <?php echo $product->get_price_html(); ?>
                  </div>
                  <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                    class="btn-buynow">Buy Now</a>
                </div>
              </div>

            </div>
          <?php
          endwhile;
          wp_reset_postdata();
        else : ?>
          <p>No products found.</p>
        <?php endif; ?>
      </div>

      <button class="slider-arrow next" id="sliderNext">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/arrow-right.png" alt="next">
      </button>

    </div>

    <div class="slider-dots" id="sliderDots"></div>
  </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 5 — FROM FARM TO PACK
════════════════════════════════════════════ -->
<section class="gale-farm-to-pack">
  <div class="container">
    <h2>From Farm to Pack</h2>
    <p class="section-sub">Every step is handled with care, ensuring quality and supporting our community</p>

    <div class="farm-steps">
      <div class="farm-step">
        <div class="farm-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_6.png" alt="Cultivation">
        </div>
        <div class="farm-line"></div>
        <h5>Cultivation</h5>
        <p>Local farmers grow crops using sustainable, organic methods</p>
      </div>
      <div class="farm-step">
        <div class="farm-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_7.png" alt="Harvesting">
        </div>
        <div class="farm-line"></div>
        <h5>Harvesting</h5>
        <p>Careful hand-harvesting to ensure quality and minimize waste</p>
      </div>
      <div class="farm-step">
        <div class="farm-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_8.png" alt="Processing">
        </div>
        <div class="farm-line"></div>
        <h5>Processing</h5>
        <p>Traditional processing techniques preserve natural goodness</p>
      </div>
      <div class="farm-step">
        <div class="farm-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_9.png" alt="Packaging">
        </div>
        <div class="farm-line last"></div>
        <h5>Packaging</h5>
        <p>Hygienic packaging maintains freshness from farm to you</p>
      </div>
    </div>
  </div>

  <!-- Tree image bottom right -->
  <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Object.png" alt="" class="farm-tree-bg">
</section>

<!-- ══════════════════════════════════════════
     SECTION 6 — WHY CHOOSE US
════════════════════════════════════════════ -->
<section class="gale-why">
  <div class="container">
    <h2>Why Choose Us</h2>
    <p class="section-sub">Good for you. Better for communities.</p>

    <div class="why-grid">
      <div class="why-item">
        <div class="why-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_10.png" alt="Natural">
        </div>
        <div class="why-text">
          <h5>100% Natural &amp; Ethical</h5>
          <p>No chemicals, no shortcuts—just pure, natural products</p>
        </div>
      </div>
      <div class="why-item">
        <div class="why-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_11.png" alt="Community">
        </div>
        <div class="why-text">
          <h5>Community-Driven</h5>
          <p>Every purchase directly supports tribal families and their livelihoods</p>
        </div>
      </div>
      <div class="why-item">
        <div class="why-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_12.png" alt="Livelihoods">
        </div>
        <div class="why-text">
          <h5>Supports Livelihoods</h5>
          <p>Creating sustainable income opportunities for marginalized communities</p>
        </div>
      </div>
      <div class="why-item">
        <div class="why-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_13.png" alt="Sourcing">
        </div>
        <div class="why-text">
          <h5>Transparent Sourcing</h5>
          <p>Know exactly where your food comes from and who grows it</p>
        </div>
      </div>
      <div class="why-item">
        <div class="why-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_14.png" alt="Quality">
        </div>
        <div class="why-text">
          <h5>High-Quality Processing</h5>
          <p>Traditional methods combined with modern hygiene standards</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Tree image bottom right -->
  <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Object_why.png" alt="" class="why-tree-bg">
</section>

<!-- ══════════════════════════════════════════
     SECTION 7 — TESTIMONIALS
════════════════════════════════════════════ -->
<section class="gale-testimonials">
  <div class="container">
    <h2>Stories from Our Community</h2>
    <p class="section-sub">Hear directly from the people whose lives have been touched by this initiative</p>

    <div class="testimonials-grid">
      <div class="testimonial-card">
        <div class="quote-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_quoted.png" alt="quote">
        </div>
        <p class="quote-text">"This initiative has helped us earn a stable income and support our families. We are grateful for the opportunity to work with dignity."</p>
        <div class="testimonial-author">
          <div class="author-avatar">
            <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Container.png" alt="Savita Patel">
          </div>
          <div>
            <div class="author-name">Savita Patel</div>
            <div class="author-role">Local Worker, Gale Village</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="quote-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_quoted.png" alt="quote">
        </div>
        <p class="quote-text">"Being part of this center has given me skills and confidence. Now I can contribute to my household and feel empowered."</p>
        <div class="testimonial-author">
          <div class="author-avatar">
            <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/ImageWithFallback.png" alt="Ravi Thakur">
          </div>
          <div>
            <div class="author-name">Ravi Thakur</div>
            <div class="author-role">Cashew Processing Worker</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card">
        <div class="quote-icon">
          <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Icon_quoted.png" alt="quote">
        </div>
        <p class="quote-text">"The support from Gale Livelihood Centre has transformed our village. We now have hope for a better future for our children."</p>
        <div class="testimonial-author">
          <div class="author-avatar">
            <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Container_1.png" alt="Kamala Desai">
          </div>
          <div>
            <div class="author-name">Kamala Desai</div>
            <div class="author-role">Farmer, Gale Village</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SECTION 8 — GET IN TOUCH / CONTACT
════════════════════════════════════════════ -->
<section class="gale-contact">
  <div class="container">
    <h2>Get in Touch</h2>
    <p class="section-sub">Have questions or want to support our initiative? We'd love to hear from you</p>

    <div class="contact-inner">

      <!-- Left — Info + Map -->
      <div class="contact-info">
        <h3>Gale Livelihood Centre</h3>
        <p>Supporting tribal communities through sustainable livelihoods and skill development in Palghar, Maharashtra.</p>

        <div class="contact-detail">
          <div class="contact-detail-icon-wrap">
            <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/location_icon.png" alt="Address" width="24" height="24">
          </div>
          <div>
            <strong>Address</strong>
            <p>Gale Village, Palghar (Wada)<br>Maharashtra, India</p>
          </div>
        </div>

        <div class="contact-detail">
          <div class="contact-detail-icon-wrap">
            <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/Vector.png" alt="Phone" width="24" height="24">
          </div>
          <div>
            <strong>Phone</strong>
            <p>+91 98765 43210</p>
          </div>
        </div>

        <div class="contact-detail">
          <div class="contact-detail-icon-wrap">
            <img src="http://gale-livelihood.local/wp-content/uploads/2026/05/location_icon.png" alt="Email" width="24" height="24">
          </div>
          <div>
            <strong>Email</strong>
            <p>info@galelivelihood.org</p>
          </div>
        </div>


        <div class="contact-map">
          <iframe
            src="https://maps.google.com/maps?q=Panvel,Navi+Mumbai,Maharashtra&output=embed&z=14"
            width="100%" height="295"
            style="border:0; border-radius:12px;"
            allowfullscreen="" loading="lazy">
          </iframe>
        </div>
      </div>

      <!-- Right — Contact Form -->
      <div class="contact-form-wrap">
        <h3>Send us a Message</h3>
        <?php
        if (function_exists('wpcf7_contact_form')) {
          echo do_shortcode('[contact-form-7 id="78b2446" title="Contact form 1"]');
        } else { ?>
          <form class="gale-contact-form" method="post">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" placeholder="Your name" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" placeholder="your.email@example.com" required>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="tel" name="phone" placeholder="+91 98765 43210">
            </div>
            <div class="form-group">
              <label>Message</label>
              <input name="message" placeholder="Tell us how we can help..." rows="2"></input>
            </div>
            <button type="submit" class="btn-send">Send Message</button>
          </form>
        <?php } ?>
      </div>

    </div>
  </div>
</section>
<!-- CTA Banner -->
<section class="gale-cta-banner">
  <div class="container">
    <h2>Be a Part of the Change</h2>
    <p>Support sustainable livelihoods while choosing natural, high-quality products that make a real difference.</p>
    <div class="cta-buttons">
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-outline-white">Enquire Now</a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-outline-white">Partner With Us</a>
    </div>
    <p class="cta-tagline">Naturally Sourced. Socially Driven.</p>
  </div>
</section>

<?php get_footer(); ?>