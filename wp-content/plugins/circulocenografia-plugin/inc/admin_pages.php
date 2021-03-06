<?php
/**
 * 1 - Adicionar admin pages
 * 2 - Remover core pages
 * 3 - Configurar admin_bar
 * 
 */

/**
 * ==================================================
 * ACTIONS / FILTERS ================================
 * ==================================================
 * my_admin_pages_config()	trocar pela função de configuração do seu plugin
 * CIRCULO_DIR		trocar pela constante do caminho da seu plugin, usar <code> plugin_dir_path(__FILE__) </code> no arquivo base do plugin
 * CIRCULO_URL		trocar pela constante da URL do plugin, usar <code> plugin_dir_url(__FILE__) </code> no arquivo base do plugin
 * 
 */
add_action( 'init', 'my_admin_pages' );
function my_admin_pages(){
	$admin_pages = new BorosAdminPages( my_admin_pages_config(), CIRCULO_DIR, CIRCULO_URL );
}

/**
 * ==================================================
 * CONFIGURAÇÃO DAS PÁGINAS =========================
 * ==================================================
 * IMPORTANTE!
 * A chave do array será usada como 'menu_slug', nome de arquivo para o include e para function de inicialização:
 * 	'my_page' = array(...)		>>> chave do array de configuração declarado neste function admin_pages_config()
 * 	admin_pages/my_page.php	>>> arquivo de include com as configs e functions individuais de cada página
 * 	my_page()				>>> function de configuração de elementos
 * 	settings_fields('my_page')	>>> será o name usado nessa chamada nos campos hidden do form. Essa execução será automática
 * 
 * Para adicionar subpages ao core, defina como chave o nome do arquivo( 'edit.php' para posts, 'edit.php?post_type=page' para pages, 'tools.php' para ferramentas, etc ), e defina o 
 * atributo 'type' como 'core', dessa forma as configs de página raiz serão ignoradas e consideradas apenas as subpages. Não esqueça de adicionar o atributo 'capability' nessas subpages, 
 * que normalmente são herdadas da configuração do parent.
 * 
 * Em 'subpages' vale a mesma lógica de configuração, inclusive com seus próprios enqueues
 * Em 'tabs' defina a chave como o name a ser usado no mesmo padrão(chave, function e settings_field) e o valor como o label da aba.
 * 
 */
function my_admin_pages_config(){
	
	$admin_pages = array(
		'edit.php?post_type=portfolio' => array(
			'type' => 'core',
			'subpages' => array(
				'category_order' => array(
					'page_title'	=> 'Ordem das Categorias', 
					'menu_title'	=> 'Ordenar Categorias', 
					'menu_slug'		=> 'category_order', 
					'capability'	=> 'manage_options',
				)
			),
		),
		'section_content' => array(
			'page_title'	=> 'Opções do Site', 
			'menu_title'	=> 'Opções do Site', 
			'capability'	=> 'manage_options', 
			'icon_url'		=> 'dashicons-admin-generic',
			'subpages' => array(
				'section_home' => array(
					'page_title'	=> 'Opções da Home', 
					'menu_title'	=> 'Opções da Home', 
					'capability'	=> 'manage_options', 
				),
				'section_general' => array(
					'page_title'	=> 'Opções de Administração', 
					'menu_title'	=> 'Opções de Administração', 
					'capability'	=> 'manage_options', 
				),
				'section_emails' => array(
					'page_title'	=> 'Emails', 
					'menu_title'	=> 'Emails', 
					'capability'	=> 'manage_options', 
				),
			),
		),
		'section_networks' => array(
			'page_title'	=> 'Redes Sociais', 
			'menu_title'	=> 'Redes Sociais', 
			'capability'	=> 'manage_options', 
			'icon_url'		=> 'dashicons-admin-share',
		),
	);
	return $admin_pages;
}

/**
 * ==================================================
 * POST TYPE ORDER ==================================
 * ==================================================
 * 
 * 
 */
add_filter( 'cmspo_post_types', 'circulo_post_type_order' );
function circulo_post_type_order( $post_types ) {
	$post_types[] = 'curso';
	$post_types[] = 'portfolio';
	return $post_types;
}

add_action( 'cmspo_page_label', 'circulo_post_type_order_label', 10, 2 );
function circulo_post_type_order_label( $label, $post_type ) {
	if( 'curso' == $post_type ){
		$label = 'Ordenar Cursos';
	}
	elseif( 'portfolio' == $post_type ){
		$label = 'Ordenar Trabalhos';
	}
	elseif( 'page' == $post_type ){
		$label = 'Ordenar Páginas';
	}
	return $label;
}

add_filter( 'the_title', 'circulo_portfolio_order_title', 10, 2 );
function circulo_portfolio_order_title($post_title, $post_id){
	global $page_hook;
	if( $page_hook == 'portfolio_page_order-portfolio' ){
		$terms = wp_get_post_terms($post_id, 'portfolio_category');
		$terms_string = array();
		foreach($terms as $t){
			$terms_string[] = $t->name;
		}
		$terms_string = implode('][', $terms_string);
		$post_title = "<small><em>[{$terms_string}]</em></small> {$post_title}";
	}
	return $post_title;
}

/**
 * ==================================================
 * REMOVER PÁGINAS DO ADMIN =========================
 * ==================================================
 * 
 * @link	http://devpress.com/blog/removing-menu-pages-from-the-wordpress-admin/
 */
//add_action('admin_menu', 'remove_admin_pages');
function remove_admin_pages(){
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
}

/**
 * ==================================================
 * CONFIGURAÇÔES DA ADMIN BAR :: SEMI-STATIC ========
 * ==================================================
 * @bug Em $wp_admin_bar->add_menu, no array de config, a opção 'meta' é obrigatória, declarar vazio se necessário
 * 
 * @link http://www.paulund.co.uk/how-to-remove-links-from-wordpress-admin-bar
 * @link http://wp-snippets.com/addremove-wp-admin-bar-links/
 */
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
function remove_admin_bar_links() {
	global $wp_admin_bar;
	
	// REMOVER
	$wp_admin_bar->remove_menu('wp-logo');				// Remove the WordPress logo
	$wp_admin_bar->remove_menu('view-site');			// Remove the view site link
	//$wp_admin_bar->remove_menu('my-account');			// Remove my-account
	
	// ADICIONAR
	if( is_admin() ) $frontend_text = 'Ver site: ' . get_bloginfo('name');
	else $frontend_text = get_bloginfo('name');
	$wp_admin_bar->add_menu(array(
		'id' => 'site-name',
		'title' => $frontend_text,
		'href' => home_url(),
		'meta' => array(),
	));
}


