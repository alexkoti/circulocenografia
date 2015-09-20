<?php get_header(); ?>
<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<h1>Cursos</h1>
			<?php
			if (have_posts()){
				while (have_posts()){
					the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry_header">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</header>
				<div class="entry_content">
					<?php the_excerpt(); ?>
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