
<div class="row row-offcanvas row-offcanvas-left">
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="menu-footer">
						<?php formatted_page_link(array('page_name' => 'inicio', 'list' => true)); ?>
						<?php formatted_page_link(array('page_name' => 'nos', 'list' => true)); ?>
						<?php formatted_post_type_link(array('post_type' => 'portfolio', 'list' => true)); ?>
						<?php formatted_page_link(array('page_name' => 'cursos', 'list' => true)); ?>
						<?php formatted_page_link(array('page_name' => 'na-midia', 'list' => true)); ?>
						<?php formatted_post_type_link(array('post_type' => 'post', 'text' => 'Blog', 'list' => true)); ?>
						<?php formatted_page_link(array('page_name' => 'projeto-cultural', 'list' => true)); ?>
						<?php formatted_page_link(array('page_name' => 'clientes', 'list' => true)); ?>
						<?php formatted_page_link(array('page_name' => 'contato', 'list' => true)); ?>
					</ul>
				</div>
				<div class="col-md-12">
					<?php opt_option('site_footer_text', '%s', true, 'the_content'); ?>
				</div>
			</div>
		</div>
	</footer>
</div>

<?php if( is_singular('portfolio') ){photo_swipe_box();} ?>
<?php wp_footer(); ?>
<?php global $template; $t = basename($template); echo "<!-- {$t} -->"; ?>
</body>
</html>
