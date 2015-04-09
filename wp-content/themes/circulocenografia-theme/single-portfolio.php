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
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio-content'); ?>>
				<div class="entry_content">
					<?php
					$description = get_post_meta($post->ID, 'work_description', true); //pre($description);
					$i = 1;
					foreach( $description as $desc ){
						$title = '';
						if( $i == 1 ){
							$title = '<h1>' . get_the_title($post->ID) . '</h1>';
						}
						$img_src = wp_get_attachment_image_src($desc['image'], 'medium');
						
						$class = "item-description item-type-{$desc['align']} clearfix";
					?>
					<div class="<?php echo $class; ?>">
						<?php
						if( $desc['align'] != 'full' ){
							echo $title;
						}
						
						if( !empty($desc['image']) and !empty($img_src) ){
							if( $desc['align'] == 'full' ){
								echo "<div class='item-image'>{$title}<img src='{$img_src[0]}' alt='' class='image-{$desc['align']}' /></div>";
							}
							else{
								echo "<div class='item-image'><img src='{$img_src[0]}' alt='' class='image-{$desc['align']}' /></div>";
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
						echo "<a href='{$photo_large_src[0]}' target='_blank' class='gallery-link' data-sizes='{$photo_large_src[1]}x{$photo_large_src[2]}'><img src='{$photo_src[0]}' alt='{$photo['caption']}' class='img-responsive' /></a>";
					}
					?>
					</ul>
				</div>
				<?php } ?>
			</article>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>
<?php get_footer() ?>