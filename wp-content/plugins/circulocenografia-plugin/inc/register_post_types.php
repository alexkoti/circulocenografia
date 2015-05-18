<?php
/**
 * REGISTER POST TYPES
 * Configurações para adicionar custom post_types. Este arquivo trabalha em conjunto com o 'register_taxonomies.php'
 * 
 */

/**
 * ==================================================
 * ADICIONAR SUPORTE Á POST FORMATS =================
 * ==================================================
 * Isso irá permitir o tema usar post_formats para os 'posts' padrão do wordpress. Caso sej apreciso adicionar esse recurso a outros post_types, usar add_post_type_support()
 * Se for preciso adicionar post_formats a um post_type e ao mesmo tempo não dar suporte aos posts comnuns, é preciso primeiro habilitar os post_formats ao tema, usando
 * add_theme_support(), adicionar o suporte ao post_type desejado e só então desabilitar os formats para posts, com remove_post_type_support().
 */
//add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
//add_post_type_support( 'page', 'post-formats' );
//remove_post_type_support( 'post', 'post-formats' );

/**
 * ==================================================
 * REGISTER POST TYPES ==============================
 * ==================================================
 * 
 * 
 */
add_action( 'init', 'register_post_types' );
function register_post_types(){
	/**
	 * Noticias
	 * 
	 *
	$labels = array(
		'name' => 'Notícias',
		'singular_name' => 'Notícia',
		'menu_name' => 'Noticias',
		'add_new' => 'Nova Notícia',
		'add_new_item' => 'Adicionar Notícia',
		'edit_item' => 'Editar Notícia',
		'new_item' => 'Nova Notícia',
		'view_item' => 'Ver Notícia',
		'search_items' => 'Buscar Notícia',
		'not_found' =>  'Nenhum encontrada',
		'not_found_in_trash' => 'Nenhum encontrada na lixeira',
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Notícias gerais',
		'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'capabilities' => array( 
			'edit_post'              => 'edit_post',
			'read_post'              => 'read_post',
			'delete_post'            => 'delete_post',
			'edit_posts'             => 'edit_posts',
			'edit_others_posts'      => 'edit_others_posts',
			'publish_posts'          => 'publish_posts',
			'read_private_posts'     => 'read_private_posts',
			'delete_posts'           => 'delete_posts',
			'delete_private_posts'   => 'delete_private_posts',
			'delete_published_posts' => 'delete_published_posts',
			'delete_others_posts'    => 'delete_others_posts',
			'edit_private_posts'     => 'edit_private_posts',
			'edit_published_posts'   => 'edit_published_posts',
			'create_posts'           => 'edit_posts',
			'read'                   => 'read',
		), 
		'hierarchical' => false,
		'has_archive' => 'noticias',
		'menu_icon' => 'dashicons-calendar',
		//'show_in_menu' => 'edit.php?post_type=artigo',
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'comments',
		)
	); 
	register_post_type( 'noticia' , $args );
	$columns_config = array(
		'post_type' => 'noticia',
		'columns' => array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Título',
			'terms_list_regiao' => 'Regiões',
			'date' => 'Data',
		)
	);
	new BorosPostTypeColumns( $columns_config );
	/**/
	
	/**
	 * PORTFOLIO
	 * 
	 */
	$labels = array(
		'name' => 'Portfolio',
		'singular_name' => 'Portfolio',
		'menu_name' => 'Portfolio',
		'add_new' => 'Novo Item do Portfolio',
		'add_new_item' => 'Adicionar Item do Portfolio',
		'edit_item' => 'Editar Item do Portfolio',
		'new_item' => 'Novo Item do Portfolio',
		'view_item' => 'Ver Item do Portfolio',
		'search_items' => 'Buscar Item do Portfolio',
		'not_found' =>  'Nenhum encontrado',
		'not_found_in_trash' => 'Nenhum encontrado na lixeira',
		'parent_item_colon' => '',
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Portfolio',
		'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'has_archive' => 'portfolio',
		'menu_icon' => 'dashicons-art',
		//'show_in_menu' => 'edit.php?post_type=artigo',
		'supports' => array(
			'title',
			'thumbnail',
		)
	); 
	register_post_type( 'portfolio' , $args );
	$columns_config = array(
		'post_type' => 'portfolio',
		'columns' => array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Título',
			'terms_portfolio_category' => 'Categorias',
			'thumb' => 'Imagem',
			'date' => 'Data',
		)
	);
	new BorosPostTypeColumns( $columns_config );
	
	
	
	/**
	 * CURSOS
	 * 
	 */
	$labels = array(
		'name' => 'Cursos',
		'singular_name' => 'Curso',
		'menu_name' => 'Cursos',
		'add_new' => 'Novo Curso',
		'add_new_item' => 'Adicionar Curso',
		'edit_item' => 'Editar Curso',
		'new_item' => 'Novo Curso',
		'view_item' => 'Ver Curso',
		'search_items' => 'Buscar Curso',
		'not_found' =>  'Nenhum encontrado',
		'not_found_in_trash' => 'Nenhum encontrado na lixeira',
		'parent_item_colon' => '',
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Cursos',
		'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => 'cursos',
		'menu_icon' => 'dashicons-welcome-learn-more',
		//'show_in_menu' => 'edit.php?post_type=artigo',
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		)
	); 
	register_post_type( 'curso' , $args );
	$columns_config = array(
		'post_type' => 'curso',
		'columns' => array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Título',
			'date' => 'Data',
		)
	);
	new BorosPostTypeColumns( $columns_config );
	
	
	
	/**
	 * NA MÍDIA
	 * 
	 */
	$labels = array(
		'name' => 'Clipping',
		'singular_name' => 'Clipping',
		'menu_name' => 'Na Mídia',
		'add_new' => 'Novo Clipping',
		'add_new_item' => 'Adicionar Clipping',
		'edit_item' => 'Editar Clipping',
		'new_item' => 'Novo Clipping',
		'view_item' => 'Ver Clipping',
		'search_items' => 'Buscar Clipping',
		'not_found' =>  'Nenhum encontrado',
		'not_found_in_trash' => 'Nenhum encontrado na lixeira',
		'parent_item_colon' => '',
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Clippings',
		'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_nav_menus' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => 'clipping',
		'menu_icon' => 'dashicons-megaphone',
		//'show_in_menu' => 'edit.php?post_type=artigo',
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		)
	); 
	register_post_type( 'clipping' , $args );
	$columns_config = array(
		'post_type' => 'clipping',
		'columns' => array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Título',
			'thumb' => 'Imagem',
			'date' => 'Data',
		)
	);
	new BorosPostTypeColumns( $columns_config );
	
}

/**
 * COLUNAS DE 'POSTS' e 'PAGES'
 * Configuração das colunas de listagem dos post_types core.
 * 
 */
//add_filter('manage_posts_columns', 'control_posts_columns');
function control_posts_columns( $posts_columns ){
	$posts_columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Título',
		'author' => 'Autor',
		'categories' => 'Categorias',
		'tags' => 'Tags',
		'thumb' => 'Imagem de destaque',
		'comments' => '<div class="vers"><img alt="Comentários" title="Comentários" src="' . get_bloginfo('wpurl') . '/wp-admin/images/comment-grey-bubble.png"></div>',
		'date' => 'Data',
	);
	return $posts_columns;
}
//add_filter('manage_pages_columns', 'control_pages_columns');
function control_pages_columns( $posts_columns ){
	$posts_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Título",
		"thumb" => "Imagem de destaque",
		"date" => 'Data',
		"order" => 'Ordem',
	);
	return $posts_columns;
}


