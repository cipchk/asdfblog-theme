<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="posts">
	<div class="post">
		<div class="post-inner">
			<div class="post-header">
			    <h2 class="post-title"><?php the_title(); ?></h2>
		    </div>	        			        		                
			<div class="post-content">
				<?php the_content(); ?>
				<?php if ( current_user_can( 'manage_options' ) ) : ?>
					<p><?php edit_post_link( __('Edit', 'asdf') ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if ( comments_open() ) : ?>
		<?php comments_template( '', true ); ?>
	<?php endif; ?>
</div>
<?php endwhile; else: ?>
	<p><?php _e("未找到该页面！", "asdf"); ?></p>
<?php endif; ?>
<div class="clear"></div>
<?php get_footer(); ?>