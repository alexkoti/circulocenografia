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
	add_action( 'wp_enqueue_scripts', 'add_frontend_scripts' );   // adicionar styles ao header
	add_action( 'init', 'add_frontend_scripts' );             // adicionar scripts ao header
	add_action( 'wp_head', 'work_opengraph', 99 );            // iniciar o opengraph, caso esteja ativado
	remove_action('wp_head', 'wp_generator');                 // remover a assinatura de versão do wordpress
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
	$css = new BorosCss(array('ver' => THEME_VERSION));
	$css->vendor('bootstrap.min', 'bootstrap/css');
	$css->add('wp');
	//$css->add('photoswipe');
	//$css->add('default-skin', 'photoswipe-default-skin');
	//$css->add('owl.carousel');
	//$css->add('owl.theme');
	//$css->add('owl.transitions');
	$css->vendor('owl.carousel', 'owl.carousel/owl-carousel');
	$css->vendor('owl.theme', 'owl.carousel/owl-carousel');
	$css->vendor('owl.transitions', 'owl.carousel/owl-carousel');
    $css->vendor('photoswipe', 'PhotoSwipe/dist');
    $css->vendor('default-skin', 'PhotoSwipe/dist/default-skin');
	$css->add('circulo-cenografia');
	
	if( defined('LOCALHOST') and LOCALHOST == true ){
		$css->add('responsive_debug');
	}
	
	/* MODELO absolute / google fonts */
	$args = array(
		'name' => 'font-raleway',
		'src' => 'https://fonts.googleapis.com/css?family=Raleway:500,700,400',
		'parent' => false,
		'version' => '1',
		'media' => 'screen',
	);
	$css->abs($args);
	/**/
	
	/** MODELOS
	//simples, sem dependencia
	$css->add('forms');
	
	//encadeamento de 2 styles child
	$css->add('lightbox', 'lightbox')->child('lights', 'lightbox/themes')->child('shadows', 'lightbox/themes')->media('all');
	
	//subpasta, media print, alternate stylesheet
	$css->add('animations', 'anims')->media('print')->alt();
	
	//ies, encadeando child ie6 condicional
	$css->add('ies', 'ie', 'all')->child('ie6', 'ie', 'handheld')->cond('lte IE 8');
	
	//child de ies, media all, condicional
	$css->child('ie7', 'ie', 'all', 'ies')->cond('lte 8');
	
	//debug
	global $wp_styles;pre($wp_styles);
	/**/
    
	$js = new BorosJs(array('ver' => THEME_VERSION));
	$js->jquery('jquery.validate.min', 'libs');
	//$js->jquery('bootstrap.min', 'libs');
	//$js->jquery('photoswipe.min', 'libs');
	//$js->jquery('photoswipe-ui-default.min', 'libs');
	//$js->jquery('owl.carousel.min', 'libs');
	$js->jquery('jquery.history', 'libs');
    
    
	$js->vendor('bootstrap.min', 'bootstrap/js');
    $js->vendor('photoswipe', 'PhotoSwipe/dist');
    $js->vendor('photoswipe-ui-default', 'PhotoSwipe/dist');
    $js->vendor('owl.carousel.min', 'owl.carousel/owl-carousel');
	$js->jquery('functions');
	//$js->add('modernizr', 'libs', false, false);
	//$js->add('html5', 'libs', false, false);
	
	/**
	$js->jquery('myjqueryfuncs');                      //jquery novo
	$js->jquery('jquery-ui-core');                     //jquery já registrado
	$js->add('effects');                               //simples
	$js->add('lightbox', 'lightbox');                  //simples subpasta
	$js->add('thickbox')->child('extendthick');        //encadeado, simples
	$js->add('thickbox')->child('extendthick', 'ext'); //encadeado, subpasta
	global $wp_scripts;pre($wp_scripts); //debug
	/**/
	
	// enqueues comuns/absolutos
	/**
	wp_enqueue_script(
		$handle = 'twitter_api', 
		$src = 'http://platform.twitter.com/widgets.js', 
		$deps = false, 
		$ver = null, 
		$in_footer = true
	);
	wp_enqueue_script(
		$handle = 'facebook_api', 
		$src = 'http://connect.facebook.net/pt_BR/all.js#xfbml=1', 
		$deps = false, 
		$ver = null, 
		$in_footer = true
	);
	/**/
}



