			
			<nav id="offcanvas" class="menu-sidebar-container">
				<ul id="menu-sidebar" class="menu-offcanvas">
					<?php formatted_page_link(array('page_name' => 'inicio', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'nos', 'list' => true)); ?>
					<?php
					if( is_post_type_archive('portfolio') or is_singular('portfolio') ){
						$portfolio_item = get_queried_object(); //pre($portfolio_item);
						$portfolio_item_cats = wp_get_object_terms($portfolio_item->ID, 'portfolio_category');
					?>
					<li id="portfolio-submenu">
						<?php
						if( is_post_type_archive('portfolio') ){
							echo '<span class="category-link" data-target="portfolio-categories-list">Portfolio</span>';
						}
						else {
							formatted_post_type_link(array('post_type' => 'portfolio'));
						}
						?>
						<ul>
							<?php
							$portfolio_menu = circle_get_portfolio_category_transient();
							//pre($portfolio_menu, $portfolio_menu['creation'], 'portfolio_menu', false);
							foreach( $portfolio_menu['posts'] as $cat ){
								echo "<li class='portfolio-category-menu-item'><span class='category-link' data-target='portfolio-category-{$cat['term_id']}'>{$cat['name']}</span>";
								if( !empty($cat['posts']) ){
									foreach( $cat['posts'] as $post ){
										$class = 'portfolio-category-items';
										foreach( $portfolio_item_cats as $c ){
											if( $c->term_id == $cat['term_id'] ){
												$class = 'portfolio-category-items active';
											}
										}
										echo "<ul id='portfolio-category-items-{$cat['term_id']}' class='{$class}' data-active='0'>";
										if($portfolio_item->ID == $post['ID']){
											echo "<li id='portfolio-category-item-{$post['ID']}' class='portfolio-category-item'><span class='active'>{$post['title']}</span></li>";
										}
										else{
											echo "<li id='portfolio-category-item-{$post['ID']}' class='portfolio-category-item'><a href='{$post['link']}'>{$post['title']}</a></li>";
										}
										echo '</ul>';
									}
								}
								else{
									echo "<ul id='portfolio-category-items-{$cat['term_id']}' class='portfolio-category-items' data-active='0'><li class='portfolio-category-item'>Nenhum trabalho nesta categoria</li></ul>";
								}
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
					<li id="cursos-submenu">
						<?php formatted_page_link(array('page_name' => 'cursos')); ?>
						<?php
						if( is_page(array('cursos', 'cursos-anteriores')) or is_singular('curso') ){
							echo '<ul>';
							formatted_page_link(array('page_name' => 'cursos-anteriores', 'list' => true));
							echo '</ul>';
						}
						?>
					</li>
					<?php formatted_page_link(array('page_name' => 'na-midia', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'blog', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'projeto-cultural', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'contato', 'list' => true)); ?>
				</ul>
			</nav>