<?php
/**
 * Template da página inicial do site.
 * Configurar qual 'page' deverá mostrar essa listagem em 'Admin > Configurações > Leitura', item 'Página inicial:'
 * 
 * 
 */

get_header(); ?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<img src="http://placehold.it/780x400" class="img-responsive" alt="" />
			
			<?php
			//if (have_posts()){
			//	custom_content_nav( 'nav_above' );
			//	while (have_posts()){
			//		the_post();
			//		get_template_part( 'content', 'page' );
			//	}
			//}
			?>
		</div>
	</div>
</div>

<?php get_footer() ?>