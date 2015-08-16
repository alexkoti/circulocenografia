<?php get_header(); ?>


<div class="container">
	<div class="row row-offcanvas row-offcanvas-left">
		<div class="col-md-3 col-sm-4 col-xs-6 sidebar-offcanvas" id="offcanvas-sidebar">
			<?php get_template_part('menu-lateral'); ?>
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12" id="offcanvas-content">
			<?php
			if (have_posts()){
				custom_content_nav( 'nav_above' );
				while (have_posts()){
					the_post();
					$thumb = get_post_meta($post->ID, '_thumbnail_id', true);
					$thumb_src = wp_get_attachment_image_src($thumb, 'column_full');
					$categories = wp_get_object_terms($post->ID, 'portfolio_category');
					$back_link = add_query_arg( array('categoria' => $categories[0]->slug), get_post_type_archive_link('portfolio') );
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio-content clearfix'); ?>>
				<h1><?php the_title(); ?> <span class="back-link"><a href="<?php echo $back_link; ?>" class="btn btn-default btn-sm">« voltar</a></span></h1>
				<div class="entry_content">
					<?php
					$description = get_post_meta($post->ID, 'work_description', true); //pre($description);
					$i = 1;
					foreach( $description as $desc ){
						$image_size = ($desc['align'] == 'full') ? 'large' : 'medium';
						$img_src = wp_get_attachment_image_src($desc['image'], $image_size);
						$img_large_src = wp_get_attachment_image_src($desc['image'], 'large');
						
						// class tipo de item
						$class = "item-description item-type-{$desc['align']} clearfix";
						
						// class bordas arredondadas
						if( isset($desc['border']) ){
							$class .= ' border-radius';
						}
					?>
					<div class="<?php echo $class; ?>">
						<?php
						if( isset($desc['video']) and !empty($desc['video']) ){
							echo "<div class='portfolio-video video-align-{$desc['align']}'>";
							echo apply_filters('the_content', $desc['video']);
							echo '</div>';
							if( isset($desc['video_extra']) and !empty($desc['video_extra']) ){
								echo "<div class='portfolio-video video-align-{$desc['align']}'>";
								echo apply_filters('the_content', $desc['video_extra']);
								echo '</div>';
							}
						}
						elseif( !empty($desc['image']) and !empty($img_src) ){
							if( !empty($desc['image_extra']) ){
								$img_extra_src = wp_get_attachment_image_src($desc['image_extra'], 'medium');
								$img_extra_large_src = wp_get_attachment_image_src($desc['image_extra'], 'large');
								echo "<div class='item-image extra-image'><a href='{$img_large_src[0]}' target='_blank' class='lightbox-link' data-sizes='{$img_large_src[1]}x{$img_large_src[2]}'><img src='{$img_src[0]}' alt='' class='image-half image-half-left' /></a><a href='{$img_extra_large_src}' target='_blank' class='gallery-link' data-sizes='{$img_extra_large_src[1]}x{$img_extra_large_src[2]}'><img src='{$img_extra_src[0]}' alt='' class='image-half image-half-right' /></a></div>";
							}
							elseif( $desc['align'] == 'full' ){
								echo "<div class='item-image'><a href='{$img_large_src[0]}' target='_blank' class='lightbox-link' data-sizes='{$img_large_src[1]}x{$img_large_src[2]}'><img src='{$img_src[0]}' alt='' class='image-{$desc['align']}' /></a></div>";
							}
							else{
								echo "<div class='item-image'><a href='{$img_large_src[0]}' target='_blank' class='lightbox-link' data-sizes='{$img_large_src[1]}x{$img_large_src[2]}'><img src='{$img_src[0]}' alt='' class='image-{$desc['align']}' /></a></div>";
							}
						}
						
						echo apply_filters('the_content', $desc['desc']); ?>
					</div>
					<?php
						$i++;
					}
					?>
				</div>
				
				<?php
				$gallery = boros_trim_array(get_post_meta($post->ID, 'work_gallery', true));
				if( !empty($gallery) ){
					//pre($gallery, 'gallery', false);
				?>
				<div class="single-portfolio-gallery">
					<h2>Galeria</h2>
					<div id="single-portfolio-gallery-owl-carousel" class="owl-carousel">
					<?php
					foreach( $gallery as $photo ){
						$photo_src = wp_get_attachment_image_src($photo['image'], 'post-thumbnail');
						$photo_large_src = wp_get_attachment_image_src($photo['image'], 'large');
						echo "<a href='{$photo_large_src[0]}' target='_blank' class='lightbox-link gallery-link' data-sizes='{$photo_large_src[1]}x{$photo_large_src[2]}'><img src='{$photo_src[0]}' alt='{$photo['caption']}' class='img-responsive' /></a>";
					}
					?>
					</div>
				</div>
				<?php } ?>
				<span class="back-link"><a href="<?php echo $back_link; ?>" class="btn btn-default btn-sm">« voltar</a></span>
			</article>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>
<?php get_footer() ?>