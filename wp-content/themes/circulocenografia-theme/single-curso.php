<?php get_header(); ?>


<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<?php
			if (have_posts()){
				custom_content_nav( 'nav_above' );
				while (have_posts()){
					the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
				<?php single_post_nav('nav-above'); ?>
				<header class="entry_header clearfix">
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="entry_content clearfix">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>
<?php get_footer() ?>