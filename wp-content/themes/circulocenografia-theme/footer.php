

<footer class="footer">
	<div class="container">
		<p>rodapé</p>
	</div>
</footer>

<?php if( is_singular('portfolio') ){photo_swipe_box();} ?>
<?php wp_footer(); ?>
<?php global $template; $t = basename($template); echo "<!-- {$t} -->"; ?>
</body>
</html>
