/*
Name: Javascript Functions
Version: 1.0
Description: Javascripts para o site
Author: Alex Koti
Author URI: http://alexkoti.com
 */


jQuery(document).ready(function($){
	//remover status de javascript do documento
	$('html').removeClass('no-js');
	
	
	
	/**
	 * MENU OFFCANVAS
	 * 
	 */
	$('[data-toggle="offcanvas"]').click(function () {
		if( $('.row-offcanvas').is('.active') ){
			$('.row-offcanvas, html, body').removeClass('active');
		}
		else{
			$('.row-offcanvas, html, body').addClass('active');
		}
	});
	
	
	
	/**
	 * SUBMENU CATEGORIAS PORTFOLIO
	 * 
	 */
	$('#portfolio-submenu .category-link, #portfolio-categories-list .portfolio-item-link').on('click', function(){
		portfolio_menu( $(this), false );
	});
	
	function portfolio_menu( btn, in_history ){
		var title = btn.text();
		
		// link pode o link para a inicial de categorias ou para uma categoria individual
		if( btn.is('.category-link') ){
			// lista de categorias
			var link = btn;
		}
		else{
			// itens de determinada categoria
			var link = $('#' + btn.attr('data-related-menu-link'));
		}
		
		var target = btn.attr('data-target'); // target do link
		var hstate = btn.attr('data-hstate'); // history state slug do link
		var cstate = btn.attr('id'); // history state id do link
		var active = $('#portfolio-box .active'); // categoria exibindo agora
		
		// caso o target do link ainda não esteja visível nos círculos, mostrar, caso contrário não faz nada.
		if( active.attr('id') != target ){
			console.log(1);
			active.fadeOut(400, function(){
				$('#portfolio-box .portfolio-category').removeClass('active');
				$('#'+target).fadeIn(400, function(){
					$(this).addClass('active');
				});
			});
		}
		
		// caso algum sub-menu esteja visível, verificar se é o mesmo do clicado
		if( $('#portfolio-submenu .portfolio-category-items:visible').length ){
			var ul = link.closest('.portfolio-category-menu-item').find('.portfolio-category-items');
			// é o mesmo que já está ativado, não fazer nada
			if( ul.is(':visible') ){
				console.log(21);
				return;
			}
				console.log(22);
			// esconder todos os ativos e mostrar o desejado
			$('#portfolio-submenu .portfolio-category-items').slideUp({
				duration : 400, 
				queue : false,
				complete : function(){
					link.closest('.portfolio-category-menu-item').find('.portfolio-category-items').slideDown();
					// adicionar um item do histórico
					if( in_history == false ){
						History.pushState( {cstate:cstate}, title, '?categoria=' + hstate);
					}
				}
			});
		}
		else{
			console.log(3);
			// está tudo fechado, abrir diretamente o desejado
			link.closest('.portfolio-category-menu-item').find('.portfolio-category-items').slideDown();
			// adicionar um item do histórico
			if( in_history == false ){
				History.pushState( {cstate:cstate}, title, '?categoria=' + hstate);
			}
		}
		
		// esconder o menu após o click apenas se for a página porfolio
		if( $('body').is('.post-type-archive-portfolio') ){
			$('.row-offcanvas, html, body').removeClass('active');
		}
	}
	
	History.Adapter.bind(window, 'statechange', function(){
		var State = History.getState();
		
		if( typeof State.data.cstate != 'undefined' ){
			portfolio_menu( $('#' + State.data.cstate), true );
		}
		else{
			portfolio_menu( $('#portfolio-categories-list-all'), true );
		}
		
		//$.each(State.data.clips, function(key, val){
		//	$(key).replaceWith(val);
		//});
		//History.log(State.data, State.title, State.url);
	});
	
	
	/**
	 * OWL CAROUSEL: PORTFOLIO
	 * 
	 */
	$('#single-portfolio-gallery-owl-carousel').owlCarousel({
		itemsMobile : [479, 2],
		itemsTablet : [768, 3]
	});
	
	
	/**
	 * OWL CAROUSEL: HOME
	 * 
	 */
	$("#home-carousel").owlCarousel({
		autoPlay        : 4000,
		stopOnHover     : true,
		navigation      : true,
		paginationSpeed : 1000,
		goToFirstSpeed  : 2000,
		singleItem      : true,
		autoHeight      : true,
		transitionStyle : 'fade',
		pagination      : false,
		navigationText  : ['&lsaquo;', '&rsaquo;']
	});
	
	
	/**
	 * PHOTOSWIPE
	 * 
	 */
	if( $('#single-portfolio-gallery-owl-carousel').length ){
		var pswpElement = document.querySelectorAll('.pswp')[0];
		
		// build items array
		var items = [];
		
		$('#single-portfolio-gallery-owl-carousel .owl-item').each(function(){
			var link = $(this).find('.gallery-link');
			var sizes = link.attr('data-sizes').split('x');
			var photo = {
				src : link.attr('href'),
				w : sizes[0],
				h : sizes[1],
				title : $(this).find('.gallery-link img').attr('alt')
			}
			items.push(photo);
		});
		//console.log(items);
		
		$('#single-portfolio-gallery-owl-carousel .owl-item a.gallery-link').on('click', function(evt){
			evt.preventDefault();
			var elem_index = $(this).closest('.owl-item').index();
		
			var options = { index : elem_index, loop : false }
			
			// Initializes and opens PhotoSwipe
			var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
			gallery.init(1);
		});
	}
	
	
	
});
