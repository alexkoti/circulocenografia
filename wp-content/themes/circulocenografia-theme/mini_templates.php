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
 * PORTFOLIO CATEGORY TRANSIENT =====================
 * ==================================================
 * Armazenar todas os termos de 'portfolio_category', assim como todos os posts('portfolio') de cada categoria. O resultado 
 * será armazenado em transient e será usado para o menu de portfólio e a a página inicial dos trabalhos.
 * 
 */
function circle_get_portfolio_category_transient(){
	if( false === ( $portfolio_menu = get_transient('portfolio_menu') ) ){
		// definir o array a ser salvo, com data atual
		date_default_timezone_set(get_option('timezone_string'));
		$portfolio_menu = array('creation' => date('Y-m-d-H-i-s'));
		
		// buscar termos
		$ports = get_terms('portfolio_category', array('hide_empty' => false, 'orderby' => 'term_order'));
		$portfolio_menu['categories'] = $ports;
		
		// buscar posts de cada termo
		foreach( $ports as $cat ){
			$portfolio_menu[posts][$cat->term_id] = array(
				'term_id' => $cat->term_id,
				'name' => $cat->name,
				'slug' => $cat->slug,
				'posts' => array(),
			);
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio_category',
						'field' => 'term_id',
						'terms' => $cat->term_id,
					),
				),
			);
			$items = new WP_Query($args);
			if( $items->posts ){
				foreach( $items->posts as $post ){
					$img = '';
					$thumb = get_post_meta($post->ID, '_thumbnail_id', true);
					if( !empty($thumb) ){
						$thumb_src = wp_get_attachment_image_src($thumb, 'post-thumbnail');
						$img = "<img src='{$thumb_src[0]}' alt='' class='img-responsive' />";
					}
					$portfolio_menu[posts][$cat->term_id]['posts'][] = array(
						'ID' => $post->ID,
						'title' => get_the_title($post->ID),
						'link' => get_permalink($post->ID),
						'thumb' => $thumb,
						'img' => $img,
					);
				}
			}
			wp_reset_query();
		}
		set_transient( 'portfolio_menu', $portfolio_menu, 1 * DAY_IN_SECONDS );
	}
	return $portfolio_menu;
}



/**
 * ==================================================
 * PHOTOSWIPE BOX ===================================
 * ==================================================
 * 
 * 
 */
function photo_swipe_box(){
	?>
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe. 
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. 
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>
	<?php
}



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
	$date_data = array(
		get_the_date('c'),
		get_the_date(),
	);
	$post_date = vsprintf('<time class="entry-date" datetime="%s" pubdate>%s</time>', $date_data );
	?>
	<div class="post_meta">
		<p class="author_date">
			Publicado em <span class="post_date"><?php echo $post_date; ?></span> / Categorias: 
			<?php
			// caso queira mostar apenas uma taxonomia, eleminar o foreach e usar apenas o boros_terms('taxonomy_name').
			$taxonomies = get_taxonomies('', 'objects');
			foreach( $taxonomies as $taxonomy ){
				echo boros_terms( $post->ID, $taxonomy->name, true, "<span class='taxonomy_terms terms_{$taxonomy->name}'>", ' &gt; ', ', ', '</span>' );
			}
			?>
		</p>
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
function custom_content_nav( $nav_id = 'above' ) {
	global $wp_query;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$pagination_args = array(
		'query_type' => 'normal',
		'current' => $paged,
		'total' => $wp_query->found_posts,
		'posts_per_page' => $wp_query->query_vars['posts_per_page'],
		'options' => array(
			'num_pages' => 5,
			'link_class' => '',
		),
	);
	boros_pagination($pagination_args);
}

function single_post_nav( $nav_id ) {
	?>
	<nav id="<?php echo $nav_id; ?>" class="navposts">
		<span class="nav-previous"><?php previous_post_link( '%link', '<span class="page_item btn btn-default" title="%title">← anterior</span>' ); ?></span>
		<span class="nav-next"><?php next_post_link( '%link', '<span class="page_item btn btn-default" title="%title">próximo →</span>' ); ?></span>
	</nav>
	<?php
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


