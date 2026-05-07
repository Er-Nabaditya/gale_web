<?php
defined('ABSPATH') || exit;



function gale_assets()
{

	$css_files = array(
		'home',
		'header',
		'footer',
	);

	foreach ($css_files as $file) {

		wp_enqueue_style(
			'gale-' . $file,
			get_stylesheet_directory_uri() . '/assets/css/' . $file . '.css',
			array(),
			time()
		);
	}
}

add_action('wp_enqueue_scripts', 'gale_assets');
// ── Remove Parent Scripts ──────────────────────────
function understrap_remove_scripts()
{
	wp_dequeue_style('understrap-styles');
	wp_deregister_style('understrap-styles');
	wp_dequeue_script('understrap-scripts');
	wp_deregister_script('understrap-scripts');
}
add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);

// ── Enqueue Gale Styles & Scripts ─────────────────
function gale_enqueue_styles()
{
	$the_theme = wp_get_theme();

	// Parent theme CSS
	wp_enqueue_style(
		'understrap-styles',
		get_template_directory_uri() . '/css/child-theme.min.css',
		array(),
		$the_theme->get('Version')
	);

	// Child theme CSS (style.css)
	wp_enqueue_style(
		'gale-child-styles',
		get_stylesheet_directory_uri() . '/style.css',
		array('understrap-styles'),
		$the_theme->get('Version')
	);

	// Custom Gale CSS
	wp_enqueue_style(
		'gale-custom-styles',
		get_stylesheet_directory_uri() . '/assets/css/gale-custom.css',
		array('gale-child-styles'),
		'1.0.0'
	);

	// jQuery
	wp_enqueue_script('jquery');

	// Custom Gale JS
	wp_enqueue_script(
		'gale-custom-scripts',
		get_stylesheet_directory_uri() . '/assets/js/gale-custom.js',
		array('jquery'),
		'1.0.0',
		true
	);
}
add_action('wp_enqueue_scripts', 'gale_enqueue_styles');

// ── Bootstrap Version ─────────────────────────────
function understrap_default_bootstrap_version()
{
	return 'bootstrap5';
}
add_filter('theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20);

// ── Theme Setup ───────────────────────────────────
function gale_theme_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('woocommerce');
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');

	// Navigation menus
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'gale-livelihood-child'),
		'footer'  => __('Footer Menu', 'gale-livelihood-child'),
	));
}
add_action('after_setup_theme', 'gale_theme_setup');

// ── Text Domain ───────────────────────────────────
function add_child_theme_textdomain()
{
	load_child_theme_textdomain(
		'gale-livelihood-child',
		get_stylesheet_directory() . '/languages'
	);
}
add_action('after_setup_theme', 'add_child_theme_textdomain');

// ── ACF Fields Register ───────────────────────────
function gale_register_acf_fields()
{
	if (! function_exists('acf_add_local_field_group')) return;

	// Home Page Hero
	acf_add_local_field_group(array(
		'key'      => 'group_home_hero',
		'title'    => 'Home Hero Section',
		'fields'   => array(
			array(
				'key'   => 'field_hero_heading',
				'label' => 'Hero Heading',
				'name'  => 'hero_heading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_hero_subheading',
				'label' => 'Hero Subheading',
				'name'  => 'hero_subheading',
				'type'  => 'textarea',
			),
			array(
				'key'   => 'field_hero_cta_text',
				'label' => 'CTA Button Text',
				'name'  => 'hero_cta_text',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_hero_cta_link',
				'label' => 'CTA Button Link',
				'name'  => 'hero_cta_link',
				'type'  => 'url',
			),
			array(
				'key'   => 'field_hero_image',
				'label' => 'Hero Image',
				'name'  => 'hero_image',
				'type'  => 'image',
				'return_format' => 'url',
			),
			array(
				'key'   => 'field_hero_badge',
				'label' => 'Hero Badge Text',
				'name'  => 'hero_badge_text',
				'type'  => 'text',
			),
		),
		'location' => array(array(array(
			'param'    => 'page_template',
			'operator' => '==',
			'value'    => 'template-home.php',
		))),
	));

	// Mission Cards
	acf_add_local_field_group(array(
		'key'    => 'group_mission',
		'title'  => 'Mission Cards',
		'fields' => array(
			array(
				'key'        => 'field_mission_cards',
				'label'      => 'Mission Cards',
				'name'       => 'mission_cards',
				'type'       => 'repeater',
				'sub_fields' => array(
					array(
						'key'   => 'field_card_icon',
						'label' => 'Icon (emoji or text)',
						'name'  => 'card_icon',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_card_title',
						'label' => 'Card Title',
						'name'  => 'card_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_card_desc',
						'label' => 'Card Description',
						'name'  => 'card_desc',
						'type'  => 'textarea',
					),
				),
			),
		),
		'location' => array(array(array(
			'param'    => 'page_template',
			'operator' => '==',
			'value'    => 'template-home.php',
		))),
	));

	// Product Extra Fields
	acf_add_local_field_group(array(
		'key'    => 'group_product_extra',
		'title'  => 'Product Extra Details',
		'fields' => array(
			array(
				'key'   => 'field_cultivation',
				'label' => 'Cultivation Info',
				'name'  => 'cultivation_info',
				'type'  => 'textarea',
			),
			array(
				'key'        => 'field_health_benefits',
				'label'      => 'Health Benefits',
				'name'       => 'health_benefits',
				'type'       => 'repeater',
				'sub_fields' => array(
					array(
						'key'   => 'field_benefit_text',
						'label' => 'Benefit',
						'name'  => 'benefit_text',
						'type'  => 'text',
					),
				),
			),
			array(
				'key'   => 'field_nutrition_energy',
				'label' => 'Energy (kcal)',
				'name'  => 'nutrition_energy',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_nutrition_fat',
				'label' => 'Fat (g)',
				'name'  => 'nutrition_fat',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_nutrition_protein',
				'label' => 'Protein (g)',
				'name'  => 'nutrition_protein',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_nutrition_carbs',
				'label' => 'Carbohydrates (g)',
				'name'  => 'nutrition_carbs',
				'type'  => 'text',
			),
		),
		'location' => array(array(array(
			'param'    => 'post_type',
			'operator' => '==',
			'value'    => 'product',
		))),
	));
}
add_action('acf/init', 'gale_register_acf_fields');

// ── WooCommerce Cart Count ────────────────────────
function gale_cart_count()
{
	if (function_exists('WC')) {
		return WC()->cart->get_cart_contents_count();
	}
	return 0;
}

// ── Remove WooCommerce Default Styles ─────────────
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
