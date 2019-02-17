<?php get_template_part('head'); ?>

<body <?php body_class(); ?>>

<nav class="navbar navbar-default navbar-fixed-top" id="menu-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="offcanvas">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a id="logo-header" href="<?php echo home_url('/'); ?>">
				<?php
				$site_logo_src = CSS_IMG . '/circulo-cenografia-logo.png';
				$site_logo = get_option('site_logo');
				if( !empty($site_logo) ){
					$site_logo_src = CSS_IMG . "/circulo-cenografia-logo-{$site_logo}.png";
				}
				?>
				<img src="<?php echo $site_logo_src; ?>" alt="logo Círculo Cenografia" />
			</a>
		</div>
		
		<div id="menu-top-secondary" class="hidden-xs" aria-expanded="true">
			<?php echo circulo_search_form('header-search', 'navbar-form navbar-right'); ?>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php page_permalink_by_name('blog');  ?>">Blog</a></li>
				<li><a href="<?php page_permalink_by_name('contato');  ?>" title="Contato"><i class="glyphicon glyphicon-envelope"></i></a></li>
			</ul>
		</div>
	</div>
</nav>
