<?php if ( !is_active_sidebar('sidebar-footer-1') && !is_active_sidebar('sidebar-footer-2') && !is_active_sidebar('sidebar-footer-3') && !is_active_sidebar('sidebar-footer-4') ) return; ?>

<div id="colophone" class="container">

    <section id="footer-widget-1" class="grid two-fifth clearfix" role="complementary">
        <?php if(is_active_sidebar('sidebar-footer-1')) : ?>
            <?php dynamic_sidebar('sidebar-footer-1'); ?>
        <?php endif; ?>
    </section><!--#footer-widget-1-->
    
    <section id="footer-widget-2" class="grid one-fifth clearfix" role="complementary">
        <?php if(is_active_sidebar('sidebar-footer-2')) : ?>
            <?php dynamic_sidebar('sidebar-footer-2'); ?>
        <?php endif; ?>
    </section><!--#footer-widget-2-->
    
    <section id="footer-widget-3" class="grid one-fifth clearfix" role="complementary">
        <?php if(is_active_sidebar('sidebar-footer-3')) : ?>
            <?php dynamic_sidebar('sidebar-footer-3'); ?>
        <?php endif; ?>
    </section><!--#footer-widget-3-->
    
    <section id="footer-widget-4" class="grid one-fifth clearfix" role="complementary">
        <?php if(is_active_sidebar('sidebar-footer-4')) : ?>
            <?php dynamic_sidebar('sidebar-footer-4'); ?>
        <?php endif; ?>
    </section><!--#footer-widget-4-->
    
</div>