<?php 

/* Template Name: Side Navigation */

get_header(); ?>
    
    <?php get_template_part('includes/page', 'title'); ?>
    <?php if ( get_post_meta( $post->ID, 'ft_enable_slider', true ) ) get_template_part('includes/slider', ''); ?>

    <div id="main" class="container">

        <?php
        $layout = get_post_meta($post->ID, 'ft_page_layout', true);
        $class = 'page-' . $layout . ' grid';
        $class = ($layout == 'fullwidth') ? $class . ' full' : $class . ' two-third';
        $content = get_post_meta( $post->ID, 'freshbuilder_data', true); 
        ?>
    
        <!-- CONTENT START -->
        <section id="content" class="<?php echo $class; ?>">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
                    <div class="page-side-nav grid one-fourth">
                        <ul>
                            <?php   
                                $page_ancestors = get_post_ancestors($post->ID);
                                $page_parent = end($page_ancestors);
                                $li_class = ( is_page($page_parent) ) ? ' class="current_page_item"' : '';
                            ?>
                            
                            <li<?php echo $li_class; ?>>
                                <a href="<?php echo get_permalink($page_parent); ?>"><?php echo get_the_title($page_parent); ?></a>
                            </li>
                            
                            <?php
                            if($page_parent) {
                                $children = wp_list_pages("title_li=&child_of=".$page_parent."&echo=0");
                            } else {
                                $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
                            }
                            
                            if ($children) { echo $children;  } ?>          
                        </ul>
                        <div class="page-side-nav-shadow"></div>
                    </div>

                    <div class="grid three-fourth">
                        <?php if ( !empty($content['shortcode']) ) : ?>
                            <div class="row">
                                <?php echo do_shortcode( $content['shortcode'] ); ?>
                            </div>
                        <?php else : ?>
                            <?php the_content(); ?>
                        <?php endif; ?> 
                        
                        <?php wp_link_pages( array('before' => '<div class="page-links">'. __('Pages:', THEME_FX), 'after' => '</div>') ); ?>
                    </div>
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