<?php
/**
 * MINI TEMPLATES
 * A diferença desse arquivo para o functions/frontend.php é que estas funções estão focadas no output de blocos frequentes, enquanto o 
 * frontend.php lida com configurações e filtros, como pre_get_posts, redirects e templates.
 * Normalmente este arquivo será muito customizado para cada tema, enquanto o frontend.php poderá exigir poucas ou nenhuma mudança.
 * 
 */

/**
 * ==================================================
 * CUSTOM SEARCH FORM ===============================
 * ==================================================
 * 
 */
add_filter( 'get_search_form', 'custom_search_form' );
function custom_search_form( $form ) {
	$query = esc_attr(apply_filters('the_search_query', get_search_query()));
	$value = ( $query == '' ) ? '' : $query;
	
	$form = '
	<form method="get" id="searchform" action="' . home_url() . '/" >
		<label for="search_term">Busca</label>
		<input type="text" value="' . $value. '" id="search_term" class="ipt_search_text" name="s" placeholder="Procure no site" />
		<input type="submit" class="ipt_search_submit" id="searchsubmit" value="ok" />
	</form>';
	return $form;
}

/**
 * ==================================================
 * POSTMETA GERAL ===================================
 * ==================================================
 * Dados meta gerias do post: autor, data, categorias|termos aplicados, comentários.
 * Esta função certamente será muito customizada para cada site.
 */
function post_meta_posted_on(){
	global $post;
	$author_data = array(
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		get_the_author()
	);
	$author = vsprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="Ver todos os posts de %2$s">%2$s</a>', $author_data );
	
	$date_data = array(
		get_the_date('c'),
		get_the_date(),
	);
	$post_date = vsprintf('<time class="entry-date" datetime="%s" pubdate>%s</time>', $date_data );
	?>
	<div class="post_meta">
		<p class="author_date">Publicado por <?php echo $author; ?> em <span class="post_date"><?php echo $post_date; ?></span></p>
		<?php
		// caso queira mostar apenas uma taxonomia, eleminar o foreach e usar apenas o boros_terms('taxonomy_name').
		$taxonomies = get_taxonomies('', 'objects');
		foreach( $taxonomies as $taxonomy ){
			echo boros_terms( $post->ID, $taxonomy->name, true, "<p class='taxonomy_terms terms_{$taxonomy->name}'>{$taxonomy->label}: ", ' &gt; ', ', ', '</p>' );
		}
		?>
		<p class="comment_status"></p>
	</div>
	<?php
}

/**
 * ==================================================
 * CONTENT NAVIGATION (clone de twentyten) ==========
 * ==================================================
 * 
 * @param string $nav_id - id HTML apenas para identificação
 */
