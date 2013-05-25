<?php get_header(); ?>

    <?php get_template_part('includes/page', 'title'); ?>

    <div id="main" class="container">

        <?php $layout = get_post_meta($post->ID, 'ft_portfolio_layout', true); ?>
    
        <!-- CONTENT START -->
        <section id="content-<?php echo $layout; ?>" class="clearfix">
            <?php while ( have_posts() ) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-single clearfix'); ?>>
                    <div class="portfolio-assets grid <?php echo ( $layout == 'fullwidth') ? 'full' : ' two-third'; ?> clearfix">
                        <?php
                        $type = get_post_meta($post->ID, 'ft_portfolio_type', true);
                        $images_size  = ($layout == 'fullwidth') ? '960x480' : 'fullwidth';

                        switch ($type) :
                            case 'video':
                                echo '<div class="video-container">';
                                    $video = get_post_meta($post->ID, 'ft_portfolio_video', true);
                                    echo wp_oembed_get( $video, array('width' => 960) );
                                echo '</div>';
                                break;
                            
                            default:
                                $images = get_post_meta($post->ID, 'ft_portfolio_images', true);
                                
                                if ($images && is_array($images)):
                                    echo '<div class="flexslider">';
                                        echo '<ul class="slides">';
                                            foreach ($images as $image) :
                                                if( !is_numeric($image) ) {
                                                    $image_id = freshthemes_get_attachement_id($image);
                                                }
                                                else {
                                                    $image_id = $image;
                                                }

                                                if($image_id) {
                                                    echo '<li><a href="'. wp_get_attachment_url($image_id, 'full') .'" title="'. get_the_title($image_id) .'" rel="prettyPhoto[pp_gal]">'. wp_get_attachment_image($image_id, $images_size) .'</a></li>';
                                                }
                                                else {
                                                    echo '<li><a href="'. $image .'" rel="prettyPhoto[pp_gal]"><img src="'. $image .'" /></a></li>';
                                                }
                                            endforeach;
                                        echo '</ul>';
                                    echo '</div>';
                                else :
                                    if( (function_exists('has_post_thumbnail')) && has_post_thumbnail() ) :
                                        $image_id = get_post_thumbnail_id($post->ID);
                                        echo '<a href="'. wp_get_attachment_url($image_id, 'full') .'">'. get_the_post_thumbnail( $post->ID, $images_size ) .'</a>';
                                    endif;
                                endif;
                                break;
                        endswitch;
                        ?>
                    </div>

                    <div class="portfolio-content<?php echo ( $layout == 'fullwidth') ? '' : ' grid one-third'; ?> clearfix">
                        <div class="portfolio-desc<?php echo ( $layout == 'fullwidth') ? ' grid two-third' : ''; ?> clearfix">

                            <?php if( ft_get_option('portfolio_description_heading') ) : ?>
                                <div class="heading">
                                    <h3><?php echo ft_get_option('portfolio_description_heading'); ?></h3>
                                    <div class="sep"></div>
                                </div>
                            <?php endif; ?>

                            <?php the_content(); ?>

                        </div>

                        <div class="portfolio-details<?php echo ( $layout == 'fullwidth') ? ' grid one-third' : ''; ?> clearfix">

                            <?php if( ft_get_option('portfolio_details_heading') ) : ?>
                                <div class="heading">
                                    <h3><?php echo ft_get_option('portfolio_details_heading'); ?></h3>
                                    <div class="sep"></div>
                                </div>
                            <?php endif; ?>

                            <ul class="icons">
                                <?php if ( get_post_meta($post->ID, 'ft_portfolio_client', true) ) : ?>
                                <li><i class="icon-user"></i><strong><?php _e('Client', THEME_FX); ?></strong>: <?php echo get_post_meta($post->ID, 'ft_portfolio_client', true); ?></li>
                                <?php endif; ?>

                                <?php if ( get_post_meta($post->ID, 'ft_portfolio_date', true) ) : ?>
                                <li><i class="icon-calendar"></i><strong><?php _e('Date', THEME_FX); ?></strong>: <?php echo get_post_meta($post->ID, 'ft_portfolio_date', true); ?></li>
                                <?php else : ?>
                                <li><i class="icon-calendar"></i><strong><?php _e('Date', THEME_FX); ?></strong>: <?php the_time( get_option('date_format')) ?></li>
                                <?php endif; ?>

                                <?php
                                $cats = freshthemes_get_portfolio_categories();
                                if ($cats != '') : ?>
                                <li><i class="icon-folder-close"></i><strong><?php _e('Categories', THEME_FX); ?></strong>: <?php echo $cats; ?></li>
                                <?php endif; ?>

                                <?php if ( get_post_meta($post->ID, 'ft_portfolio_url', true) ) : ?>
                                <li><i class="icon-link"></i><strong><?php _e('Project URL', THEME_FX); ?></strong>: <a href="<?php echo get_post_meta($post->ID, 'ft_portfolio_url', true); ?>"><?php _e('Visit online &rarr;', THEME_FX); ?></a></li>
                                <?php endif; ?>
                            </ul>

                            <nav id="portfolio-nav" class="clearfix">
                                <?php 
                                    previous_post_link('%link', '<i class="icon-chevron-left"></i>&nbsp;&nbsp;' . __('Prev Project', THEME_FX) );
                                    next_post_link('%link', __('Next Project', THEME_FX) . '&nbsp;&nbsp;<i class="icon-chevron-right"></i>'); 
                                ?>
                            </nav>

                        </div>
                    </div>
                </article>

                <?php if( ft_get_option('enable_portfolio_related') == 'on' ) :

                    $i = 0;
                    $column  = ft_get_option('portfolio_related_column');
                    $terms = get_the_terms( get_the_ID(), 'portfolio_category' );
                    $taxs  = '';
                    if ($terms) {
                        foreach ($terms as $term) {
                            $taxs[] = $term->slug;
                        }
                    }

                    $grid  = 'one-half';
                    if ($column == '3') $grid = 'one-third';
                    if ($column == '4') $grid = 'one-fourth';

                    $args = array(
                        'post_type' => 'portfolio',
                        'posts_per_page' => ft_get_option('portfolio_related_number'),
                        'post__not_in' => array($post->ID),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'portfolio_category',
                                'field' => 'slug',
                                'terms' => $taxs
                            )
                        )
                    );

                    $loop = new WP_Query($args);

                    if ( $loop->have_posts() ) : ?>
                    <section id="related-portfolio" class="grid full">
                        <?php if( ft_get_option('portfolio_related_heading') ) : ?>
                            <div class="heading">
                                <h3><?php echo ft_get_option('portfolio_related_heading'); ?></h3>
                                <div class="sep"></div>
                            </div>
                        <?php endif; ?>

                        <div class="portfolio-items row">
                            <?php while ( $loop->have_posts() ) : $loop->the_post(); $i++ ?>
                                <div class="portfolio-item grid <?php echo $grid; ?>">
                                    <?php get_template_part('includes/content', 'portfolio'); ?>
                                </div>

                                <?php if( $i == $column ) echo '<div class="clear"></div>'; ?>
                            <?php endwhile; ?>
                        </div>
                    </section>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                    
                <?php endif; ?>

            <?php endwhile; ?>
        </section>
        <!-- CONTENT END -->
    
    </div>
        
<?php get_footer(); ?>