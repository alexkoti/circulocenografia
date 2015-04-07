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
						<img src="<?php echo $img_src[0]; ?>" class="image-<?php echo $desc['align']; ?>" alt="" />
						<?php echo apply_filters('the_content', $desc['desc']); ?>
					</div>
					<?php
					}
					?>
				</div>
			</article>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>
<?php get_footer() ?>