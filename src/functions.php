<?php

// 小工具
add_action( 'widgets_init', 'asdf_sidebar_reg' ); 

function asdf_sidebar_reg() { 
	register_sidebar(array(
		'name' => __( 'Sidebar', 'asdf' ),
		'id' => 'sidebar',
		'description' => __( '将小工具拖放至此', 'asdf' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content clearfix">',
		'after_widget' => '</div></div>'
	));
}

// 添加上一页下一页class
add_filter('next_posts_link_attributes', 'asdf_next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'asdf_previous_posts_link_attributes');

function asdf_next_posts_link_attributes() {
    return 'class="post-nav-older"';
}
function asdf_previous_posts_link_attributes() {
    return 'class="post-nav-newer"';
}

// 评论
if ( ! function_exists( 'asdf_comment' ) ) :
function asdf_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	
		<?php __( 'Pingback:', 'asdf' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'asdf' ), '<span class="edit-link">', '</span>' ); ?>
		
	</li>
	<?php
			break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-meta comment-author vcard">
				<?php echo get_avatar( $comment, 120 ); ?>
				<div class="comment-meta-content">
					<?php printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span class="post-author"> ' . __( '(Post author)', 'asdf' ) . '</span>' : ''
					); ?>
					<p><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo get_comment_date() . ' at ' . get_comment_time() ?></a></p>
				</div>
			</div>
			<div class="comment-content post-content">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Awaiting moderation', 'asdf' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
				<div class="comment-actions clearfix">
					<?php edit_comment_link( __( 'Edit', 'asdf' ), '', '' ); ?>
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'asdf' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>
		</div>
	<?php
		break;
	endswitch;
}
endif;

// 创建自定义工具
class Asdf_Customize {

	public static function register ( $wp_customize ) {

		$wp_customize->add_setting( 'asdf_logo', 
			array( 
				'sanitize_callback' => 'esc_url_raw'
			) 
		);


		$wp_customize->add_section( 'asdf_logo_section' , array(
			'title'       => __( '个人头像', 'asdf' ),
			'priority'    => 40,
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'asdf_logo', array(
			'label'    => __( '个人头像', 'asdf' ),
			'section'  => 'asdf_logo_section',
			'settings' => 'asdf_logo',
		) ) );
	}

}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'Asdf_Customize' , 'register' ) );

/* 所有回复都发邮件 */
function comment_mail_notify($comment_id) {
	$comment = get_comment($comment_id);
	$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	$spam_confirmed = $comment->comment_approved;
	if (($parent_id != '') && ($spam_confirmed != 'spam')) {
		$wp_email = 'no-reply@' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME'])); //e-mail 发出点, no-reply 可改为可用的 e-mail.
		$to = trim(get_comment($parent_id)->comment_author_email);
		$subject = '您在 [' . get_option("blogname") . '] BLOG的留言有了回复';
		$message = '
			
			<p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
			<p style="color:#999;">您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言：</p>
			<p style="background-color:#fafafa; border:1px solid #eee; padding:0 15px; border-radius:5px; padding: 8px;">' . trim(get_comment($parent_id)->comment_content) . '</p>
			<p style="color:#999;">' . trim($comment->comment_author) . ' 给您的回复：</p>
			<p style="background-color:#fafafa; border:1px solid #eee; padding:0 15px; border-radius:5px; padding: 8px;">' . trim($comment->comment_content) . '</p>
			<p style="color:#999;">您可以<a href="' . htmlspecialchars(get_comment_link($parent_id,array("type" => "all"))) . '">查看回复的完整內容</a>。</p>
			<p style="color:#999;">(此邮件由系统自动发送，请勿回复.)</p>';
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $message, $headers );
	}
}
add_action('comment_post', 'comment_mail_notify');
?>