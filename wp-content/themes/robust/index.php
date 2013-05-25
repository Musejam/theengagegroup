<?php get_header(); ?>
    
    <?php get_template_part('includes/page', 'title'); ?>

    <div id="main" class="container">
    
        <!-- CONTENT START -->
        <section id="content" class="grid two-third">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part('includes/content', get_post_format()); ?>
                <?php endwhile; ?>

                <?php if( function_exists('wp_pagenavi') ) : ?>
                    <?php wp_pagenavi(); ?>
                <?php else : ?>
                    <nav class="page-navigation clearfix">
                        <div class="left align-left"><?php previous_posts_link('&laquo; Previous Page') ?></div>
                        <div class="right align-right"><?php next_posts_link('Next Page &raquo;','') ?></div>
                    </nav>
                <?php endif; ?>

            <?php else : ?>

                <article id="post-0" class="post no-results not-found">
                    <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                        <h2><?php _e( 'No posts to display', THEME_FX ); ?></h1>
                        <p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', THEME_FX ), admin_url( 'post-new.php' ) ); ?></p>
                    <?php else : ?>
                        <h2><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
                        <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </article>

            <?php endif; ?>
        </section>
        <!-- CONTENT END -->
        
        <!-- SIDEBAR START -->
        <section id="sidebar" class="grid one-third">
            <?php get_sidebar(); ?>
        </section>
        <!-- SIDEBAR END -->    
    
    </div>
        
<?php get_footer(); ?>