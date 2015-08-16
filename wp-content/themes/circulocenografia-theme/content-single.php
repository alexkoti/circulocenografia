
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
					<?php single_post_nav('nav-above'); ?>
					<header class="entry_header clearfix">
						<h1><?php the_title(); ?></h1>
						<?php post_meta_posted_on(); ?>
					</header>
					<div class="entry_content clearfix">
						<?php the_content(); ?>
					</div>
					<?php single_post_nav('nav-below'); ?>
					<?php comments_template( '', true ); ?>
				</article>