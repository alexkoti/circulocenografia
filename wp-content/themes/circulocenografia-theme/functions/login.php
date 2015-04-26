<?php
/**
 * CONFIGURAÇÔES DE LOGIN
 * Configuração para a página de login
 * 
 * 
 * 
 */

// adicionar css
add_action( 'login_head', 'custom_login_head' );
function custom_login_head(){
	echo '<link rel="stylesheet" type="text/css" href="' . THEME . '/css/login.css" />';
	$site_logo_src = CSS_IMG . '/circulo-cenografia-logo.png';
	$site_logo = get_option('site_logo');
	if( !empty($site_logo) ){
		$site_logo_src = CSS_IMG . "/circulo-cenografia-logo-{$site_logo}.png";
	}
	echo "<style type='text/css'>.login h1 a {background-image:url({$site_logo_src});}</style>";
}

// link do logo
add_filter( 'login_headerurl', 'custom_login_headerurl' );
function custom_login_headerurl(){
	return home_url();
}

// atributo title no logo -> o texto sempre será o nome do site
add_filter( 'login_headertitle', 'custom_login_headertitle' );
function custom_login_headertitle(){
	return get_bloginfo('name');
}