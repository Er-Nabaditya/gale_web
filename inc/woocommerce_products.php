<?php
function gale_enqueue_product_styles($post_type, $perpages, $orderby, $order) {

    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $perpages,
        'orderby'        => $orderby,
        'order'          => $order,
    );

    $products = new WP_Query($args);

    $product_array = array();

    if ($products->have_posts()) :
        while ($products->have_posts()) : $products->the_post();

            $product_array[] = array(
                'id'       => wc_get_product(get_the_ID()),
                'features' => get_field('product_features'),
            );

        endwhile;
        wp_reset_postdata();
    endif;

    return $product_array;
}
?>