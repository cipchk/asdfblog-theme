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