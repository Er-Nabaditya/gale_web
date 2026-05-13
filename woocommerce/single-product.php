<?php

/**
 * Template Name: Single Product
 * Template Post Type: product
 */
get_header();

$post_id         = get_the_ID();
$product         = wc_get_product($post_id);
$title           = get_the_title();
$excerpt         = $product ? $product->get_short_description() : '';
$description     = get_the_content();
$price_html      = $product ? $product->get_price_html() : '';
$cart_url        = $product ? esc_url($product->add_to_cart_url()) : '#';
$gallery_ids     = $product ? $product->get_gallery_image_ids() : array();
$thumb_id        = get_post_thumbnail_id($post_id);
$thumb_url       = get_the_post_thumbnail_url($post_id, 'large');

// ACF Fields
$health_benefits   = get_field('health_benefits', $post_id);       // repeater or textarea
$cultivation_text  = get_field('cultivation_text', $post_id);
$weight_options    = get_field('weight_options', $post_id);         // e.g. "250g, 500g, 1kg"
$nutritional_value = get_field('nutritional_value', $post_id);     // array/repeater

// Feature badges (ACF or fallback)
$features = get_field('feature_badges', $post_id);
if (empty($features)) {
    $features = array(
        array('icon' => 'leaf',    'label' => '100% Natural',      'sublabel' => 'Chemical-free processing'),
        array('icon' => 'hand',    'label' => 'Hand Processed',    'sublabel' => 'By skilled tribal workers'),
        array('icon' => 'heart',   'label' => 'Rich in Nutrients', 'sublabel' => 'Vitamins & minerals'),
        array('icon' => 'farmer',  'label' => 'Supports Farmers',  'sublabel' => 'Direct from tribal community'),
    );
}
?>

