<?php

/**
 * Lost Password Form - Gale Livelihood Centre Custom Design
 * Overrides: woocommerce/templates/myaccount/form-lost-password.php
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form'); ?>

<div class="gale-auth-wrap">

  <div class="gale-logo-wrap">
    <?php
    $logo_id = get_theme_mod('custom_logo');
    if ($logo_id) {
      echo get_custom_logo();
    } else { ?>
      <div class="gale-logo-placeholder">G</div>
    <?php } ?>
  </div>

  <div class="gale-page-title"><?php esc_html_e('Forgot Password?', 'woocommerce'); ?></div>
  <div class="gale-page-subtitle"><?php esc_html_e('Enter your email to receive a reset link', 'woocommerce'); ?></div>

  <div class="gale-card">

    <form method="post" class="woocommerce-ResetPassword lost_reset_password">

      <div class="gale-field-group">
        <label class="gale-label" for="user_login">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="2" />
            <path d="M2 8l10 6 10-6" />
          </svg>
          <?php esc_html_e('Email Address', 'woocommerce'); ?>
        </label>
        <div class="gale-input-wrap">
          <input class="woocommerce-Input woocommerce-Input--text input-text gale-input"
            type="text" name="user_login" id="user_login" autocomplete="username email"
            placeholder="you@example.com" />
        </div>
      </div>

      <div class="gale-submit-wrap">
        <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
        <input type="hidden" name="redirect" value="" />
        <button type="submit" class="woocommerce-Button button gale-btn" value="<?php esc_attr_e('Reset password', 'woocommerce'); ?>">
          <?php esc_html_e('Send Reset Link', 'woocommerce'); ?>
        </button>
      </div>

    </form>

    <div class="gale-switch-link">
      <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
        ← <?php esc_html_e('Back to Sign In', 'woocommerce'); ?>
      </a>
    </div>

  </div>

</div>

<?php do_action('woocommerce_after_lost_password_form'); ?>