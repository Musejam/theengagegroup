<?php get_header(); ?>

    <?php get_template_part('includes/page', 'title'); ?>
    <?php if ( get_post_meta( $post->ID, 'ft_enable_slider', true ) ) get_template_part('includes/slider', ''); ?>

    <div id="main" class="container">

        <?php
        $layout = get_post_meta($post->ID, 'ft_page_layout', true);
        $class = ($layout == 'fullwidth') ? 'full' : 'two-third';
        $content_shortcode = get_post_meta( $post->ID, 'freshbuilder_data_shortcode', true); 
        ?>
    
        <!-- CONTENT START -->
        <section id="content-<?php echo $layout; ?>" class="grid <?php echo $class; ?>">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                    <?php if ( !empty($content_shortcode) ) : ?>
                        <div class="row">
                            <?php echo do_shortcode( stripslashes($content_shortcode) ); ?>
                        </div>
                    <?php else : ?>
                        <?php the_content(); ?>
                    <?php endif; ?> 
                    
                    <?php wp_link_pages( array('before' => '<div class="page-links">'. __('Pages:', THEME_FX), 'after' => '</div>') ); ?>
                </article>
            <?php endwhile; ?>
        </section>
        <!-- CONTENT END -->
        
        <?php if( $layout != 'fullwidth' ) : ?>
            <!-- SIDEBAR START -->
            <section id="sidebar" class="grid one-third">
                <?php get_sidebar(); ?>
            </section>
            <!-- SIDEBAR END -->
        <?php endif; ?>

    </div>

<?php get_footer(); ?>