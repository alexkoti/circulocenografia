<?php
/**
 * Template de categoria aplicável em listagens gerais para qualquer termo, a menos que este já possua um template próprio.
 * Aplicação geral, para criar templates para cada termo, usar esses modelos:
 *  - category-slug.php
 *  - category-id.php
 * 
 * 
 */

$queried = $wp_query->get_queried_object();
get_header(); ?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<h3>Categoria <strong><?php echo $queried->name; ?></strong></h3>
			<?php
			if (have_posts()){
				custom_content_nav( 'nav_above' );
				while (have_posts()){
					the_post();
					get_template_part( 'content', 'list' );
				}
				custom_content_nav( 'nav_below' );
			}
			?>
		</div>
	</div>
</div>
<?php get_footer() ?>