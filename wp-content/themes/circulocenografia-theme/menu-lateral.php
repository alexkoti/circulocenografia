			
			<nav id="offcanvas" class="menu-sidebar-container">
				<ul id="menu-sidebar" class="menu-offcanvas">
					<?php formatted_page_link(array('page_name' => 'inicio', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'nos', 'list' => true)); ?>
					<?php
					if( is_page('portfolio') or is_singular('portfolio') ){
						$portfolio_item = get_queried_object(); //pre($portfolio_item);
					?>
					<li id="portfolio-submenu">
						<?php
						if( is_page('portfolio') ){
							echo '<span class="category-link" data-target="portfolio-categories-list">Portfolio</span>';
						}
						else {
							formatted_page_link(array('page_name' => 'portfolio'));
						}
						?>
						<ul>
							<?php
							$ports = get_terms('portfolio_category', array('hide_empty' => false));
							foreach( $ports as $cat ){
								echo "<li class='portfolio-category-menu-item'><span class='category-link' data-target='portfolio-category-{$cat->term_id}'>{$cat->name}</span>";
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
										$class = 'portfolio-category-items';
										if( $portfolio_item->post_type == 'portfolio' ){
											$_pcats = wp_get_object_terms($portfolio_item->ID, 'portfolio_category');
											foreach( $_pcats as $c ){
												if( $c->term_id == $cat->term_id ){
													$class = 'portfolio-category-items active';
												}
											}
										}
										echo "<ul id='portfolio-category-items-{$cat->term_id}' class='{$class}' data-active='0'>";
										foreach( $items->posts as $post ){
											$title = get_the_title($post->ID);
											$link = get_permalink($post->ID);
											if($portfolio_item->ID == $post->ID){
												echo "<li id='portfolio-category-item-{$post->ID}' class='portfolio-category-item'><span class='active'>{$title}</span></li>";
											}
											else{
												echo "<li id='portfolio-category-item-{$post->ID}' class='portfolio-category-item'><a href='{$link}'{$active}>{$title}</a></li>";
											}
										}
										echo '</ul>';
									}
									else{
										echo "<ul id='portfolio-category-items-{$cat->term_id}' class='portfolio-category-items' data-active='0'><li class='portfolio-category-item'>Nenhum trabalho nesta categoria</li></ul>";
									}
									wp_reset_query();
								echo '</li>';
							}
							?>
						</ul>
					</li>
					<?php
					} else {
						formatted_page_link(array('page_name' => 'portfolio', 'list' => true));
					}
					?>
					<?php formatted_page_link(array('page_name' => 'cursos', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'na-midia', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'blog', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'projeto-cultural', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'contato', 'list' => true)); ?>
				</ul>
			</nav>