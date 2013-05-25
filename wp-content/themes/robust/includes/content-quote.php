<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
    
    <?php if( !is_singular() ) : ?><?php global $more; $more = 0; ?><?php endif; ?>

	<div class="entry-badge">
        <a href="<?php the_permalink(); ?>"><i class="icon-quote-right"></i></a>
    </div>

    <?php if (get_post_meta( $post->ID, 'ft_quote_text', true )) : ?>
    <div class="entry-asset asset-quote">
        <div class="fancy-quote">
            <div class="quote-text">
                <div class="triangle"></div>
                <p><?php echo get_post_meta( $post->ID, 'ft_quote_text', true ); ?></p>
            </div>

            <?php if (get_post_meta( $post->ID, 'ft_quote_author', true )) : ?>
            <div class="quote-author">
                <span class="quote-author-name"><?php echo get_post_meta( $post->ID, 'ft_quote_author', true ); ?></span>

                <?php if (get_post_meta( $post->ID, 'ft_quote_author_meta', true )) : ?>
                    - <span class="quote-author-meta"><?php echo get_post_meta( $post->ID, 'ft_quote_author_meta', true ); ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (is_single()) : ?>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>

        <div class="entry-meta">
            <?php 
                printf( 
                    __('Posted on %1$s by %2$s ', THEME_FX) , 
                    get_the_time('F j, Y'),
                    get_the_author()
                );
                _e('in ', THEME_FX) . the_category(', ');
                _e(' with ', THEME_FX) . comments_popup_link( 'No comments', '1 comment', '% comments', 'comments-link', 'Comments Disabled' );
            ?>
        </div>
    </header>

    <div class="entry-content">
        <?php 
            the_content();
            wp_link_pages( array('before' => '<div class="page-link"><span>'. __('Pages:', THEME_FX).'</span>', 'after' => '</div>') );
        ?>
    </div>
    <?php endif; ?>
    
    <?php if( is_singular() && ft_get_option('author_box') != 'off') get_template_part('includes/author', 'box'); ?>

</article><!-- #post <?php the_ID(); ?> -->