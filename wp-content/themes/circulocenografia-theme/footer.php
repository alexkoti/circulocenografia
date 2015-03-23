


<?php wp_footer(); ?>
<?php global $template; $t = basename($template); echo "<!-- {$t} -->"; ?>
<script type="text/javascript">
$(document).ready(function () {
	$('[data-toggle="offcanvas"]').click(function () {
		$('.row-offcanvas').toggleClass('active');
	});
});
</script>
<style type="text/css">
/**
 * OFF CANVAS
 * 
 */
html,
body {
	overflow-x: hidden; /* Prevent scroll on narrow devices */
}

/* fixed menu */
body {
	padding-top:51px;
}
.navbar-toggle {
	float:left;
	margin-right:0;
	margin-left:15px;
}

@media screen and (max-width: 767px) {
	.row-offcanvas {
		position: relative;
		-webkit-transition: all .25s ease-out;
		     -o-transition: all .25s ease-out;
		        transition: all .25s ease-out;
	}
	
	.row-offcanvas-right {
		right: 0;
	}
	
	.row-offcanvas-left {
		left: 0;
	}
	
	.row-offcanvas-right
	.sidebar-offcanvas {
		right: -50%; /* 6 columns */
	}
	
	.row-offcanvas-left
	.sidebar-offcanvas {
		left: -50%; /* 6 columns */
	}
	
	.row-offcanvas-right.active {
		right: 50%; /* 6 columns */
	}
	
	.row-offcanvas-left.active {
		left: 50%; /* 6 columns */
	}
	
	.sidebar-offcanvas {
		position: absolute;
		top: 0;
		width: 50%; /* 6 columns */
	}
}

@media screen and (max-width: 480px) {
	.row-offcanvas-right
	.sidebar-offcanvas {
		right: -90%; /* 6 columns */
	}
	
	.row-offcanvas-left
	.sidebar-offcanvas {
		left: -90%; /* 6 columns */
	}
	
	.row-offcanvas-right.active {
		right: 90%; /* 6 columns */
	}
	
	.row-offcanvas-left.active {
		left: 90%; /* 6 columns */
	}
	
	.sidebar-offcanvas {
		position: absolute;
		top: 0;
		width: 90%; /* 6 columns */
	}
}
</style>
</body>
</html>