<style>
    /* ──────────────────────────────────────────────
   CSS VARIABLES
────────────────────────────────────────────── */
    :root {
        --green-dark: #2d5016;
        --green-mid: #4a7c2a;
        --green-light: #6aaa3a;
        --green-pale: #e8f5e0;
        --green-bg: #f4f9ef;
        --text-dark: #1a2010;
        --text-mid: #3d4a30;
        --text-muted: #7a8a6a;
        --border: #d4e6c0;
        --white: #ffffff;
        --price-color: #1a2010;
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --shadow-sm: 0 1px 4px rgba(0, 0, 0, .07);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, .10);
        --font-head: 'Playfair Display', Georgia, serif;
        --font-body: 'Lato', 'Helvetica Neue', sans-serif;
    }

    /* ──────────────────────────────────────────────
   RESET / BASE
────────────────────────────────────────────── */
    .sp-wrap *,
    .sp-wrap *::before,
    .sp-wrap *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .sp-wrap {
        font-family: var(--font-body);
        color: var(--text-dark);
        background: var(--white);
        font-size: 15px;
        line-height: 1.65;
    }

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

    /* ──────────────────────────────────────────────
   BREADCRUMB
────────────────────────────────────────────── */
    .sp-breadcrumb {
        padding: 14px 0 10px;
        font-size: 16px;
        color: #4A7C59;
    }

    .sp-breadcrumb a {
        color: var(--green-mid);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color .2s;
    }

    .sp-breadcrumb a:hover {
        color: var(--green-dark);
    }

    .sp-breadcrumb svg {
        width: 14px;
        height: 14px;
    }

    /* ──────────────────────────────────────────────
   HERO SECTION  (image + info side-by-side)
────────────────────────────────────────────── */
    .sp-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        padding: 20px 0 40px;
        align-items: start;
    }

    /* -- Gallery column -- */
    .sp-gallery__main {
        border-radius: var(--radius-lg);
        overflow: hidden;
        background: var(--green-bg);
        aspect-ratio: 1 / 1;
    }

    .sp-gallery__main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .sp-gallery__main:hover img {
        transform: scale(1.03);
    }

    .sp-gallery__thumbs {
        display: flex;
        gap: 10px;
        margin-top: 12px;
    }

    .sp-gallery__thumb {
        width: 72px;
        height: 72px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        background: var(--green-bg);
        transition: border-color .2s;
        flex-shrink: 0;
    }

    .sp-gallery__thumb.is-active,
    .sp-gallery__thumb:hover {
        border-color: var(--green-light);
    }

    .sp-gallery__thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* -- Info column -- */
    .sp-info {}

    .sp-info__tagline {
        font-size: 13px;
        color: var(--text-muted);
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .sp-info__title {
        font-family: var(--font-head);
        font-size: clamp(26px, 3.5vw, 38px);
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.2;
        margin-bottom: 12px;
    }

    .sp-info__price {
        font-size: 24px;
        font-weight: 700;
        color: var(--price-color);
        margin-bottom: 4px;
    }

    .sp-info__price sub {
        font-size: 14px;
        font-weight: 400;
        color: var(--text-muted);
        vertical-align: baseline;
    }

    .sp-info__desc {
        font-size: 14px;
        color: var(--text-mid);
        margin: 16px 0 20px;
        line-height: 1.7;
    }

    /* Weight options */
    .sp-weight-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 8px;
    }

    .sp-weight-options {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .sp-weight-btn {
        padding: 6px 16px;
        border-radius: 20px;
        border: 1px solid var(--border);
        background: var(--white);
        font-size: 13px;
        font-family: var(--font-body);
        color: var(--text-mid);
        cursor: pointer;
        transition: all .2s;
    }

    .sp-weight-btn.is-active,
    .sp-weight-btn:hover {
        background: var(--green-dark);
        color: var(--white);
        border-color: var(--green-dark);
    }

    /* Quantity */
    .sp-qty-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 8px;
    }

    .sp-qty {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 22px;
        width: fit-content;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        overflow: hidden;
    }

    .sp-qty__btn {
        width: 36px;
        height: 36px;
        background: var(--green-bg);
        border: none;
        font-size: 18px;
        color: var(--text-mid);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
        font-family: var(--font-body);
    }

    .sp-qty__btn:hover {
        background: var(--border);
    }

    .sp-qty__input {
        width: 46px;
        height: 36px;
        border: none;
        border-left: 1px solid var(--border);
        border-right: 1px solid var(--border);
        text-align: center;
        font-size: 15px;
        font-family: var(--font-body);
        color: var(--text-dark);
        background: var(--white);
        -moz-appearance: textfield;
    }

    .sp-qty__input::-webkit-outer-spin-button,
    .sp-qty__input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    /* CTA button */
    .sp-buy-btn {
        display: inline-block;
        padding: 14px 40px;
        background: var(--green-dark);
        color: var(--white);
        border-radius: var(--radius-sm);
        font-size: 15px;
        font-weight: 600;
        letter-spacing: .03em;
        border: none;
        cursor: pointer;
        transition: background .2s, transform .15s;
        text-align: center;
        width: 100%;
        max-width: 260px;
    }

    .sp-buy-btn:hover {
        background: var(--green-mid);
        transform: translateY(-1px);
    }

    /* ──────────────────────────────────────────────
   FEATURE BADGES
────────────────────────────────────────────── */
    .sp-badges {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--border);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
        margin: 0 0 48px;
    }

    .sp-badge {
        background: var(--white);
        padding: 24px 16px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .sp-badge__icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--green-mid);
    }

    .sp-badge__icon svg {
        width: 28px;
        height: 28px;
    }

    .sp-badge__label {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .sp-badge__sub {
        font-size: 12px;
        color: var(--text-muted);
        line-height: 1.4;
    }

    /* ──────────────────────────────────────────────
   SECTION HEADERS
────────────────────────────────────────────── */
    .sp-section {
        margin-bottom: 44px;
    }

    .sp-section__title {
        font-family: var(--font-head);
        font-size: 22px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--green-pale);
    }

    /* ──────────────────────────────────────────────
   CULTIVATION
────────────────────────────────────────────── */
    .sp-cultivation__box {
        background: var(--green-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 20px 24px;
        font-size: 14px;
        color: var(--text-mid);
        line-height: 1.75;
        border-left: 4px solid var(--green-light);
    }

    /* ──────────────────────────────────────────────
   HEALTH BENEFITS
────────────────────────────────────────────── */
    .sp-benefits__grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 24px;
    }

    .sp-benefit-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 14px;
        color: var(--text-mid);
        padding: 8px 0;
    }

    .sp-benefit-item::before {
        content: '';
        width: 18px;
        height: 18px;
        min-width: 18px;
        background: var(--green-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 2px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='white' d='M13 4L6.5 11 3 7.5' stroke='white' stroke-width='1.8' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 12px 12px;
    }

    /* ──────────────────────────────────────────────
   NUTRITIONAL VALUE
────────────────────────────────────────────── */
    .sp-nutrition__grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: var(--border);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .sp-nutrition__cell {
        background: var(--white);
        padding: 18px 20px;
    }

    .sp-nutrition__cell-label {
        font-size: 12px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 4px;
    }

    .sp-nutrition__cell-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
    }

    /* ──────────────────────────────────────────────
   CTA STRIP (Be a Part of the Change)
────────────────────────────────────────────── */
    .sp-cta-strip {
        background: var(--green-dark);
        border-radius: var(--radius-lg);
        padding: 48px 32px;
        text-align: center;
        color: var(--white);
        margin: 0 0 60px;
        position: relative;
        overflow: hidden;
    }

    .sp-cta-strip::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Ccircle cx='30' cy='30' r='28' stroke='rgba(255,255,255,.05)' stroke-width='1' fill='none'/%3E%3C/svg%3E") repeat;
        opacity: .4;
        pointer-events: none;
    }

    .sp-cta-strip h2 {
        font-family: var(--font-head);
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        position: relative;
    }

    .sp-cta-strip p {
        font-size: 14px;
        color: rgba(255, 255, 255, .8);
        max-width: 440px;
        margin: 0 auto 24px;
        position: relative;
    }

    .sp-cta-strip__btns {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
    }

    .sp-cta-btn {
        padding: 11px 28px;
        border-radius: var(--radius-sm);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid var(--white);
        transition: all .2s;
        font-family: var(--font-body);
        letter-spacing: .02em;
    }

    .sp-cta-btn--outline {
        background: transparent;
        color: var(--white);
    }

    .sp-cta-btn--outline:hover {
        background: rgba(255, 255, 255, .12);
    }

    .sp-cta-btn--solid {
        background: var(--white);
        color: var(--green-dark);
        border-color: var(--white);
    }

    .sp-cta-btn--solid:hover {
        background: var(--green-pale);
    }

    /* ──────────────────────────────────────────────
   RESPONSIVE
────────────────────────────────────────────── */
    @media (max-width: 768px) {
        .sp-hero {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .sp-badges {
            grid-template-columns: repeat(2, 1fr);
        }

        .sp-benefits__grid {
            grid-template-columns: 1fr;
        }

        .sp-nutrition__grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .sp-badges {
            grid-template-columns: 1fr 1fr;
        }

        .sp-nutrition__grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@400;600;700&display=swap" rel="stylesheet">

<div class="sp-wrap">
    <div class="sp-container">

        <!-- Breadcrumb -->
        <nav class="sp-breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Back to Home
            </a>
        </nav>

        <!-- HERO: Image + Info -->
        <div class="sp-hero">

            <!-- Gallery -->
            <div class="sp-gallery">
                <div class="sp-gallery__main" id="sp-main-img-wrap">
                    <?php if ($thumb_url) : ?>
                        <img
                            src="<?php echo esc_url($thumb_url); ?>"
                            alt="<?php echo esc_attr($title); ?>"
                            id="sp-main-img" />
                    <?php else : ?>
                        <div class="card__img-placeholder" style="width:100%;height:100%;background:var(--green-bg);"></div>
                    <?php endif; ?>
                </div>

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

                <?php if ($description) : ?>
                    <p class="sp-info__desc"><?php echo wp_kses_post($description); ?></p>
                <?php endif; ?>

                <!-- Weight options -->

                <div>
                    <p class="sp-weight-label">Available in 250g, 500g, and 1kg packs</p>
                </div>


                <!-- Quantity -->
                <p class="sp-qty-label">Quantity</p>
                <div class="sp-qty">
                    <button class="sp-qty__btn" onclick="spQty(-1)" aria-label="Decrease quantity">−</button>
                    <input class="sp-qty__input" type="number" id="sp-qty" value="1" min="1" max="99" readonly />
                    <button class="sp-qty__btn" onclick="spQty(1)" aria-label="Increase quantity">+</button>
                </div>

                <a href="<?php echo $cart_url; ?>" class="sp-buy-btn">Buy Now</a>
            </div>
        </div>

        <!-- FEATURE BADGES -->
        <div class="sp-badges">
            <!-- Leaf / Natural -->
            <div class="sp-badge">
                <div class="sp-badge__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z" />
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                    </svg>
                </div>
                <p class="sp-badge__label">100% Natural</p>
                <p class="sp-badge__sub">Chemical-free processing</p>
            </div>

            <!-- Hand -->
            <div class="sp-badge">
                <div class="sp-badge__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0" />
                        <path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2" />
                        <path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8" />
                        <path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15" />
                    </svg>
                </div>
                <p class="sp-badge__label">Hand Processed</p>
                <p class="sp-badge__sub">By skilled tribal workers</p>
            </div>

            <!-- Heart / Nutrients -->
            <div class="sp-badge">
                <div class="sp-badge__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                    </svg>
                </div>
                <p class="sp-badge__label">Rich in Nutrients</p>
                <p class="sp-badge__sub">Vitamins &amp; minerals</p>
            </div>

            <!-- Farmer / Community -->
            <div class="sp-badge">
                <div class="sp-badge__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <p class="sp-badge__label">Supports Farmers</p>
                <p class="sp-badge__sub">Direct from tribal community</p>
            </div>
        </div>

        <!-- CULTIVATION -->
        <?php if ($cultivation_text) : ?>
            <section class="sp-section">
                <h2 class="sp-section__title">Cultivation</h2>
                <div class="sp-cultivation__box">
                    <?php echo wp_kses_post($cultivation_text); ?>
                </div>
            </section>
        <?php else : ?>
            <section class="sp-section">
                <h2 class="sp-section__title">Cultivation</h2>
                <div class="sp-cultivation__box">
                    <?php echo wp_kses_post($description); ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- HEALTH BENEFITS -->
        <?php if (! empty($health_benefits)) : ?>
            <section class="sp-section">
                <h2 class="sp-section__title">Health Benefits</h2>
                <div class="sp-benefits__grid">
                    <?php
                    if (is_array($health_benefits)) {
                        // ACF repeater field
                        foreach ($health_benefits as $benefit) :
                            $text = is_array($benefit) ? reset($benefit) : $benefit;
                    ?>
                            <div class="sp-benefit-item"><?php echo esc_html($text); ?></div>
                            <?php
                        endforeach;
                    } else {
                        // Plain textarea with line breaks or <li> items
                        $lines = preg_split('/<li[^>]*>|<\/li>|\n/', strip_tags($health_benefits, '<li>'));
                        foreach (array_filter(array_map('strip_tags', $lines)) as $line) :
                            $line = trim($line);
                            if ($line) :
                            ?>
                                <div class="sp-benefit-item"><?php echo esc_html($line); ?></div>
                    <?php
                            endif;
                        endforeach;
                    }
                    ?>
                </div>
            </section>
        <?php endif; ?>

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

    <!-- CTA STRIP -->
    <div class="sp-container">
        <div class="sp-cta-strip">
            <h2>Be a Part of the Change</h2>
            <p>Support sustainable livelihoods while choosing natural products. Every purchase makes a difference.</p>
            <div class="sp-cta-strip__btns">
                <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="sp-cta-btn sp-cta-btn--outline">Enquire Now</a>
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="sp-cta-btn sp-cta-btn--solid">View All Products</a>
            </div>
        </div>
    </div>

</div><!-- /.sp-wrap -->

<script>
    /* Gallery switcher */
    function spSwitchImg(thumb) {
        var thumbs = document.querySelectorAll('.sp-gallery__thumb');
        thumbs.forEach(function(t) {
            t.classList.remove('is-active');
        });
        thumb.classList.add('is-active');
        var main = document.getElementById('sp-main-img');
        if (main) main.src = thumb.dataset.full;
    }

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