function custom_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="contents_nav">
			<div class="nav-previous"><?php next_posts_link( '&larr;  Anteriores' ); ?></div>
			<div class="nav-next"><?php previous_posts_link( 'Recentes &rarr;' ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

/**
 * ==================================================
 * SHARE BOX ========================================
 * ==================================================
 * Requisitos:
 * - javascript de facebook e twitter linkados via 'head_config'
 * - opção de exibição controlado via painel de admin, opção 'share_active' - necessário para ativar/desativar bloco de share que é bem pesado.
 */
function share_box(){
	global $post;
	if( get_option( 'share_active' ) == true ){
?>
	<div class="share">
		<div>
			<?php if( !is_single() ){ ?><a class="comment_link" href="<?php comments_link(); ?>"><?php comments_number('Sem comentários', '1 comentário', '% comentários'); ?></a><?php } ?>
			<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-count="horizontal"></a>
		</div>
		<div class="facebook_share" id="facebook_share_box_<?php the_ID(); ?>">
			<script type="text/javascript">
			//<![CDATA[
			document.getElementById("facebook_share_box_<?php the_ID(); ?>").innerHTML = '<fb:like href="<?php the_permalink(); ?>" show_faces="true" width="700"></' + 'fb:like>';
			//]]>
			</script>
		</div>
	</div>
<?php
	}
}

/**
 * ==================================================
 * EXCERPTS e READ MORE =============================
 * ==================================================
 * READ MORE ================================================================
 * Modificar o read more do excerpt automático, adicionando link e texto customizado
 * 
 * NÃO FUNCIONA EM CUSTOM QUERIES
 */
add_filter( 'excerpt_more', 'linked_excerpt_more' );
function linked_excerpt_more( $more ) {
	global $post;
	return ' <a href="'. get_permalink($post->ID) . '">' . '[&nbsp;...&nbsp;]' . '</a>';
}

/* EXCERPT LENGTH =========================================================== */
function new_excerpt_length($excerpt) {
	$length = 100; //Number of characters to display in excerpt
	$new_excerpt = substr($excerpt, 0, $length); //truncate excerpt according to $len
    return $new_excerpt;
}

/* Criar chamda do excerpt já linkado e com o 'leia +' */
function linked_excerpt(){
?>
<p class="chamada">
	<a href="<?php the_permalink(); ?>"><?php echo get_the_excerpt(); ?></a>
	<a href="<?php the_permalink(); ?>" class="link_mais">Leia</a>
</p>
<?php
}

/**
 * ==================================================
 * BREADCRUMB =======================================
 * ==================================================
 * Foi usada a base mostrada do link, mas foi muito moficiada para ampliar as opções.
 * 
 * @param	string	$home_text			texto para o link inicial
 * @param	string	$separator			separador, pode ser html
 * @param	string	$before				pré-html do item atual
 * @param	string	$after				pós-html do item atual
 * @param	string	$taxonomy_priority		priorizar uma taxonomia caso o post esteja em mais de uma classificação
 * @param	bool		$taxonomy_label		exibir o nome da taxonomia antes da lista de termos, exemplo: 'Home > Regiões: Sudeste > Minas Gerais' em vez de apenas 'Home > Sudeste > Minas Gerais'
 * 
 * @link http://dimox.net/wordpress-breadcrumbs-without-a-plugin/
 */
function boros_breadcrumb( $args = array() ){
	global $post, $wp_query;
	$defaults = array(
		'home_text' => 'Home',
		'separator' => ' &gt; ',
		'before' => '<span class="current">',
		'after' => '</span>',
		'taxonomy_priority' => null,
		'taxonomy_label' => false,
		'frontpage_text' => 'Início',
		'home_text' => 'Posts',
	);
	$attr = wp_parse_args( $args, $defaults );
	extract( $attr, EXTR_SKIP );
	
	//if( !is_home() && !is_front_page() || is_paged() )
	echo '<div class="breadcrumb">';
	
	// url e link padrão da raiz
	$frontpage_url = home_url('/');
	$frontpage_link =  '<a href="' . $frontpage_url . '" class="first">' . $frontpage_text . '</a> ';
	
	if( !is_home() && !is_front_page() && !is_paged() ){
		echo $frontpage_link . $separator;
	}
	
	// Caso ambos is_home e is_front_page sejam true, significa que a raiz do site é a listagem de posts comuns(padrão wp)
	if( is_front_page() and is_home() ){
		echo ( is_paged() ) ? $frontpage_link : $frontpage_text;
	}
	// Front page definida como uma das 'pages'
	elseif( is_front_page() and !is_home() ){
		echo ( is_paged() ) ? $frontpage_link : $frontpage_text;
	}
	// Home de posts definida como uma das pages, e não a raiz da site
	elseif( is_home() ){
		$posts_home = get_option('page_for_posts');
		if( $posts_home ){
			$home_link =  '<a href="' . get_permalink($posts_home) . '" class="first">' . $home_text . '</a> ';
		}
		
		if( is_paged() ){
			echo $frontpage_link . $separator . $home_link;
		}
		else{
			echo $frontpage_link . $separator . $home_text;
		}
	}
	elseif( is_search() ){
		echo $before . 'Resultados de busca para "' . get_search_query() . '"' . $after;
	}
	elseif( is_tax() ){
		global $wp_query;
		$tax_obj = $wp_query->get_queried_object();
		$taxonomy_data = get_taxonomy( $tax_obj->taxonomy );
		if( $taxonomy_label == true )
			echo "{$taxonomy_data->labels->name}: ";
		if( $tax_obj->parent )
			echo _get_term_parents( $tax_obj->parent, $tax_obj->taxonomy, $link = true, $separator = $separator, $visited = array() );
		echo "{$before} Arquivo de &#147;{$tax_obj->name}&#148;{$after} ";
	}
	elseif( is_category() ){
		global $wp_query;
		$cat_obj = $wp_query->get_queried_object();
		$thisCat = $cat_obj->term_id;
		$thisCat = get_category($thisCat);
		$parentCat = get_category($thisCat->parent);
		if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $separator . ' '));
		echo $before . 'Arquivo de "' . single_cat_title('', false) . '"' . $after;
	}
	elseif( is_day() ){
		echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $separator . ' ';
		echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $separator . ' ';
		echo $before . get_the_time('d') . $after;
	}
	elseif( is_month() ){
		echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $separator . ' ';
		echo $before . get_the_time('F') . $after;
	}
	elseif ( is_year() ){
		echo $before . get_the_time('Y') . $after;
	}
	elseif( is_singular() && !is_attachment() ){
		if( is_post_type_hierarchical($post->post_type) ){
			if( !$post->post_parent ){
				echo $before . get_the_title() . $after;
			}
			elseif( $post->post_parent ){
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $separator . ' ';
				echo $before . get_the_title() . $after;
			}
		}
		else{
			// adicionar ou não um link de 'home' para posts(ordem cronológica)
			if( $post->post_type == 'post' ){
				// verificar se a home de posts é uma page específica e não a raiz do site
				if( $page_for_posts = get_option('page_for_posts') ){
					$home_posts = get_page($page_for_posts);
					$home_link = get_permalink($home_posts->ID);
					$home_title = apply_filters( 'the_title', $home_posts->post_title );
					echo "<a href='{$home_link}'>{$home_title}</a> {$separator} ";
				}
			}
			// link para post_type_archive
			else{
				$post_type = get_post_type_object( $post->post_type );
				$home_link = get_post_type_archive_link( $post->post_type );
				echo "<a href='{$home_link}'>{$post_type->label}</a> {$separator} ";
			}
			
			// Pegar todas as taxonomias e ordenar por prioridade caso exista essa definição em get_option();
			$taxonomies = get_option( 'taxonomy_priorities' );
			if( !$taxonomies )
				$taxonomies = get_taxonomies();
			if( !is_null($taxonomy_priority) ){
				$priority = array( $taxonomy_priority => $taxonomy_priority );
				unset($taxonomies[$taxonomy_priority]);
				$taxonomies = $priority + $taxonomies;
			}
			
			// fazer loop em todas as taxonomias, até encontrar alguma em que o post foi classificado
			foreach( $taxonomies as $taxonomy ){
				$terms = get_the_terms( $post->ID, $taxonomy );
				if( $terms ){
					$args = array(
						'orderby' => 'name',
						'order' => 'ASC',
						'hide_empty' => 0,
						'depth' => 0,
					);
					// organizar os termos em ordem hierárquica, do nível mais baixo para o mais alto
					$ordered_terms = walk_simple_taxonomy( $terms, $args['depth'], $args );
					
					// verificar a existência de termos para cada nível
					foreach( $ordered_terms as $level ){
						$last_level = end($level);
						foreach( $level as $term ){
							$term_link = get_term_link( $term, $taxonomy );
							if( count($level) > 1 ){
								$sep = ( $last_level == $term ) ? $separator : ', ';
							}
							else{
								$sep = $separator;
							}
							echo "<a href='{$term_link}'>{$term->name}</a> {$sep}";
						}
					}
					break;
				}
			}
			echo $before . get_the_title() . $after;
		}
	}
	elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){
		$post_type = get_post_type_object( get_post_type() );
		echo $before . $post_type->labels->name . $after;
	}
	elseif( is_attachment() ){
		$parent = get_post($post->post_parent);
		$cat = get_the_category($parent->ID); $cat = $cat[0];
		echo get_category_parents($cat, TRUE, ' ' . $separator . ' ');
		echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $separator . ' ';
		echo $before . get_the_title() . $after;
	}
	elseif( is_tag() ){
		echo $before . 'Tag "' . single_tag_title('', false) . '"' . $after;
	}
	elseif( is_author() ){
		global $author;
		$userdata = get_userdata($author);
		echo $before . 'Postado por ' . $userdata->display_name . $after;
	}
	elseif( is_404() ){
		echo $before . 'Não encontrado(erro 404)' . $after;
	}
	
	// adicionar indicação de paginação
	if( is_paged() ){
		// $paged em uma front_page paginada está apenas em $wp_query->query e não em $wp_query->query_vars
		$paged = $wp_query->query['paged'];
		//if ( is_front_page() || is_home() || is_category() || is_tax() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
		if( is_singular() )
			echo " Página {$paged} ";
		else
			echo " (Página {$paged}) ";
	}
	
	echo '</div>';
}

