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
				<header class="entry_header">
					<h1><?php the_title(); ?></h1>
					<img src="<?php echo $thumb_src[0]; ?>" alt="" />
				</header>
				<div class="entry_content">
					<?php
					$description = get_post_meta($post->ID, 'work_description', true);
					foreach( $description as $desc ){
						$img_src = wp_get_attachment_image_src($desc['image'], 'medium');
					?>
					<div class="item-description clearfix">
						<?php if( !empty($desc['image']) ){ echo "<img src='{$img_src[0]}' alt='' class='image-{$desc['align']}' />"; } ?>
						<?php echo apply_filters('the_content', $desc['desc']); ?>
					</div>
					<?php
					}
					?>
				</div>
				
				<?php
				$gallery = get_post_meta($post->ID, 'work_gallery', true);
				if( !empty($gallery) ){
					//pre($gallery, 'gallery', false);
				?>
				<div class="single-portfolio-gallery">
					<div id="single-portfolio-gallery-owl-carousel" class="owl-carousel">
					<?php
					foreach( $gallery as $photo ){
						$photo_src = wp_get_attachment_image_src($photo['image'], 'thumbnail');
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