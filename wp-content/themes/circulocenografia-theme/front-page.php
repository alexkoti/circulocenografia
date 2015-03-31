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
		<div class="col-md-4 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12" id="offcanvas-content">
			<!-- img src="http://placehold.it/780x400" class="img-responsive" alt="" / -->
			
			<div id="portfolio-box">
				<?php
				$i = 1;
				$ports = get_terms('portfolio_category', array('hide_empty' => false));
				foreach( $ports as $cat ){
					//pre($cat, 'cat', false);
					$args = array(
						'post_type' => 'portfolio',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
								'taxonomy' => 'portfolio_category',
								'field' => 'term_id',
								'terms' => $cat->term_id,
							),
						),
					);
					$items = new WP_Query($args);
					if( $items->posts ){
						$class = ($i == 1) ? 'portfolio-category active' : 'portfolio-category';
						echo "<div class='{$class}' id='portfolio-category-{$cat->term_id}'><ul class='portfolio-category-items row'>";
						foreach( $items->posts as $post ){
							$img = '';
							$thumb = get_post_meta($post->ID, '_thumbnail_id', true);
							if( !empty($thumb) ){
								$thumb_src = wp_get_attachment_image_src($thumb, 'post-thumbnail');
								$img = "<img src='{$thumb_src[0]}' alt='' class='img-responsive' />";
							}
							$link = get_permalink($post->ID);
							echo "<li class='col-md-3 col-sm-4 col-xs-6'>{$img}<div class='portfolio-item-title'>{$post->post_title}</div><a href='{$link}'></a></li>";
						}
						echo '</ul></div>';
					}
					else{
						echo "<div class='portfolio-category' id='portfolio-category-{$cat->term_id}'>Sem resultados nesta categoria</div>";
					}
					$i++;
				}
				?>
			</div>
			
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