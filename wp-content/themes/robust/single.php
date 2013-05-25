<?php get_header(); ?>

    <?php get_template_part('includes/page', 'title'); ?>

    <div id="main" class="container">
    
        <!-- CONTENT START -->
        <section id="content" class="grid two-third">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part('includes/content', get_post_format($post->ID)); ?>
                <?php if ( comments_open() ) : comments_template( '', true ); endif; ?>
            <?php endwhile; ?>
        </section>
        <!-- CONTENT END -->

        <!-- SIDEBAR START -->
        <section id="sidebar" class="grid one-third">
            <?php get_sidebar(); ?>
        </section>
        <!-- SIDEBAR END -->
    
    </div>
        
<?php get_footer(); ?>