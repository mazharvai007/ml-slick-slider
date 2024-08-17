<?php
/**
* Plugin Name: ML Slick Slider
* Plugin URI: http://miabs.net/
* Description: This is a slider plugin for WordPress
* Version: 1.0
*  Author: MiabsLab
*/

/**
 * Register ML Slick Slider
 *
 * @return void
 */
function ml_slick_register_cpt() {
    $labels = [
        'name' => 'ML Slick Slider'
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes']
    ];

    register_post_type('ml-slick-slider', $args);
}
add_action('init', 'ml_slick_register_cpt');

/**
 * Register shortcode
 *
 * @return void
 */
function ml_slick_slider_shortcode() {
    $args = [
        'post_type' => 'ml-slick-slider',
        'post_per_page' => -1,
    ];

    $query = new WP_Query($args);

    $html = '<div class="ml-slick-slider">';
    while($query->have_posts()): $query->the_post();
        $html .= '<div class="slick-slide" style="background-image:url('.get_the_post_thumbnail_url(get_the_ID(), 'large').')">';
            $html .= '<div class="slider-content">';
            $html .= '<h2 class="slider-title">'.get_the_title().'</h2>';
            $html .= wpautop(get_the_content());
        $html .= '</div></div>';
    endwhile; 
    wp_reset_query();

    $html .= '</div>';

    return $html;
}
add_shortcode('ml_slick_slider', 'ml_slick_slider_shortcode');

/**
 * Load slick slider assets
 *
 * @return void
 */
function ml_slider_assets() {
    $plugin_dir_url = plugin_dir_url(__FILE__);
    
    wp_enqueue_style('ml-slick-slider', $plugin_dir_url.'assets/css/slick.css');
    wp_enqueue_style('ml-slick-slider-custom', $plugin_dir_url.'assets/css/style.css');
    wp_enqueue_script('ml-slick-slider', $plugin_dir_url.'assets/js/slick.min.js', ['jquery'], '1.0', true);
    wp_enqueue_script('ml-slick-slider-main-js', $plugin_dir_url.'assets/js/main.js', ['jquery'], '1.0', true);
}
add_action('wp_enqueue_scripts', 'ml_slider_assets');