<?php get_header(); ?>


<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-4 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12" id="offcanvas-content">
			<?php
			if (have_posts()){
				custom_content_nav( 'nav_above' );
				while (have_posts()){
					the_post();
					get_template_part( 'content', 'single' );
				}
			}
			?>
		</div>
	</div>
</div>
<?php get_footer() ?>