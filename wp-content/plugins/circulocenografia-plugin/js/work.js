/**
 * Scripts válidos apenas para o trabalho atual
 * 
 */

jQuery(document).ready(function($){
	
	/**
	 * ==================================================
	 * Montador de descrição do portfolio ===============
	 * ==================================================
	 * 
	 * 
	 */
	function circulo_portfolio_showhide_textarea( obj ){
		if( obj.is(':checked') ){
			obj.closest('tr').find('.boros_element_textarea_editor').addClass('textarea_editor_show');
		}
		else{
			obj.closest('tr').find('.boros_element_textarea_editor').removeClass('textarea_editor_show');
		}
	}
	
	function circulo_portfolio_showhide_fields( obj ){
		var val = obj.val();
		var duplicate_element = obj.closest('.duplicate_element');
		
		// primeiro esconder todos
		duplicate_element.find('.portfolio_image_1, .portfolio_image_2, .portfolio_image_border, .portfolio_video_1, .portfolio_video_2, .portfolio_align').addClass('hide').removeClass('show');
		
		// atualizar data-checked (correção de bug)
		duplicate_element.find('[type=radio]').attr('data-checked', 0);
		obj.attr('data-checked', 1);
		
		if( val == 'imagem_1' ){
			duplicate_element.find('.portfolio_image_1, .portfolio_image_border, .portfolio_align').addClass('show').removeClass('hide');
		}
		else if( val == 'imagem_2' ){
			duplicate_element.find('.portfolio_image_1, .portfolio_image_2, .portfolio_image_border').addClass('show').removeClass('hide');
		}
		else if( val == 'video_1' ){
			duplicate_element.find('.portfolio_video_1, .portfolio_align').addClass('show').removeClass('hide');
		}
		else if( val == 'video_2' ){
			duplicate_element.find('.portfolio_video_1, .portfolio_video_2').addClass('show').removeClass('hide');
		}
		else if( val == 'text' ){
			var checkbox = duplicate_element.find('.sub-control-checkbox-desc:first');
			checkbox.prop('checked', true);
			circulo_portfolio_showhide_textarea(checkbox);
		}
	}
	
	if( $('#work_description_box').length ){
		// mostrar/esconder textarea ao clicar
		$('#work_description_box').on('change', '.sub-control-checkbox-desc', function(){
			circulo_portfolio_showhide_textarea( $(this) );
		});
		
		// mostrar/esconder textarea onload
		$('#work_description_box .sub-control-checkbox-desc').each(function(){
			circulo_portfolio_showhide_textarea( $(this) );
		});
		
		// mostrar/esconder campos ao clicar
		$('#work_description_box').delegate('.boros_element_radio input:radio', 'change', function(){
			var name = $(this).dataset('name');
			if( name == 'type' ){
				circulo_portfolio_showhide_fields( $(this) );
			}
		});
		
		// mostrar/esconder campos onload
		$('.duplicate_group').bind('sortcreate', function(event, ui) {
			console.log('sortcreate');
			$(this).find('.duplicate_element input[name*="type"]').each(function(){
				$(this).attr('data-checked', 0);
				if( $(this).is(':checked') ){
					$(this).attr('data-checked', 1);
					circulo_portfolio_showhide_fields( $(this) );
				}
			});
		});
		
		// mostrar/esconder campos on duplicate
		$('.duplicate_group').bind('duplicate_group_complete', function(event, ui){
			$('#work_description_box .duplicate_element:last-child input[name*="type"]').each(function(){
				$(this).attr('data-checked', 0);
				if( $(this).is(':checked') ){
					$(this).attr('data-checked', 1);
					circulo_portfolio_showhide_fields( $(this) );
				}
			});
		});
	}
	
	
	
	/**
	$('.duplicate_group').bind('duplicate_group_complete sortcreate', function(event, ui) {
		$(this).find('.duplicate_element input[name*="type"]').each(function(){
			$(this).attr('data-checked', 0);
			if( $(this).is(':checked') ){
				$(this).attr('data-checked', 1);
				slider_home_options( $(this), $(this).val() );
			}
		});
	});
	
	function slider_home_options( obj, val ){
		var duplicate_element = obj.closest('.duplicate_element');
		
		duplicate_element.find('.content_slide').addClass('hide').removeClass('show');
		duplicate_element.find('.video_slide').addClass('hide').removeClass('show');
		duplicate_element.find('.custom_slide').addClass('hide').removeClass('show');
		
		// atualizar data-checked
		duplicate_element.find('[type=radio]').attr('data-checked', 0);
		obj.attr('data-checked', 1);
		
		if( val == 'content' ){
			duplicate_element.find('.content_slide').addClass('show').removeClass('hide');
			if( duplicate_element.find('.related_item_list li').length ){
				duplicate_element.find('.search_content_inputs').hide();
			}
		}
		else if( val == 'video' ){
			duplicate_element.find('.video_slide').addClass('show').removeClass('hide');
			duplicate_element.find('.custom_slide').addClass('show').removeClass('hide');
		}
		else if( val == 'custom' ){
			duplicate_element.find('.custom_slide').addClass('show').removeClass('hide');
		}
	}
	
	// search content
	$('#box_slider_home').delegate('.result_select', 'click', function(){
		var $box = $(this).closest('.search_content_box');
		$box.find('.search_content_clear').trigger('click');
		$box.find('.search_content_inputs').slideUp();
	});
	$('#box_slider_home').delegate('.result_deselect', 'click', function(){
		var $box = $(this).closest('.search_content_box');
		$box.find('.search_content_inputs').slideDown();
	});
	
	// radios
	$('#box_slider_home').delegate('.boros_element_radio input:radio', 'change', function(){
		var name = $(this).dataset('name');
		if( name == 'type' ){
			slider_home_options( $(this), $(this).val() );
		}
	});
	/**/
	
});