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
			<?php
			$slider_raw = boros_trim_array(get_option('sliders'));
			$slider = array();
			foreach( $slider_raw as $s ){
				if( isset($s['active']) ){
					$slider[] = $s;
				}
			}
			if( !empty($slider) ){
			?>
			<div id="home-carousel-box">
				<div class="owl-carousel clearfix" id="home-carousel">
					<?php
					$i = 0;
					foreach( $slider as $s ){
						$class = ($i == 0) ? 'item clearfix active' : 'item clearfix';
						$video = isset($s['video']) ? $s['video'] : false;
						$image = isset($s['image']) ? wp_get_attachment_image_src( $s['image'], $sizes[$size]) : array('');
					?>
					<div id="<?php echo "{$carousel_name}_item_{$i}"; ?>" class="<?php echo $class; ?>">
						<?php
						if( $video === false ){
							if( !empty($s['link']) ){
								$link = apply_filters('the_permalink', $s['link']);
								echo "<a href='{$link}'><img alt='' src='{$image[0]}' class='img-responsive'></a>";
							}
							else{
								echo "<img alt='' src='{$image[0]}' class='img-responsive'>";
							}
						}
						else{
							echo apply_filters('the_content', $video);
						}
						if( !empty($s['text']) ){
							echo '<div class="titulo_menu_image">';
							echo apply_filters('the_content', $s['text']);
							echo '</div>';
						}
						?>
					</div>
					<?php
						$i++;
					}
					?>
				</div><!-- /carousel -->
			</div>
			<?php
			} else {
				echo 'Em construção';
			}
			?>
		</div>
	</div>
</div>

<?php get_footer() ?>