/* ========================================================================== */
/* BOROS SLIDER ============================================================= */
/* ========================================================================== */
/**
 * Requisitos:
 * - javascript boros_slider_plugin linkado via 'head_config'
 * - este bloco gera o html estático do slider. As configuraçoes de ativação do script do slider são colocadas no js apropriado 'functions.js', e o CSS em 'css/slider.css'
 * 
 */
function boros_slider( $meta_key, $layout = 'single', $numeric = false ){
	global $post;
	?>
	<div class="slider_<?php echo $layout; ?>">
		<?php
		if( $meta_key == 'slider_home' )
			$post_thumbnail_size = 'slider_home';
		elseif( $meta_key == 'slider_blog' or $meta_key == 'slider_palavras' )
			$post_thumbnail_size = 'post-thumbnail';
		
		$args = array(
			'post_type' => 'any',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_key' => $meta_key,
		);
		$slides = new WP_Query();
		$slides->query($args);	// posts habilitados
		
		$slider_order = get_option($meta_key);
		$ordered_slides = array();
		$slider_itens = explode(',', $slider_order);
		foreach( $slider_itens as $slider ){
			foreach( $slides->posts as $slide ){
				if( $slide->ID == $slider ){
					$ordered_slides[] = $slide;
				}
			}
		}
		//pre($ordered_slides);
		if( $ordered_slides ){
		?>
		<div class="boros_slider boros_slider_<?php echo $layout; ?> <?php echo $meta_key; ?>_box">
			<?php if( count($slides->posts) > 1 ) { ?>
			<div class="boros_slider_nav <?php echo ($numeric == true) ? 'numeric' : ''; ?>">
				<a rel="prev" class="btn_nav btn_prev btn_prev_next" title="anterior">&lt;</a> 
				<a rel="next" class="btn_nav btn_next btn_prev_next" title="próximo">&gt;</a>
			</div>
			<?php } ?>
			<div class="boros_slider_holder">
				<ul class="boros_slider_strip">
					<?php foreach($ordered_slides as $post){ setup_postdata($post); ?>
					<li class="slide">
						<div class="slide_inner">
							<figure class="slide_image">
								<?php
								$thumb_id = get_post_meta($post->ID, '_thumbnail_id', true);
								if( $thumb_id ){
									$post_thumb = get_post($thumb_id);
									$title_attr = the_title_attribute('echo=0');
									?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( $post_thumbnail_size, array('title' => get_the_title(), 'class' => 'wp-post-image') ); ?>
									</a>
									<?php
								}
								else{
									?>
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo THEME; ?>/css/img/slider_default.gif" class="wp-post-image" alt="<?php the_title(); ?>" />
									</a>
									<?php
								}
								?>
							</figure>
							<div class="details">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="slide_resume"><?php the_title(); ?></div>
								<a href="<?php the_permalink(); ?>" class="leia_mais_branco">leia mais</a>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div><!-- .slider -->
		<?php } ?>
	</div>
	<?php
}

/**
 * INTEGRATED FUNCTION
 * Modelo de função integrando HTML, CSS e JS dinâmico via PHP.
 * Nesse exemplo:
 * - é criada uma HTML baseada nos argumentos de chamada.
 * - são definidos as variáveis dinâmicas a serem passadas para o JS.
 * - são enfileiradas as variáveis JS para serem exibidas no footer.
 * - CSS dinâmico adicional será adicionado inline, junto ao HTML de output.
 * 
 * IMPORTANTE: arquivos .js e .css estáticos ainda deverão ser registrados globalmente, em função inicializadora, em functions.php ou functions/head.php
 * @todo: pensar numa function que verifica as condicionais para enfileirar ou não o js/css - draft: gravar post_meta 'have_slider' e fazer a verificação em um hook pós-database @link:http://pippinsplugins.com/load-scripts-if-post-has-short-code/
 * 
 * 
 * @param array $defaults:
 * @param string	$id		identificador - precisa ser o mesmo nome registrado em 'wp_enqueue_script', e já precisa estar registrado
 * @param array	$php		array de opções para passar ao PHP
 * @param array	$js		array de opções para passar ao JS, define as variáveis dinâmicas - IMPORTANTE: valores booleanos deverão ser enviados 
						como 0 e 1 e serão redenrizados como strings, portanto precisam ser convertidas no typecast correto. Recomendado 
						usar Number(), já que atenderá ambos os casos de Boolean() e Number()
 * @param array	$css		array de opções para passar ao CSS, define as configurações de css, no modelo 'propriedade' => 'valor'
 * 
 */
function integrated_function( $args ){
	$result = new integrated_function( $args );
	$result->output();
}
class integrated_function {
	var $args = array();
	var $defaults = array(
		'id' => 'function_name',
		'php' => array(
			'option' => 'slide',
			'image_size' => 'thumbnail',
			'query' => array(
				'post_type' => 'post',
				'post_status' => 'publish',
			),
		),
		'js' => array(
			'numeric' => true,
			'slideshow' => true,
			'slideshow_time' => 7000,
		),
		'css' => array(),
	);
	
	function __construct( $args ){
		$attr = wp_parse_args( $args, $this->defaults );
		$this->args = $attr;
	}
	
	function output(){
		$this->create_html();
		$this->add_css();
		$this->add_action();
	}
	
	function create_html(){
		extract( $this->args['php'] );
		echo "
			<div style='border:1px solid red;'>
				<h1 class='foo'>{$option}</h1>
				<h2 class='bar'>{$image_size}</h2>
				<dl class='foobar'>
					<dt>{$query['post_type']}</dt>
					<ds>{$query['post_status']}</ds>
				</dl>
			</div>
		";
	}
	
	/**
	 * Adicionar CSS inline dinâmico, caso exista
	 * 
	 */
	function add_css(){
		boros_print_css( $this->args['css'] );
	}
	
	/**
	 * Enfileirar JS dinâmico para exibir no footer
	 * 
	 */
	function enqueue_js(){
		wp_localize_script( $this->args['id'], $this->args['id'], $this->args['js'] );
	}
	
	function add_action(){
		add_action( 'wp_print_footer_scripts', array($this, 'enqueue_js') );
	}
}





