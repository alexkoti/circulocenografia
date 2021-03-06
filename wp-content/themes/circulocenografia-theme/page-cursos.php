<?php get_header(); ?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<?php
			if (have_posts()){
				while (have_posts()){
					the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry_header">
					<h1><?php the_title(); ?></h1>
				</header>
				<div class="entry_content">
					<?php
					the_content();
					?>
				</div>
			</article>
			<?php
				}
			}
			?>
			
			<?php
			$old = new WP_Query(array('post_type' => 'curso', 'meta_key' => 'curso_anterior'));
			if( $old->posts ){
				foreach( $old->posts as $post ){
					setup_postdata($post);
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
				wp_reset_postdata();
			}
			?>
		</div>
	</div>
</div>

<?php get_footer() ?>