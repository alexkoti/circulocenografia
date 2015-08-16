<?php
/**
 * Funções e configurações gerais, que são atreladas ao tema, mas afetam tanto o admin como o frontend.
 * 
 * 
 */

/**
 * Adicionar CSS as editor tiny_mce, integrando com o CSS do frontend
 * 
 */
add_filter( 'after_setup_theme', 'boros_setup_theme' );
function boros_setup_theme(){
	// CSS integrando com o frontend
	add_editor_style( 'css/wp.css' );
	// CSS inspirado no WYM-Editor
	add_editor_style( 'css/wym-editor.css' );
}

// Adicionar suporte aos feeds
add_theme_support( 'automatic-feed-links' );

// Esconder a barra de admin do admin/frontend
add_filter( 'show_admin_bar', '__return_false' );
