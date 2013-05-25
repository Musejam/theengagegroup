<?php

/*	Comment Template
 *	--------------------------------------------------------------------------- */	
	if ( ! function_exists( 'freshthemes_comment' ) ) : // check if function is not exists then call the comment template.
	
	function freshthemes_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' : ?>
		
			<li class="post pingback">
				<p><?php _e( 'Pingback:',  THEME_FX ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit',  THEME_FX ), '<span class="edit-link">', '</span>' ); ?></p>
			
			<?php
			break;
		
			default : ?>
		
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<span class="triangle"></span>
                    <footer class="comment-meta">
						<div class="comment-author vcard">
							<?php
							$avatar_size = 45;
							if ( '0' != $comment->comment_parent )
							$avatar_size = 45;

							echo get_avatar( $comment, $avatar_size );

							/* translators: 1: comment author, 2: date and time */
							printf( __( '%1$s %2$s - %3$s',  THEME_FX ),
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
								sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */
									sprintf( __( '%1$s at %2$s',  THEME_FX ), get_comment_date(), get_comment_time() )
								),
								get_comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply' ,  THEME_FX ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) )
							);
							
							edit_comment_link( __( 'Edit',  THEME_FX ), '<span class="edit-link">', '</span>' ); 
							?>
						</div><!-- .comment-author .vcard -->

						<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.',  THEME_FX ); ?></em>
						<br />
						<?php endif; ?>
					</footer>

					<div class="comment-content">
						<?php comment_text(); ?>
					</div>

					<div class="reply">
						<?php
						
						
						?>
					</div><!-- .reply -->
				</article><!-- #comment-## -->
			
			<?php
			break;
			
		endswitch;
	}
	
	endif; // end check function.