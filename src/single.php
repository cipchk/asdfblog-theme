<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="posts">
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="post-inner clearfix">
			<div class="post-header">
			    <h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			    <div class="post-meta">
					<time class="post-date"><?php the_time(get_option('date_format')); ?></time>
					<span class="date-sep"> / </span>
					<?php comments_popup_link( '无评论', '1评论', '%评论' ); ?>
					<?php if ( current_user_can( 'manage_options' ) ) { ?>
						<span class="date-sep"> / </span>
						<?php edit_post_link(__('Edit', 'asdf')); ?>
					<?php } ?>
				</div>
			</div>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
		</div>
	</div>
</div>
<div class="post-meta-bottom">
	<div class="post-cat-tags">
		<p class="post-categories"><span><?php _e('Categories:', 'asdf') ?></span> <?php the_category(', '); ?></p>
		<?php if( has_tag()) { ?><p class="post-tags"><span><?php _e('Tags:', 'asdf') ?></span> <?php the_tags('', ', '); ?></p><?php } ?>
	</div>
	<div class="archive-nav post-nav clearfix">
		<?php
		$prev_post = get_previous_post();
		if (!empty( $prev_post )): ?>
			<a class="post-nav-older" title="<?php _e('Previous post:', 'asdf'); echo ' ' . get_the_title($prev_post); ?>" href="<?php echo get_permalink( $prev_post->ID ); ?>">
			&laquo; <?php echo get_the_title($prev_post); ?>
			</a>
		<?php endif; ?>
		<?php
		$next_post = get_next_post();
		if (!empty( $next_post )): ?>
			<a class="post-nav-newer" title="<?php _e('Next post:', 'wilson'); echo ' ' . get_the_title($next_post); ?>" href="<?php echo get_permalink( $next_post->ID ); ?>">
			<?php echo get_the_title($next_post); ?> &raquo;
			</a>
		<?php endif; ?>
	</div>
</div>
<?php comments_template( '', true ); ?>
<?php endwhile; else: ?>
<p><?php _e("文章未找到", "asdf"); ?></p>
<?php endif; ?>
<?php get_footer(); ?>