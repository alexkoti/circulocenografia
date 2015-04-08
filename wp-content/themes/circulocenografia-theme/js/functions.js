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
		if( $(this).is('.category-link') ){
			var link = $(this);
		}
		else{
			var link = $('#' + $(this).attr('data-related-menu-link'));
		}
		
		var target = $(this).attr('data-target');
		var active = $('#portfolio-box .active');
		//console.log(active);
		//console.log(target);
		
		if( active.attr('id') != target ){
			active.fadeOut(400, function(){
				$('#portfolio-box .portfolio-category').removeClass('active');
				$('#'+target).fadeIn(400, function(){
					$(this).addClass('active');
				});
			});
		}
		
		if( $('#portfolio-submenu .portfolio-category-items:visible').length ){
			var ul = link.closest('.portfolio-category-menu-item').find('.portfolio-category-items');
			if( ul.is(':visible') ){
				return;
			}
			$('#portfolio-submenu .portfolio-category-items').slideUp({
				duration : 400, 
				queue : false,
				complete : function(){
					link.closest('.portfolio-category-menu-item').find('.portfolio-category-items').slideDown();
				}
			});
		}
		else{
			link.closest('.portfolio-category-menu-item').find('.portfolio-category-items').slideDown();
		}
		// esconder o menu após o click apenas se for a página porfolio
		if( $('body').is('.item-name-portfolio') ){
			$('.row-offcanvas, html, body').removeClass('active');
		}
	});
	
	
	
	/**
	 * OWL CAROUSEL
	 * 
	 */
	$('#single-portfolio-gallery-owl-carousel').owlCarousel();
	
	
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
	
	
	
	/**
	 * VALIDATION
	 * Ações para validação js de comentários
	 * 
	 * 
	 * 
	 */
	$("#commentform").validate({
		rules: {
			// name_do_input: 'método de validação para aplicar, separado por espaços'
			comment: 'defaultInvalid'
		},
		messages: {
			// name_do_input: 'Mensagem'
			comment: 'Digite uma mensagem',
			author: 'Este campo é obrigatório',
			email: 'Digite um endereço de e-mail válido'
		},
		errorPlacement: function(label, element) {
			// label - elemento <label> gerado pelo validator
			// element - input validado
			// pegar o id do elmento e assim desconbrir o <label> como 'for' correspondente
			label.insertAfter( $('label[for=' + element.attr('id') + ']') );
		}
	});
	//remover label de error ao focar os inputs
	$('.form_element input, .form_element textarea').hover(function(){
		$(this).siblings('.error').fadeOut();
	});
	// método personalizado de validação - 'defaultInvalid'
	jQuery.validator.addMethod('defaultInvalid', function(value, element) {
		switch (element.value) {
			case 'Digite sua mensagem aqui':
				if (element.name == 'comment')
				return false;
				break;
			default: return true; 
				break;
		}
	});
	
	
	
});
