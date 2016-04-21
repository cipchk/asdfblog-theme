<?php 

get_header(); 

if (have_posts()) : 
?>
<div class="posts">
	<?php while (have_posts()) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    		<?php get_template_part( 'content', get_post_format() ); ?>
		</div>
    <?php endwhile; ?>
</div>
<?php endif; ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div class="archive-nav clearfix">
		<?php echo get_next_posts_link( __('&laquo; Older<span> posts</span>', 'asdf')); ?>
		<?php echo get_previous_posts_link( __('Newer<span> posts</span> &raquo;', 'asdf')); ?>
	</div>
<?php endif; ?>
<?php get_footer(); ?>