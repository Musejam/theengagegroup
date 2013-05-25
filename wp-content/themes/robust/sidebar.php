<?php
	if( is_single() ) {
		$post_sidebar = get_post_meta( get_the_ID(), 'ft_post_sidebar', true) ? get_post_meta( get_the_ID(), 'ft_post_sidebar', true) : 'sidebar';
		dynamic_sidebar($post_sidebar);
	} 
	elseif( is_page() ) {
		$page_sidebar = get_post_meta( get_the_ID(), 'ft_page_sidebar', true) ? get_post_meta( get_the_ID(), 'ft_page_sidebar', true) : 'sidebar';
		dynamic_sidebar($page_sidebar);
	}
	else {
		dynamic_sidebar( 'sidebar' );
	}
?>