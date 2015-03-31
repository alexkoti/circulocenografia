			<?php
			//$args = array(
			//	'menu'         => 'Sidebar',
			//	'container'    => 'nav',
			//	'container_id' => 'offcanvas',
			//	'menu_class'   => 'menu-offcanvas',
			//	'echo'         => false,
			//);
			//$menu_sidebar = wp_nav_menu($args);
			//echo $menu_sidebar;
			?>
			<hr />
			<nav id="offcanvas" class="menu-sidebar-container">
				<ul id="menu-sidebar" class="menu-offcanvas">
					<?php formatted_page_link(array('page_name' => 'inicio', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'nos', 'list' => true)); ?>
					<li>
						<span>Portfolio</span>
						<ul id="portfolio-submenu">
							<?php
							$ports = get_terms('portfolio_category', array('hide_empty' => false));
							foreach( $ports as $cat ){
								//pre($cat, 'cat', false);
								//formatted_term_link(array('list' => true), $cat);
								echo "<li><span data-target='portfolio-category-{$cat->term_id}'>{$cat->name}</span></li>";
							}
							?>
						</ul>
					</li>
					<?php formatted_page_link(array('page_name' => 'cursos', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'na-midia', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'blog', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'projeto-cultural', 'list' => true)); ?>
					<?php formatted_page_link(array('page_name' => 'contato', 'list' => true)); ?>
				</ul>
			</nav>
			<hr />