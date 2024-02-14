<?php

/*
 * Plugin Name:       Lens Link
 * Plugin URI:        https://github.com/kazimayaan/Lens-Link
 * Description:       Links the url to lens.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Kazim Ayaan P S
 * Author URI:        https://github.com/kazimayaan
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


 function lens_url_shortcode() {
  
	
    $post_id = get_the_ID();
    $lens_url = get_post_meta($post_id, 'lens_url', true);

    
	if(!empty($lens_url)){
		$output = '<hr> <h2 class="lens_header">
        Now Read Recent Articles in <a href="https://elifesciences.org/inside-elife/0414db99/seeing-through-the-elife-lens-a-new-way-to-view-research" target="_blank">LENS</a>
    </h2> <a target="_blank" href="' . esc_url($lens_url) . '"> <button class="lens_button"> <img src="https://jpionline.org/wp-content/uploads/2024/02/magic-book.png" class="lens_icon" style="max-width: 25px;"> <span class="lens_text">Read In Lens </span> </button></a>';
	}
	else {
        $output = '';
    }
	
    return $output;
}

// Register the shortcode
add_shortcode('lens_link', 'lens_url_shortcode');

// code to add lens_url to all the post 



function add_lens_url_to_post($post_id) {
    if (!get_post_meta($post_id, 'lens_url', true)) {
        add_post_meta($post_id, 'lens_url', '', true);
    }
}

function add_lens_url_to_existing_posts() {
    $args = array(
        'post_type' => 'post',  
        'posts_per_page' => -1,  
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            add_lens_url_to_post($post_id);
        }
        wp_reset_postdata();
    }
}

function add_lens_url_to_new_posts($post_id) {
    add_lens_url_to_post($post_id);
}


add_action('init', 'add_lens_url_to_existing_posts');


add_action('save_post', 'add_lens_url_to_new_posts');


 ?>
