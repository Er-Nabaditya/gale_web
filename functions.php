<?php

defined('ABSPATH') || exit;
// require '/wp-content/themes/understrap-child-1.2.0/inc/woocommerce_products.php';

function understrap_remove_scripts()
{
	wp_dequeue_style('understrap-styles');
	wp_deregister_style('understrap-styles');
	wp_dequeue_script('understrap-scripts');
	wp_deregister_script('understrap-scripts');
}
add_action('wp_enqueue_scripts', 'understrap_remove_scripts', 20);

function gale_enqueue_styles()
{
	$ver = wp_get_theme()->get('Version');

	wp_enqueue_style(
		'understrap-parent',
		get_template_directory_uri() . '/css/child-theme.min.css',
		array(),
		$ver
	);
	wp_enqueue_style(
		'gale-style',
		get_stylesheet_directory_uri() . '/style.css',
		array('understrap-parent'),
		$ver
	);
	wp_enqueue_style(
		'gale-header-css',
		get_stylesheet_directory_uri() . '/css/header.css',
		array('gale-style'),
		'1.0.0'
	);
	wp_enqueue_style(
		'gale-home-css',
		get_stylesheet_directory_uri() . '/css/home.css',
		array('gale-style'),
		'1.0.0'
	);
	wp_enqueue_style(
		'gale-product-css',
		get_stylesheet_directory_uri() . '/css/product.css',
		array('gale-style'),
		'1.0.0'
	);
	wp_enqueue_style(
		'gale-footer-css',
		get_stylesheet_directory_uri() . '/css/footer.css',
		array('gale-style'),
		'1.0.0'
	);

	wp_enqueue_style(
		'gale-google-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_script('jquery');
	wp_enqueue_script(
		'gale-js',
		get_stylesheet_directory_uri() . '/js/gale-custom.js',
		array('jquery'),
		'1.0.0',
		true
	);
}
add_action('wp_enqueue_scripts', 'gale_enqueue_styles');

function understrap_default_bootstrap_version()
{
	return 'bootstrap5';
}
add_filter('theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20);

function gale_theme_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('woocommerce');
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
	register_nav_menus(array(
		'primary' => 'Primary Menu',
		'footer'  => 'Footer Menu',
	));
}
add_action('after_setup_theme', 'gale_theme_setup');

function add_child_theme_textdomain()
{
	load_child_theme_textdomain(
		'gale-livelihood-child',
		get_stylesheet_directory() . '/languages'
	);
}
add_action('after_setup_theme', 'add_child_theme_textdomain');

function gale_register_acf_fields()
{
	if (! function_exists('acf_add_local_field_group')) return;

	acf_add_local_field_group(array(
		'key'   => 'group_home_hero',
		'title' => 'Home Hero Section',
		'fields' => array(
			array('key' => 'field_hero_heading',    'label' => 'Hero Heading',     'name' => 'hero_heading',    'type' => 'text'),
			array('key' => 'field_hero_subheading', 'label' => 'Hero Subheading',  'name' => 'hero_subheading', 'type' => 'textarea'),
			array('key' => 'field_hero_cta_text',   'label' => 'CTA Button Text',  'name' => 'hero_cta_text',   'type' => 'text'),
			array('key' => 'field_hero_cta_link',   'label' => 'CTA Button Link',  'name' => 'hero_cta_link',   'type' => 'url'),
			array('key' => 'field_hero_image',      'label' => 'Hero Image',       'name' => 'hero_image',      'type' => 'image', 'return_format' => 'url'),
			array('key' => 'field_hero_badge',      'label' => 'Hero Badge Text',  'name' => 'hero_badge_text', 'type' => 'text'),
			array('key' => 'field_who_image',       'label' => 'Who Are We Image', 'name' => 'who_image',       'type' => 'image', 'return_format' => 'url'),
			array('key' => 'field_who_desc',        'label' => 'Who Description',  'name' => 'who_description', 'type' => 'textarea'),
		),
		'location' => array(array(array(
			'param' => 'page_template',
			'operator' => '==',
			'value' => 'front-page.php',
		))),
	));

	acf_add_local_field_group(array(
		'key'    => 'group_mission',
		'title'  => 'Mission Cards',
		'fields' => array(
			array(
				'key' => 'field_mission_cards',
				'label' => 'Mission Cards',
				'name' => 'mission_cards',
				'type' => 'repeater',
				'sub_fields' => array(
					array('key' => 'field_card_icon',  'label' => 'Icon',        'name' => 'card_icon',  'type' => 'text'),
					array('key' => 'field_card_title', 'label' => 'Card Title',  'name' => 'card_title', 'type' => 'text'),
					array('key' => 'field_card_desc',  'label' => 'Description', 'name' => 'card_desc',  'type' => 'textarea'),
				),
			),
		),
		'location' => array(array(array(
			'param' => 'page_template',
			'operator' => '==',
			'value' => 'front-page.php',
		))),
	));

	acf_add_local_field_group(array(
		'key'    => 'group_product_extra',
		'title'  => 'Product Extra Details',
		'fields' => array(
			array('key' => 'field_cultivation',       'label' => 'Cultivation Info',   'name' => 'cultivation_info',   'type' => 'textarea'),
			array('key' => 'field_nutrition_energy',  'label' => 'Energy (kcal)',       'name' => 'nutrition_energy',   'type' => 'text'),
			array('key' => 'field_nutrition_fat',     'label' => 'Fat (g)',             'name' => 'nutrition_fat',      'type' => 'text'),
			array('key' => 'field_nutrition_protein', 'label' => 'Protein (g)',         'name' => 'nutrition_protein',  'type' => 'text'),
			array('key' => 'field_nutrition_carbs',   'label' => 'Carbohydrates (g)',   'name' => 'nutrition_carbs',    'type' => 'text'),
			array(
				'key' => 'field_health_benefits',
				'label' => 'Health Benefits',
				'name' => 'health_benefits',
				'type' => 'repeater',
				'sub_fields' => array(
					array('key' => 'field_benefit_text', 'label' => 'Benefit', 'name' => 'benefit_text', 'type' => 'text'),
				),
			),
			array(
				'key' => 'field_product_features',
				'label' => 'Product Features',
				'name' => 'product_features',
				'type' => 'repeater',
				'sub_fields' => array(
					array('key' => 'field_feature_text', 'label' => 'Feature', 'name' => 'feature_text', 'type' => 'text'),
				),
			),
		),
		'location' => array(array(array(
			'param' => 'post_type',
			'operator' => '==',
			'value' => 'product',
		))),
	));
}
add_action('acf/init', 'gale_register_acf_fields');

add_filter('woocommerce_enqueue_styles', '__return_empty_array');
