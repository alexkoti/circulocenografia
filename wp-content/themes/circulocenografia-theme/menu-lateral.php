			
			<nav id="offcanvas" class="menu-sidebar-container">
				<ul id="menu-sidebar" class="menu-offcanvas">
					<li class="visible-xs">
						<?php
						$query = esc_attr(apply_filters('the_search_query', get_search_query()));
						$value = ( $query == '' ) ? '' : $query;
						?>
						<form class="sidebar-search" id="sidebar-search" role="search" action="<?php echo home_url('/'); ?>">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Busca" name="s" value="<?php echo $value; ?>">
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
								</div>
							</div>
						</form>
					</li>
					<?php formatted_page_link(array('page_name' => 'inicio', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'nos', 'list' => true)); ?>
					<?php
					if( is_post_type_archive('portfolio') or is_singular('portfolio') ){
						$portfolio_item = get_queried_object(); //pre($portfolio_item);
						$portfolio_item_cats = wp_get_object_terms($portfolio_item->ID, 'portfolio_category'); //pre($portfolio_item_cats);
					?>
					<li id="portfolio-submenu">
						<?php
						if( is_post_type_archive('portfolio') ){
							echo '<span class="category-link" id="portfolio-categories-list-all" data-target="portfolio-categories-list" data-hstate="todas">Portfolio</span>';
						}
						else {
							formatted_post_type_link(array('post_type' => 'portfolio'));
						}
						?>
						<ul>
							<?php
							// verificar se a categoria foi definida por url query
							$category_active = false;
							if( isset($_GET['categoria']) ){
								$category_active = $_GET['categoria'];
							}
							
							$portfolio_menu = circle_get_portfolio_category_transient();
							foreach( $portfolio_menu['posts'] as $cat ){
								echo '<li class="portfolio-category-menu-item">';
								if( is_post_type_archive('portfolio') ){
									echo "<span class='category-link' id='portfolio-link-category-{$cat['term_id']}' data-target='portfolio-category-{$cat['term_id']}' data-hstate='{$cat['slug']}'>{$cat['name']}</span>";
								}
								else{
									$category_link = add_query_arg( array('categoria' => $cat['slug']), get_post_type_archive_link('portfolio') );
									echo "<a href='{$category_link}' class='category-linka' id='portfolio-link-category-{$cat['term_id']}' data-target='portfolio-category-{$cat['term_id']}' data-hstate='{$cat['slug']}'>{$cat['name']}</a>";
								}
								
								if( !empty($cat['posts']) ){
									$class = 'portfolio-category-items';
									// primeiro verificar a categoria do queried object, no caso de single
									foreach( $portfolio_item_cats as $c ){
										if( $c->term_id == $cat['term_id'] ){
											$class = 'portfolio-category-items active';
											continue;
										}
									}
									// verificar active category por url
									if( $category_active == $cat['slug'] ){
										$class = 'portfolio-category-items active';
									}
									echo "<ul id='portfolio-category-items-{$cat['term_id']}' class='{$class}' data-active='0'>";
									foreach( $cat['posts'] as $post ){
										if($portfolio_item->ID == $post['ID']){
											echo "<li id='portfolio-category-item-{$post['ID']}' class='portfolio-category-item'><span class='active'>{$post['title']}</span></li>";
										}
										else{
											echo "<li id='portfolio-category-item-{$post['ID']}' class='portfolio-category-item'><a href='{$post['link']}'>{$post['title']}</a></li>";
										}
									}
									echo '</ul>';
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