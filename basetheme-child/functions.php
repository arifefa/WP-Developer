<?php 
function versioning_style(){
	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'), null);
}
add_action('wp_print_styles', 'versioning_style');