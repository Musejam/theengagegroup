<!-- COMMENTS START -->
<section id="comments" class="clearfix">

<?php if ( post_password_required() ) : ?>

	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', THEME_FX ); ?></p>

</section>
<!-- COMMENTS END -->

	<?php return; ?>

<?php endif; ?>

<?php if ( have_comments() ) : ?>
	<div class="heading">
		<h2 id="comments-title">
			<?php
			printf( _n( 'One comment', '%1$s comments', get_comments_number(), THEME_FX ),
				number_format_i18n( get_comments_number() ) );
			?>
		</h2>
		<div class="sep"></div>
	</div>

	<ol class="commentlist clearfix">
		<?php wp_list_comments( array( 'callback' => 'freshthemes_comment' ) ); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', THEME_FX ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', THEME_FX ) ); ?></div>
		</nav>
	<?php endif; ?>

<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="nocomments"><?php _e( 'Comments are closed.', THEME_FX ); ?></p>
<?php endif; ?>

<div class="clear"></div>

<?php
	$commenter = wp_get_current_commenter();
	$value_author = ( $commenter['comment_author'] ) ? $commenter['comment_author'] : __( 'Name (required)', THEME_FX );
	$value_email = ( $commenter['comment_author_email'] ) ? $commenter['comment_author_email'] : __( 'Email (required)', THEME_FX );
	$value_url = ( $commenter['comment_author_url'] ) ? $commenter['comment_author_url'] : __( 'Website URL', THEME_FX );
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields =  array(
		'author' => '<div class="row"><p class="comment-form-author grid one-third"><input id="author" name="author" type="text" value="'. esc_attr( $value_author ) .'" size="30"'. $aria_req .' /></p>',
		'email' => '<p class="comment-form-email grid one-third"><input id="email" name="email" type="text" value="'. esc_attr(  $value_email ) .'" size="30"'. $aria_req .' /></p>',
		'url' => '<p class="comment-form-url grid one-third"><input id="url" name="url" type="text" value="'. esc_attr( $value_url ) .'" size="30" /></p></div>',
	); 

	$comments_args = array(
		'fields' => $fields,
		'title_reply' => __( '<span>Leave a Reply</span>', THEME_FX ),
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" cols="100" rows="10"></textarea></p>',
	);
	
	comment_form($comments_args); 
?>
</section>
<!-- COMMENTS END -->