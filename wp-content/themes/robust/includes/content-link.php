<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>

    <?php if( !is_singular() ) : ?><?php global $more; $more = 0; ?><?php endif; ?>

    <div class="entry-badge">
        <a href="<?php the_permalink(); ?>"><i class="icon-link"></i></a>
    </div>

    <?php
    $link = get_post_meta( $post->ID, 'ft_link_destination', true );
    $display_link = get_post_meta( $post->ID, 'ft_link_display', true ) ? get_post_meta( $post->ID, 'ft_link_display', true ) : get_post_meta( $post->ID, 'ft_link_destination', true );
    ?>

    <header class="entry-header">
        <?php if( !is_singular() ) : ?>
            <h2 class="entry-title"><a class="reserve" href="<?php echo $link; ?>" title="<?php printf( esc_attr__( 'Permalink to %s',  THEME_FX ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <?php else : ?>
            <h1 class="entry-title"><a class="reserve" href="<?php echo $link; ?>" title="<?php printf( esc_attr__( 'Permalink to %s',  THEME_FX ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php endif; ?>

        <div class="entry-meta">
            <?php echo $display_link; ?>
        </div>
    </header>

    <div class="entry-content">
        <?php 
        if ( is_search() ){
            the_excerpt();
        } else{
            the_content();
            wp_link_pages( array('before' => '<div class="page-link"><span>'. __('Pages:', THEME_FX).'</span>', 'after' => '</div>') );
        } 
        ?>
    </div>

    <?php if( is_singular() && ft_get_option('author_box') != 'off') get_template_part('includes/author', 'box'); ?>

</article><!-- #post <?php the_ID(); ?> -->