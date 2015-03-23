<?php
/**
 * Template da página inicial do site.
 * Configurar qual 'page' deverá mostrar essa listagem em 'Admin > Configurações > Leitura', item 'Página inicial:'
 * 
 * Teste de comentário para sincronização :D
 * 
 * teste de conflito: online
 * 
 */

get_header(); ?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-4 col-sm-4 col-xs-6 sidebar-offcanvas">
			<?php
			$args = array(
				'menu'         => 'Sidebar',
				'container'    => 'nav',
				'container_id' => 'offcanvas',
				'menu_class'   => 'menu-offcanvas',
				'echo'         => false,
			);
			$menu_sidebar = wp_nav_menu($args);
			echo $menu_sidebar;
			?>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12">
			<?php
			if (have_posts()){
				custom_content_nav( 'nav_above' );
				while (have_posts()){
					the_post();
					get_template_part( 'content', 'page' );
				}
			}
			?>
		</div>
	</div>
</div>


<?php get_footer() ?>