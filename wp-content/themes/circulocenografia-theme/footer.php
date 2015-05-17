

<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php opt_option('site_footer_text', '%s', true, 'the_content'); ?>
			</div>
		</div>
	</div>
</footer>

<?php if( is_singular('portfolio') ){photo_swipe_box();} ?>
<?php wp_footer(); ?>
<?php global $template; $t = basename($template); echo "<!-- {$t} -->"; ?>
</body>
</html>
