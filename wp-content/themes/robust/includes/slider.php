<?php
$rev_slider = get_post_meta( $post->ID, 'ft_rev_slider', true );
?>

<section id="slider-wrapper" class="clearfix">
    <?php if ( $rev_slider ) : if ( function_exists('putRevSlider') ) putRevSlider( $rev_slider ); endif; ?>
</section>