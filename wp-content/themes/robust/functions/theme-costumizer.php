<?php
function freshthemes_theme_costumizer($wp_costumize){
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
}

add_action('costumize_register', 'freshthemes_theme_costumizer');

function freshthemes_theme_costumizer_preview_js(){
	wp_enqueue_script(
		'theme-customizer', 
		THEME_DIR. '/javascripts/theme-customizer.js', 
		array('customize-preview'), 
		THEME_VERSION,
		true 
	);
}

add_action('customize_preview_init', 'freshthemes_theme_costumizer_preview_js');