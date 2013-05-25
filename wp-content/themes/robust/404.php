<?php get_header(); ?>

    <?php get_template_part('includes/page', 'title'); ?>

    <div id="main" class="container">

        <!-- CONTENT START -->
        <section id="content" class="grid full">
            <article id="post-404" class="entry align-center">
                <i class="icon-warning-sign icon-4x"></i>
                <h1><?php _e('Page not Found!', THEME_FX) ?></h1>
                <h3><?php _e('Error 404! Sorry, but we couldn\'t find the page you were looking for.', THEME_FX) ?></h3>
            </article>
        </section>
        <!-- CONTENT END -->

    </div>

<?php get_footer(); ?>