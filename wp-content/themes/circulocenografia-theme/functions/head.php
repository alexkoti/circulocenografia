<?php
/**
 * CONFIGURAÇÔES PARA O HEAD DO FRONTEND
 * Configurações a serem aplicadas do <head> do frontend, basicamente são as adições dos javascripts e stylesheets, 
 * mas incluindo as manipulações de qualquer elemento do <head>, como description, keywords, rels diversos, etc
 * Jquery e scripts dependentes são declarados aqui, mesmo sendo renderizados no final no wp_footer();
 * 
 * 
 * 
 */

/**
 * ==================================================
 * ADD ACTIONS/FILTERS ==============================
 * ==================================================
 * 
 * 
 */
if( !is_admin() ){
	add_action( 'init', 'add_frontend_scripts' );  // adicionar scripts ao header
	add_action( 'wp_head', 'work_opengraph', 99 ); // iniciar o opengraph, caso esteja ativado
	remove_action('wp_head', 'wp_generator');      // remover a assinatura de versão do wordpress
}

function work_opengraph(){
	if( get_option('og_active') == true ){
		opengraph_tags();
	}
}



/**
 * ==================================================
 * CSS CUSTOMIZADO PARA O HEAD ======================
 * ==================================================
 * 
 * 
 */
add_action( 'wp_head', 'circulo_custom_colors' );
function circulo_custom_colors(){
	
	// barra de menu personalizada
	$site_logo = get_option('site_logo');
	if( !empty($site_logo) ){
		if( $site_logo <= 4 ){
			echo "<style type='text/css'>#menu-top {background-color:#000}</style>";
		}
		else{
			echo "<style type='text/css'>#menu-top {background-color:#fff}</style>";
		}
	}
	
	// cor e bg para páginas especiais
	if( is_singular('portfolio') ){
		global $post;
		$work_color_bg = get_post_meta($post->ID, 'work_color_bg', true);
		$work_color_text = get_post_meta($post->ID, 'work_color_text', true);
		
		if( !empty($work_color_bg) and !empty($work_color_text) ){
			$css = array(
				'body, #offcanvas-sidebar' => array(
					'background-color' => $work_color_bg,
					'color'            => $work_color_text,
				),
				'#offcanvas a, #offcanvas ul li#portfolio-submenu .category-link' => array(
					'color' => $work_color_text,
				),
				'.back-link .btn' => array(
					'color'        => $work_color_text,
					'border-color' => $work_color_text,
				),
				'.back-link .btn:hover' => array(
					'background-color' => boros_color_hex_to_rgba($work_color_text, 0.3),
				),
				'.footer .menu-footer li a' => array(
					'color' => $work_color_text
				),
			);
			boros_print_css($css);
		}
	}
}



/**
 * ==================================================
 * STYLESHEETS ======================================
 * ==================================================
 * 
 * 
 */
function add_frontend_scripts(){
    $css = new BorosCss();
    $css->vendor('bootstrap.min', 'bootstrap/css');
	$css->vendor('photoswipe', 'PhotoSwipe/dist');
	$css->vendor('default-skin', 'PhotoSwipe/dist/default-skin');
    $css->vendor('owl.carousel', 'owl.carousel/assets');
    $css->vendor('owl.theme', 'owl.carousel/assets');
    $css->vendor('owl.transitions', 'owl.carousel/assets');
    $css->add('wp');
    $css->add('circulo-cenografia');
    
    if( defined('LOCALHOST') and LOCALHOST == true ){
        $css->add('responsive_debug');
    }
    
    /* MODELO absolute / google fonts */
    $args = array(
        'name' => 'font-raleway',
        'src' => 'http://fonts.googleapis.com/css?family=Raleway:500,700,400',
        'parent' => false,
        'version' => '1',
        'media' => 'screen',
    );
    $css->abs($args);
    
    $js = new BorosJs();
	$js->vendor('bootstrap.min', 'bootstrap/js');
	$js->vendor('photoswipe', 'PhotoSwipe/dist');
	$js->vendor('photoswipe-ui-default', 'PhotoSwipe/dist');
    $js->vendor('owl.carousel.min', 'owl.carousel');
    $js->vendor('jquery.history', 'jquery.history');
    $js->jquery('functions');
}



