<?php
/**
 * Funções específicas para atender o frontend este site.
 * As funções listadas no começo do arquivo possuem maior prioridade de edição, as funções mais ao fim do arquivo muitas vezes não necessitam de personalização.
 * 
 * 
 */



add_action( 'template_redirect', 'close_site' );
function close_site(){
	$logged_in_only = get_option('logged_in_only');
	if( !empty($logged_in_only) ){
		if( !is_user_logged_in() ){
			get_template_part('locked');
			exit();
		}
	}
}



/**
 * ==================================================
 * GOOGLE ANALYTICS =================================
 * ==================================================
 * 
 * 
 */
add_action( 'wp_footer', 'footer_google_analytics' );
function footer_google_analytics(){
	opt_option('google_analytics');
}



/**
 * ==================================================
 * CUSTOM POSTS PER PAGE ============================
 * ==================================================
 * Definir a quantidade total de post por página em diferentes situações.
 * A quantidade padrão é definida pela option 'posts_per_page', gravada em wp_options, e definida via admin em 'Configurações > Leitura"
 * Como as situações possíveis de listagens são infinitas, é preciso codificar a verificação para cada caso.
 * 
 * IMPORTANTE:
 * Quando é definido uma página estática para a frontpage, a primeira vez que é chamado o filtro 'pre_get_posts', ocorre um erro, onde não se consegue acesso ao queried object.
 * Para resolver isso, é verificado se está na frontpage comparando a query_var 'page_id', que sempre está nas querys com a option 'page_on_front'. Em caso positivo, 
 * estamos na frontpage, portanto $query é retornado sem modificações. Essa primeira chamada de 'pre_get_posts' nesse caso específico não precisa ser modificada em nenhum caso.
 * 
 * As posteriores chamadas de pre_get_posts que precisem verificar is_front_page() rodarão normalmente. Por exemplo, se for feita uma nova requisição no meio da página, como
 * query_posts() ou WP_Query(), as verificações de is_front_page() funcionarão como esperado.
 * 
 */
//add_filter( 'pre_get_posts', 'filter_pre_get_posts' );
function filter_pre_get_posts( $query ){
	
	if ( !is_admin() && $query->is_search ) {
		$query->set( 'post_type', array( 'post', 'page', 'portfolio' ) );
		$query->set( 's', false );
		$query->set('meta_query', array(
			array(
				'key' => 'lala',
				'value' => $query->query_vars['s'],
				'compare' => 'LIKE'
			)
		));
		//$query->set('post_type', '__your_post_type__'); // optional
		//pre($query);
	};

	return $query;
}



/**
 * ==================================================
 * REDIRECT =========================================
 * ==================================================
 * Redirecionar a página corrente para outro local.
 * Como as situações possíveis são infinitas, é preciso codificar a verificação para cada caso.
 */
//add_filter( 'parse_query', 'redirect_pages' );
function redirect_pages( &$q ) {
	if( empty($q->is_admin) and isset($q->query_vars['page_id']) ){
		// ID da página pedida
		$page_id = $q->query_vars['page_id'];
		
		if( $page_id == get_page_ID_by_name('Painel 5', 'page') ){
			$url = get_permalink( get_page_ID_by_name('Painel Home', 'page') );
			wp_redirect( $url, 301 );
			exit();
		}
	}
	/**
	pre($q);
	pre($q->query_vars['category_name']);
	pre($q->query_vars['posts_per_page']);
	pre($q->query_vars['numberposts']);
	pre($q->query_vars['posts_per_page']);
	pre($q->query_vars['numberposts']);
	/**/
}


