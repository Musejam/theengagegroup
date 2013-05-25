<?php
include( 'shortcodes-fields.php' );
$popup = trim( $_GET['popup'] );
$shortcode = new FreshShortcodesFields( $popup ); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
    <div id="fresh-shortcodes-popup">
        <div id="fresh-shortcodes-wrap">
            <div id="fresh-shortcodes-form-wrap">
                <div id="fresh-shortcodes-form-head">
                    <?php echo $shortcode->popup_title; ?>
                </div>
                <form method="post" id="fresh-shortcodes-form">
                    <table id="fresh-shortcodes-form-table">
                        <?php echo $shortcode->output; ?>
                        <tbody>
                            <tr class="form-row">
                                <?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
                                <td class="field"><a href="#" class="button-primary fresh-shortcodes-insert"><?php _e('Insert Shortcodes', THEME_FX); ?></a></td>							
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            
            <div id="fresh-shortcodes-preview-wrap">
                <div id="fresh-shortcodes-preview-head">
                    <?php _e('Shortcode Preview', THEME_FX); ?>
                </div>
                <?php if( $shortcode->no_preview ) : ?>
                    <div id="fresh-shortcodes-nopreview"><?php _e('Shortcode has no preview', THEME_FX); ?></div>		
                <?php else : ?>			
                    <iframe src="<?php echo THEME_DIR; ?>framework/includes/preview.php?sc=" width="249" frameborder="0" id="fresh-shortcodes-preview"></iframe>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>