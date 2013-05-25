<?php 

/* Template Name: Portfolio 3 Columns */

get_header(); ?>

    <?php get_template_part('includes/page', 'title'); ?>
    <?php if ( get_post_meta( $post->ID, 'ft_enable_slider', true ) ) get_template_part('includes/slider', ''); ?>

    <div id="main" class="container">

        <!-- CONTENT START -->
        <section id="content-fullwidth" class="grid full">
            <?php 

            $args = array(
                'post_type' => 'portfolio',
                'posts_per_page' => ft_get_option('portfolio_posts_per_page'),
                'paged' => get_query_var('paged')
            );

            query_posts($args); 
            ?>

            <?php if ( have_posts() ) : ?>
                <?php if ( ft_get_option('portfolio_filter') == 'on' ) : ?>
                    <ul id="portfolio-filter" class="clearfix" data-option-key="filter">
                        <li class="filter-label"><?php _e('Filter:', THEME_FX); ?></li>
                        <li><a href="#" data-option-value="*" class="all selected"><?php _e('All', THEME_FX); ?></a></li>
                        <?php wp_list_categories( array(
                            'title_li' => '', 
                            'taxonomy' => 
                            'portfolio_category', 
                            'walker' => new FreshThemes_Portfolio_Filter()
                        )); ?>
                        <li class="sep"></li>
                    </ul>
                <?php endif; ?>
                
                <div class="portfolio-items isotope-container isotope-3-columns row">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php $terms = get_the_terms( get_the_ID(), 'portfolio_category' ); ?>
                        <div class="portfolio-item grid one-third <?php if($terms) : foreach ($terms as $term) { echo $term->slug . ' '; } endif; ?>">
                            <?php get_template_part('includes/content', 'portfolio'); ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <?php if( function_exists('wp_pagenavi') ) : ?>
                <?php wp_pagenavi(); ?>
            <?php else : ?>
                <nav class="page-navigation clearfix">
                    <div class="left align-left"><?php previous_posts_link('&laquo; Previous Page') ?></div>
                    <div class="right align-right"><?php next_posts_link('Next Page &raquo;','') ?></div>
                </nav>
            <?php endif; ?>
            <?php endif; ?>
        </section>
        <!-- CONTENT END --> 

    </div>
        
<?php get_footer(); ?>