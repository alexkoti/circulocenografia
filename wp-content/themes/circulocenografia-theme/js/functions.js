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
		var link = $(this);
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
			console.log(1);
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
			console.log(2);
			link.closest('.portfolio-category-menu-item').find('.portfolio-category-items').slideDown();
		}
		// esconder o menu após o click apenas se for a página porfolio
		if( $('body').is('.item-name-portfolio') ){
			$('.row-offcanvas, html, body').removeClass('active');
		}
	});
	
	
	
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
