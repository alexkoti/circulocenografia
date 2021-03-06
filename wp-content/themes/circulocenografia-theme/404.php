<?php
/**
 * Template para página 'not found', qualquer caso.
 * 
 */

get_header(); ?>
<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<h1>Conteúdo não encontrado.</h1>
			<?php the_widget( 'WP_Widget_Search', array('title' => 'Faça uma busca pelo que procura') ); ?> 
		</div>
	</div>
</div>
<?php get_footer() ?>