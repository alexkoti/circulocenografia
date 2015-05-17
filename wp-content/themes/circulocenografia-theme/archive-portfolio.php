<?php get_header(); ?>
		
<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<div id="portfolio-box">
				<?php
				// verificar se a categoria foi definida por url query
				$category_active = false;
				$all_cats_class = 'active';
				if( isset($_GET['categoria']) ){
					$category_active = $_GET['categoria'];
					$all_cats_class = '';
				}
				?>
				<div class="portfolio-category <?php echo $all_cats_class; ?>" id="portfolio-categories-list">
					<ul class="portfolio-category-items row">
					<?php
					$i = 1;
					$ports = get_terms('portfolio_category', array('hide_empty' => false, 'orderby' => 'term_order'));
					foreach( $ports as $cat ){
						$thumb = get_metadata('term', $cat->term_id, 'category_thumbnail', true);
						if( !empty($thumb) ){
							$thumb_src = wp_get_attachment_image_src($thumb, 'post-thumbnail');
							$img = "<img src='{$thumb_src[0]}' alt='' class='img-responsive' />";
						}
						else{
							$img = "<img src='".CSS_IMG."/cat-placeholder.jpg' alt='' class='img-responsive' />";
						}
						echo "<li class='col-md-4 col-sm-4 col-xs-6'><div class='portfolio-item-content'>{$img}<div class='portfolio-item-title'>{$cat->name}</div><span class='portfolio-item-link' id='portfolio-category-circles-{$cat->term_id}' data-target='portfolio-category-{$cat->term_id}' data-related-menu-link='portfolio-link-category-{$cat->term_id}' data-hstate='{$cat->slug}'></span></div></li>";
						//if( $i % 4 == 0 ){ echo '<li class="circle-divider divider-4 col-md-12 visible-lg-block visible-md-block"></li>'; }
						if( $i % 3 == 0 ){ echo '<li class="circle-divider divider-3 col-xs-12 visible-sm-block"></li>'; }
						if( $i % 2 == 0 ){ echo '<li class="circle-divider divider-2 col-xs-12 visible-xs-block"></li>'; }
						$i++;
					}
					?>
					</ul>
				</div>
				
				<?php
				/**
				 * Lista oculta de categorias com os respectivos itens
				 * 
				 */
				$ports = get_terms('portfolio_category', array('hide_empty' => false, 'orderby' => 'term_order'));
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
						$class = 'portfolio-category';
						if( $category_active == $cat->slug ){
							$class = 'portfolio-category active';
						}
						$i = 1;
						echo "<div class='{$class}' id='portfolio-category-{$cat->term_id}'><ul class='portfolio-category-items row'>";
						foreach( $items->posts as $post ){
							$img = '';
							$thumb = get_post_meta($post->ID, '_thumbnail_id', true);
							if( !empty($thumb) ){
								$thumb_src = wp_get_attachment_image_src($thumb, 'post-thumbnail');
								$img = "<img src='{$thumb_src[0]}' alt='' class='img-responsive' />";
							}
							$link = get_permalink($post->ID);
							echo "<li class='col-md-4 col-sm-4 col-xs-6'><div class='portfolio-item-content'>{$img}<div class='portfolio-item-title'>{$post->post_title}</div><a href='{$link}' class='portfolio-item-link'></a></div></li>";
							//if( $i % 4 == 0 ){ echo '<li class="circle-divider divider-4 col-md-12 visible-lg-block visible-md-block"></li>'; }
							if( $i % 3 == 0 ){ echo '<li class="circle-divider divider-3 col-xs-12 visible-sm-block"></li>'; }
							if( $i % 2 == 0 ){ echo '<li class="circle-divider divider-2 col-xs-12 visible-xs-block"></li>'; }
							$i++;
						}
						echo '</ul></div>';
					}
					else{
						echo "<div class='portfolio-category' id='portfolio-category-{$cat->term_id}'>Sem resultados nesta categoria</div>";
					}
					wp_reset_query();
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer() ?>