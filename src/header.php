<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <title><?php wp_title('|', true, 'right'); ?>cipchk</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="alternate" type="application/rss+xml" title="asdf blog + RSS 2.0" href="http://asdfblog.com/feed">
    <meta name="author" content="cipchk, cipchk@qq.com">
    <link rel="stylesheet" href="/wp-content/themes/asdf/style.css" type="text/css" media="all">
    <script src="/wp-content/themes/asdf/js/m.js"></script>
  </head>
  <body>
  	<div class="container">
			<div class="sidebar">
              <div class="header">
                  <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                      <img src="<?php echo esc_url( get_theme_mod( 'asdf_logo' ) ); ?>">
                  </a>
                  <h1 class="title"><?php echo esc_attr( get_bloginfo( 'title' ) ); ?></h1>
                  <p class="description"><?php echo esc_attr( get_bloginfo( 'description' ) ); ?></p>
              </div>
				<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
				<div class="widgets" role="complementary">
					<?php dynamic_sidebar( 'sidebar' ); ?>
				</div>
			  <?php endif; ?>
			</div>
			<div class="content">