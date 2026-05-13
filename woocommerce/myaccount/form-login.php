<?php

/**
 * Login Form - Gale Livelihood Centre Custom Design
 * Overrides: woocommerce/templates/myaccount/form-login.php
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_customer_login_form'); ?>

<div class="gale-auth-wrap">

  <!-- LOGO -->
  <div class="gale-logo-wrap">
    <?php
    $logo_id = get_theme_mod('custom_logo');
    if ($logo_id) {
      echo get_custom_logo();
    } else { ?>
      <div class="gale-logo-placeholder">G</div>
    <?php } ?>
  </div>

  <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    <!-- TAB SWITCHER -->
    <div class="gale-tab-switcher">
      <button class="gale-tab active" data-tab="login"><?php esc_html_e('Sign In', 'woocommerce'); ?></button>
      <button class="gale-tab" data-tab="register"><?php esc_html_e('Create Account', 'woocommerce'); ?></button>
    </div>

  <?php endif; ?>

  <!-- ===== LOGIN FORM ===== -->
  <div class="gale-tab-content active" id="gale-tab-login">

    <div class="gale-page-title"><?php esc_html_e('Welcome Back', 'woocommerce'); ?></div>
    <div class="gale-page-subtitle"><?php esc_html_e('Sign in to continue your journey', 'woocommerce'); ?></div>

    <div class="gale-card">

      <form class="woocommerce-form woocommerce-form-login login" method="post">

        <?php do_action('woocommerce_login_form_start'); ?>

        <!-- Email -->
        <div class="gale-field-group">
          <label class="gale-label" for="username">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="4" width="20" height="16" rx="2" />
              <path d="M2 8l10 6 10-6" />
            </svg>
            <?php esc_html_e('Email Address', 'woocommerce'); ?>
          </label>
          <div class="gale-input-wrap">
            <input class="woocommerce-Input woocommerce-Input--text input-text gale-input"
              type="text"
              name="username"
              id="username"
              autocomplete="username email"
              placeholder="you@example.com"
              value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
          </div>
        </div>

        <!-- Password -->
        <div class="gale-field-group">
          <label class="gale-label" for="password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="11" width="18" height="11" rx="2" />
              <path d="M7 11V7a5 5 0 0110 0v4" />
            </svg>
            <?php esc_html_e('Password', 'woocommerce'); ?>
          </label>
          <div class="gale-input-wrap gale-pass-wrap">
            <input class="woocommerce-Input woocommerce-Input--text input-text gale-input"
              type="password"
              name="password"
              id="password"
              autocomplete="current-password"
              placeholder="<?php esc_attr_e('Enter your password', 'woocommerce'); ?>" />
            <button type="button" class="gale-eye-btn" onclick="galeTogglePass('password', this)" aria-label="Toggle password">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
              </svg>
            </button>
          </div>
        </div>

        <?php do_action('woocommerce_login_form'); ?>

        <!-- Remember + Forgot -->
        <div class="gale-meta-row">
          <label class="gale-remember">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
            <?php esc_html_e('Remember me', 'woocommerce'); ?>
          </label>
          <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="gale-forgot-link">
            <?php esc_html_e('Forgot password?', 'woocommerce'); ?>
          </a>
        </div>

        <div class="gale-submit-wrap">
          <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
          <button type="submit" class="woocommerce-button button woocommerce-form-login__submit gale-btn" name="login" value="<?php esc_attr_e('Sign in', 'woocommerce'); ?>">
            <?php esc_html_e('Sign In', 'woocommerce'); ?>
          </button>
        </div>

        <?php do_action('woocommerce_login_form_end'); ?>

      </form>

      <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
        <div class="gale-switch-link">
          <?php esc_html_e("Don't have an account?", 'woocommerce'); ?>
          <a href="#" class="gale-switch-tab" data-tab="register"><?php esc_html_e('Sign up', 'woocommerce'); ?></a>
        </div>
      <?php endif; ?>

    </div><!-- .gale-card -->

    <!-- Social Login (Nextend) -->
    <?php if (class_exists('NextendSocialLogin')) : ?>
      <div class="gale-or-divider"><span><?php esc_html_e('Or continue with', 'woocommerce'); ?></span></div>
      <div class="gale-social-wrap">
        <?php do_action('wordpress_social_login'); ?>
      </div>
    <?php endif; ?>

  </div><!-- #gale-tab-login -->


  <!-- ===== REGISTER FORM ===== -->
  <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

    <div class="gale-tab-content" id="gale-tab-register">

      <div class="gale-page-title"><?php esc_html_e('Create Account', 'woocommerce'); ?></div>
      <div class="gale-page-subtitle"><?php esc_html_e('Join us in making a difference', 'woocommerce'); ?></div>

      <div class="gale-card">

        <form method="post" class="woocommerce-form woocommerce-form-register register">

          <?php do_action('woocommerce_register_form_start'); ?>

          <!-- Full Name (billing first + last) -->
          <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
            <div class="gale-field-group">
              <label class="gale-label" for="reg_username">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="8" r="4" />
                  <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
                <?php esc_html_e('Username', 'woocommerce'); ?>
              </label>
              <div class="gale-input-wrap">
                <input class="woocommerce-Input woocommerce-Input--text input-text gale-input"
                  type="text" name="username" id="reg_username" autocomplete="username"
                  placeholder="johndoe"
                  value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
              </div>
            </div>
          <?php endif; ?>

          <!-- Email -->
          <div class="gale-field-group">
            <label class="gale-label" for="reg_email">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="4" width="20" height="16" rx="2" />
                <path d="M2 8l10 6 10-6" />
              </svg>
              <?php esc_html_e('Email Address', 'woocommerce'); ?>
            </label>
            <div class="gale-input-wrap">
              <input class="woocommerce-Input woocommerce-Input--text input-text gale-input"
                type="email" name="email" id="reg_email" autocomplete="email"
                placeholder="you@example.com"
                value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" />
            </div>
          </div>

          <!-- Password -->
          <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
            <div class="gale-field-group">
              <label class="gale-label" for="reg_password">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2" />
                  <path d="M7 11V7a5 5 0 0110 0v4" />
                </svg>
                <?php esc_html_e('Password', 'woocommerce'); ?>
              </label>
              <div class="gale-input-wrap gale-pass-wrap">
                <input class="woocommerce-Input woocommerce-Input--text input-text gale-input"
                  type="password" name="password" id="reg_password" autocomplete="new-password"
                  placeholder="<?php esc_attr_e('Create a strong password', 'woocommerce'); ?>" />
                <button type="button" class="gale-eye-btn" onclick="galeTogglePass('reg_password', this)" aria-label="Toggle password">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                    <circle cx="12" cy="12" r="3" />
                  </svg>
                </button>
              </div>
              <!-- Password Strength Bar -->
              <div class="gale-strength-bar">
                <span id="gs1"></span><span id="gs2"></span><span id="gs3"></span><span id="gs4"></span>
              </div>
              <div class="gale-strength-label" id="gale-strength-label"></div>
            </div>
          <?php endif; ?>

          <?php do_action('woocommerce_register_form'); ?>

          <div class="gale-submit-wrap">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit gale-btn" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
              <?php esc_html_e('Create Account', 'woocommerce'); ?>
            </button>
          </div>

          <?php do_action('woocommerce_register_form_end'); ?>

        </form>

        <div class="gale-switch-link">
          <?php esc_html_e('Already have an account?', 'woocommerce'); ?>
          <a href="#" class="gale-switch-tab" data-tab="login"><?php esc_html_e('Sign in', 'woocommerce'); ?></a>
        </div>

      </div><!-- .gale-card -->

      <!-- Social Login -->
      <?php if (class_exists('NextendSocialLogin')) : ?>
        <div class="gale-or-divider"><span><?php esc_html_e('Or sign up with', 'woocommerce'); ?></span></div>
        <div class="gale-social-wrap">
          <?php do_action('wordpress_social_login'); ?>
        </div>
      <?php endif; ?>

    </div><!-- #gale-tab-register -->

  <?php endif; ?>

</div><!-- .gale-auth-wrap -->

<?php do_action('woocommerce_after_customer_login_form'); ?>

<script>
  function galeTogglePass(id, btn) {
    var inp = document.getElementById(id);
    var isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    btn.querySelector('svg').innerHTML = isPass ?
      '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23" stroke-width="2"/>' :
      '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }

  // Tab switcher
  document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.gale-tab');
    var contents = document.querySelectorAll('.gale-tab-content');
    var switchLinks = document.querySelectorAll('.gale-switch-tab');

    function switchTab(tabName) {
      tabs.forEach(function(t) {
        t.classList.toggle('active', t.dataset.tab === tabName);
      });
      contents.forEach(function(c) {
        c.classList.toggle('active', c.id === 'gale-tab-' + tabName);
      });
    }

    tabs.forEach(function(tab) {
      tab.addEventListener('click', function() {
        switchTab(this.dataset.tab);
      });
    });

    switchLinks.forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        switchTab(this.dataset.tab);
      });
    });

    // Password strength
    var passInput = document.getElementById('reg_password');
    if (passInput) {
      passInput.addEventListener('input', function() {
        var val = this.value;
        var score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        var colors = ['', '#e74c3c', '#e67e22', '#f1c40f', '#27ae60'];
        var labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
        for (var i = 1; i <= 4; i++) {
          var el = document.getElementById('gs' + i);
          if (el) el.style.background = i <= score ? colors[score] : '#ddd';
        }
        var lbl = document.getElementById('gale-strength-label');
        if (lbl) {
          lbl.textContent = val.length ? labels[score] : '';
          lbl.style.color = colors[score];
        }
      });
    }

    // Check URL hash for tab
    if (window.location.hash === '#register') switchTab('register');
  });
</script>