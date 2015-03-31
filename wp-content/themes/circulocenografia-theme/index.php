<?php
/**
 * Template geral do site.
 * 
 * Será usado sempre em última instância, caso nenhum dos outros templates satisfaça a condição pedida.
 * @link	http://codex.wordpress.org/Template_Hierarchy
 * 
 */

get_header(); ?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-4 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php
			//$args = array(
			//	'menu'         => 'Sidebar',
			//	'container'    => 'nav',
			//	'container_id' => 'offcanvas',
			//	'menu_class'   => 'menu-offcanvas',
			//	'echo'         => false,
			//);
			//$menu_sidebar = wp_nav_menu($args);
			//echo $menu_sidebar;
			?>
			<nav id="offcanvas" class="menu-sidebar-container">
				<ul id="menu-sidebar" class="menu-offcanvas">
					<?php
					formatted_page_link(array('page_name' => 'Início', 'list' => true));
					?>
					<li>
						<span>Portfolio</span>
						<ul>
							<?php
							$ports = get_terms('portfolio_category', array('hide_empty' => false));
							foreach( $ports as $cat ){
								//pre($cat, 'cat', false);
								formatted_term_link(array('list' => true), $cat);
							}
							?>
						</ul>
					</li>
			</ul></nav>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12" id="offcanvas-content">
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