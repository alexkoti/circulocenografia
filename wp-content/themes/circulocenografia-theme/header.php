<!doctype html>
<!--[if lt IE 7 ]> <html lang="pt" class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html lang="pt" class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html lang="pt" class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html lang="pt" class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="geo.country" content="br" />
<meta name="description" content="<?php bloginfo('description'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="icon" type="image/png" href="<?php echo CSS_IMG; ?>/favicon_mam.png" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="home" href="<?php site_url('/'); ?>" />
<title><?php
global $page, $paged;
$title = wp_title( '|', true, 'right' );

// Add the blog name.
bloginfo( 'name' );

// Add the blog description for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
	echo " | $site_description";

// Add a page number if necessary:
if ( $paged >= 2 || $page >= 2 )
	echo ' | ' . sprintf( 'Página %s', max( $paged, $page ) );
?></title>
<?php
if ( is_singular() && get_option( 'thread_comments' ) ){ wp_enqueue_script( 'comment-reply' ); }
wp_head();
?>
</head>

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
			<?php
			$query = esc_attr(apply_filters('the_search_query', get_search_query()));
			$value = ( $query == '' ) ? '' : $query;
			?>
			<form class="navbar-form navbar-right" id="header-search" role="search" action="<?php echo home_url('/'); ?>">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Busca" name="s" value="<?php echo $value; ?>">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php page_permalink_by_name('blog');  ?>">Blog</a></li>
				<li><a href="<?php page_permalink_by_name('contato');  ?>" title="Contato"><i class="glyphicon glyphicon-envelope"></i></a></li>
			</ul>
		</div>
	</div>
</nav>
