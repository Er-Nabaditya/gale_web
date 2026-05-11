
<?php

get_header();
?>

<!-- ════════════════════════════════════════════
     PAGE CONTENT
════════════════════════════════════════════ -->
<div class="page">
 
  <!-- Breadcrumb -->
  <nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="#">Home</a>
    <span class="breadcrumb__sep">›</span>
    <span>Products</span>
  </nav>
 
  <!-- Page Hero -->
  <div class="page-hero">
    <h1>Our Products</h1>
    <p>Naturally sourced, traditionally processed, and ethically produced. Each product represents our commitment to quality and sustainability.</p>
  </div>
 
  <!-- ── PRODUCT GRID ─────────────────────────── -->
  <section class="products" aria-label="Product listing">
    <div class="products__grid">
 
      <!-- ── CARD 1: Cashew Nuts ── -->
      <article class="card">
        <div class="card__img-wrap">
          <!-- Replace src with your actual image path -->
          <img
            src="http://Gale-livelihood.local/wp-content/uploads/2026/05/Container.png"
            alt="Cashew Nuts"
            loading="lazy"
          />
        </div>
        <div class="card__body">
          <h2 class="card__title">Cashew Nuts</h2>
          <p class="card__desc">Hand-processed cashews, rich in nutrients and clinically delicious.</p>
          <ul class="card__features">
            <li>Traditional Cultivation</li>
            <li>Versatile and Delicious</li>
            <li>Superior Quality</li>
            <li>Versatile and Delicious</li>
          </ul>
          <div class="card__footer">
            <div class="card__price">₹450.00 <sub>/ 500g</sub></div>
            <button class="card__btn">Buy Now</button>
          </div>
        </div>
      </article>
 
      <!-- ── CARD 2: Ground Nut Oil ── -->
      <article class="card">
        <div class="card__img-wrap">
          <img
            src="http://Gale-livelihood.local/wp-content/uploads/2026/05/Container-3.png"
            alt="Ground Nut Oil"
            loading="lazy"
          />
        </div>
        <div class="card__body">
          <h2 class="card__title">Ground Nut Oil</h2>
          <p class="card__desc">From the farms of Marmad, we present to you naturally grown and sun-dried.</p>
          <ul class="card__features">
            <li>Unprocessed</li>
            <li>High in Vitamin E</li>
            <li>Free of Pesticides</li>
            <li>Trans Fat Free</li>
          </ul>
          <div class="card__footer">
            <div class="card__price">₹450.00 <sub>/ 500g</sub></div>
            <button class="card__btn">Buy Now</button>
          </div>
        </div>
      </article>
 
      <!-- ── CARD 3: Wada Kolam Rice ── -->
      <article class="card">
        <div class="card__img-wrap">
          <img
            src="http://Gale-livelihood.local/wp-content/uploads/2026/05/Container-5.png"
            alt="Wada Kolam Rice"
            loading="lazy"
          />
        </div>
        <div class="card__body">
          <h2 class="card__title">Wada Kolam Rice</h2>
          <p class="card__desc">Naturally delicious, hand-processed cashews, rich in nutrients.</p>
          <ul class="card__features">
            <li>Superior Quality</li>
            <li>Nutritional Benefits</li>
            <li>Aromatic and Flavorful</li>
            <li>Versatility in Cooking</li>
          </ul>
          <div class="card__footer">
            <div class="card__price">₹450.00 <sub>/ 500g</sub></div>
            <button class="card__btn">Buy Now</button>
          </div>
        </div>
      </article>
 
      <!-- ── CARD 4: Pattravali Plates ── -->
      <article class="card">
        <div class="card__img-wrap">
          <img
            src="http://Gale-livelihood.local/wp-content/uploads/2026/05/Container-6.png"
            alt="Pattravali Plates"
            loading="lazy"
          />
        </div>
        <div class="card__body">
          <h2 class="card__title">Pattravali Plates</h2>
          <p class="card__desc">Pattravali Plates are a testament to sustainable living and eco-conscious.</p>
          <ul class="card__features">
            <li>Reduce your environmental impact</li>
            <li>Made from naturally fallen leaves</li>
            <li>Convenience in disposable plates</li>
            <li>Harmony of nature</li>
          </ul>
          <div class="card__footer">
            <div class="card__price">₹450.00 <sub>/ 500g</sub></div>
            <button class="card__btn">Buy Now</button>
          </div>
        </div>
      </article>
 
    </div><!-- .products__grid -->
  </section>
 
</div><!-- .page -->
 
 
<!-- ════════════════════════════════════════════
     CAN'T FIND CTA
════════════════════════════════════════════ -->
<section class="cta-strip">
  <div class="cta-strip__icon" aria-hidden="true">
  </div>
  <h2>Can't Find What You're Looking For?</h2>
  <p>We work with local farmers to source a variety of natural products. Get in touch to discuss your requirements.</p>
  <a href="#" class="cta-strip__btn">Contact Us</a>
</section>
 
 
 
<?php
get_footer();
?>