<?php get_header(); ?>
<div class="posts">
	<div class="post">
		<div class="post-inner">
			<div class="post-header">
	        	<h2 class="post-title"><?php _e('Error 404', 'wilson'); ?></h2>
	        </div>
	        <div class="post-content">
	            <p><?php _e("哎，这页面可能让我删除，为什么删除呢？肯定是因为这技术已经过时，或者我感觉有误导。尝试搜索也许会有收获！", 'asdf') ?></p>
	            <?php get_search_form(); ?>
	        </div>
		</div>            	                        	
	</div>
</div>
<?php get_footer(); ?>