<?php
$show_title = true;
$has_subtitle = false;
$page_title = '';
$page_subtitle = '';
$blog_id = get_option('page_for_posts');

if ( is_home() || is_single() && 'post' == get_post_type() ) {
    $show_title = get_post_meta($blog_id, 'ft_page_title', true) != 'off' ? true : false;
    $has_subtitle = get_post_meta($blog_id, 'ft_page_subtitle', true) ? true : false;
    $page_title = $blog_id ? get_the_title($blog_id) : __('Blog', THEME_FX);
    $page_subtitle = get_post_meta($blog_id, 'ft_page_subtitle', true);
}

elseif ( is_page() ) {
    $show_title = get_post_meta(get_the_id(), 'ft_page_title', true) != 'off' ? true : false;
    $has_subtitle = get_post_meta(get_the_id(), 'ft_page_subtitle', true) ? true : false;
    $page_title = get_the_title();
    $page_subtitle = get_post_meta(get_the_id(), 'ft_page_subtitle', true);
}

elseif ( is_single() && 'portfolio' == get_post_type() ) {
    $show_title = true;
    $has_subtitle = get_post_meta(get_the_id(), 'ft_portfolio_subtitle', true) ? true : false;
    $page_title = get_the_title();
    $page_subtitle = get_post_meta(get_the_id(), 'ft_portfolio_subtitle', true);
}

elseif ( is_search() ) {
    $show_title = true;
    $has_subtitle = true;
    $page_title = __('Search Result', THEME_FX);

    $allsearch = &new WP_Query("s=$s&showposts=-1"); 
    $key = esc_html($s, 1); 
    $count = $allsearch->post_count;
    $page_subtitle =  sprintf( __( 'We found %1$s result for "%2$s"', THEME_FX ), $count, $key );
    wp_reset_query(); 
}

elseif ( is_404() ) {
    $show_title = true;
    $has_subtitle = true;
    $page_title = __('Error 404', THEME_FX);
    $page_subtitle =  __('Page not Found', THEME_FX);
}

else {
    $show_title = true;
    $has_subtitle = true;
    $page_title = $blog_id ? get_the_title($blog_id) : __('Blog', THEME_FX);

    if ( is_category() ) :
        $page_subtitle =  sprintf( __( 'All posts in %s', THEME_FX ), single_cat_title('', false) );
    elseif ( is_tag() ) :
        $page_subtitle =  sprintf( __( 'All posts tagged %s', THEME_FX ), single_tag_title('', false) );
    elseif ( is_day() ) :
        $page_subtitle =  sprintf( __( 'Archive for %s', THEME_FX ), get_the_date() );
    elseif ( is_month() ) :
        $page_subtitle =  sprintf( __( 'Archive for %s', THEME_FX ), get_the_date( _x( 'F Y', 'monthly archives date format', THEME_FX ) ) );
    elseif ( is_year() ) :
        $page_subtitle =  sprintf( __( 'Archive for %s', THEME_FX ), get_the_date( _x( 'Y', 'yearly archives date format', THEME_FX ) ) );
    elseif ( is_author() ) :
        global $author; 
        $userdata = get_userdata($author);
        $page_subtitle =  sprintf( __( 'All posts by %s', THEME_FX ), $userdata->display_name );
    endif;
}

if ($show_title) :


$title_container_class = ( ft_get_option('page_title_searchform') != 'off' ) ? ' class="grid two-third"' : ' class="grid full"';
?>

<div id="page-title" class="<?php if( $has_subtitle ) echo 'has_subtitle '; ?>clearfix">
    <div class="container">
        <div<?php echo $title_container_class; ?>>
            <hgroup>
                <h1><?php echo esc_attr($page_title); ?></h1>
                <h2><?php echo esc_attr($page_subtitle); ?></h2>
            </hgroup>
        </div>

        <?php if( ft_get_option('page_title_searchform') != 'off' ) : ?>
            <div id="top_search" class="grid one-third">
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>

    </div>
</div>
<?php endif; ?>