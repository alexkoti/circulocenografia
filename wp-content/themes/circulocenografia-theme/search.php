<?php
/**
 * Templpate para resultado da busca.
 * Estudar as soluções apresentadas nesse artigo(ver comentários também): http://wpengineer.com/2258/change-the-search-url-of-wordpress/
 * 
 */

get_header(); ?>
		
		<div id="column">
			<?php boros_breadcrumb(); ?>
			<h1>Resultados da busca para <strong><?php echo get_search_query(); ?></strong></h1>
			
			<?php
			/**
			 * Caso tenha posts para exibir
			 * 
			 */
			if (have_posts()){
				custom_content_nav( 'nav_above' );
				while (have_posts()){
					the_post();
					get_template_part( 'content', 'list' );
				}
				custom_content_nav( 'nav_below' );
			}
			/**
			 * Sem resultados
			 * IMPORTANTE: isso não é exatamente a mesma coisa que o 404 not found(este possui template próprio), é aplicado à uma requisição válida porém sem resultados
			 * conforme o contexto, por exemplo listagem de posts na página 999, onde não existem mais posts para exibir.
			 */
			 else {
				?>
				<article class="post hentry no-results not-found">
					<header class="entry_header">
						<h2>Sem resultados</h2>
					</header>
					<div class="entry_content">
						Não foram encontrados resultados para essa requisição :(
					</div>
				</article>
				<?php
			 }
			?>
			
		</div><!-- .column -->
		
		<?php get_sidebar(); ?>
		
<?php get_footer() ?>