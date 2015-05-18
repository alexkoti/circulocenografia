<?php
/**
 * Templpate para resultado da busca.
 * Estudar as soluções apresentadas nesse artigo(ver comentários também): http://wpengineer.com/2258/change-the-search-url-of-wordpress/
 * 
 */

get_header(); ?>

<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<h2>Resultados da busca para <strong><?php echo get_search_query(); ?></strong></h2>
			<?php if (have_posts()){ ?>
			
			<div class="row search-results">
			<?php
			$search_term = esc_attr(apply_filters('the_search_query', get_search_query()));
			while (have_posts()){
				the_post();
				$link = get_permalink();
			?>
				<div class="col-md-12 search-result-item">
					<div class="row">
						<h3 class="col-md-12"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h3>
						<?php
						if( in_array($post->post_type, array('post', 'page')) ){
							echo '<div class="col-md-12">';
							the_excerpt();
							echo '</div>';
						}
						elseif( $post->post_type == 'portfolio' ){
							$work_description = get_post_meta($post->ID, 'work_description', true); 
							$thumb = get_post_meta($post->ID, '_thumbnail_id', true);
							if( !empty($thumb) ){
								$thumb_src = wp_get_attachment_image_src($thumb, 'post-thumbnail');
								echo "<div class='col-md-3'><a href='{$link}' class='search-result-thumb'><img src='{$thumb_src[0]}' alt='' class='img-responsive' /></a></div>";
							}
							echo '<div class="col-md-9">';
							// tentar achar uma das descrições com o termo
							$find = false;
							foreach( $work_description as $desc ){
								// fazer a busca do termo em lowercase
								if( strpos(strtolower($desc['desc']), strtolower($search_term)) !== false ){
									echo apply_filters('the_content', $desc['desc']);
									$find = true;
								}
							}
							// caso não tenha encontrado nas descrições, mostrar o primeiro bloco
							if( $find == false ){
								$show = false;
								foreach( $work_description as $desc ){
									if( !empty($desc['desc']) and $show == false ){
										echo apply_filters('the_content', $desc['desc']);
										$show = true;
										continue;
									}
								}
							}
							echo '</div>';
						}
						?>
					</div>
				</div>
			<?php
			}
			custom_content_nav( 'nav_below' );
			?>
			</div>
			<?php } else { ?>
				<article class="post hentry no-results not-found">
					<header class="entry_header">
						<h2>Sem resultados</h2>
					</header>
					<div class="entry_content">
						Não foram encontrados resultados para essa requisição :(
					</div>
				</article>
				<?php
			}
			?>
		</div>
	</div>
</div>
<?php get_footer() ?>