<?php
/**
 * ==================================================
 * META BOXES CONFIGURAÇÂO ==========================
 * ==================================================
 * 
 */
add_action( 'admin_init', 'my_meta_boxes' );
function my_meta_boxes(){
	$meta_boxes = array();
	
	$meta_boxes[] = array(
		'id' => 'work_description_box', 
		'title' => 'Descrição', 
		'post_type' => array('portfolio'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'work_description',
				'type' => 'duplicate_group',
				'layout' => 'block',
				'desc' => 'Caso seja usada a imagem extra, o alinhamento será ignorado e as duas imagens do bloco serão exibidas lado-a-lado, ocupando metade da largura da coluna',
				'group_itens' => array(
					array(
						'name' => 'type',
						'type' => 'radio',
						'label' => 'Tipo de item',
						'std' => 'text',
						'options' => array(
							'separator' => ' &nbsp; ',
							'values' => array(
								'text'  => 'apenas texto',
								'imagem_1' => 'uma imagem',
								'imagem_2' => 'duas imagens',
								'video_1'  => 'um vídeo',
								'video_2'  => 'dois vídeos',
							),
						),
					),
					array(
						'name' => 'image',
						'type' => 'special_image',
						'label' => 'Imagem',
						'options' => array(
							'image_size' => 'large',
							'layout' => 'row',
							'width' => 200,
						),
						'attr' => array('elem_class' => 'portfolio_image_1'),
					),
					array(
						'name' => 'image_extra',
						'type' => 'special_image',
						'label' => 'Imagem extra',
						'options' => array(
							'image_size' => 'large',
							'layout' => 'row',
							'width' => 200,
						),
						'attr' => array('elem_class' => 'portfolio_image_2'),
					),
					array(
						'name' => 'border',
						'type' => 'checkbox',
						'label' => 'Bordas arredondadas',
						'input_helper' => 'com bordas arredondadas',
						'attr' => array('elem_class' => 'portfolio_image_border'),
					),
					array(
						'name' => 'video',
						'type' => 'text',
						'size' => 'medium',
						'label' => 'Endereço do vídeo <small>(opcional)</small>',
						'input_helper' => 'Não esquecer do <code>http://</code>',
						'attr' => array('elem_class' => 'portfolio_video_1'),
					),
					array(
						'name' => 'video_extra',
						'type' => 'text',
						'size' => 'medium',
						'label' => 'Endereço do vídeo extra<small>(opcional)</small>',
						'input_helper' => 'Não esquecer do <code>http://</code>',
						'attr' => array('elem_class' => 'portfolio_video_2'),
					),
					array(
						'name' => 'align',
						'type' => 'radio',
						'label' => 'Alinhamento da imagem/vídeo',
						'std' => 'left',
						'options' => array(
							'separator' => ' ',
							'values' => array(
								'left' => 'Esquerda',
								'right' => 'Direita',
								'full' => 'Coluna cheia',
							),
						),
						'attr' => array('elem_class' => 'portfolio_align'),
					),
					array(
						'name' => 'desc',
						'type' => 'textarea_editor',
						'size' => 'full',
						'label' => 'Texto <small><label><input type="checkbox" class="sub-control-checkbox-desc" />mostrar editor</label></small>',
						'options' => array(
							'editor' => array(
								'toolbar' => 'formatselect bold italic link bullist numlist alignleft aligncenter alignright undo redo image charmap code',
								'buttons' => 'bold,italic,link,bullist,numlist,image,|,justifyleft,justifycenter,justifyright,|,undo,redo,|,code',
								'buttons2' => '',
							),
						),
						'attr' => array('elem_class' => 'portfolio_desc'),
					),
				)
			),
		)
	);
	
	$meta_boxes[] = array(
		'id' => 'work_gallery_box', 
		'title' => 'Galeria', 
		'post_type' => array('portfolio'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'work_gallery',
				'type' => 'duplicate_group',
				'layout' => 'block',
				'group_itens' => array(
					array(
						'name' => 'image',
						'type' => 'special_image',
						'label' => 'Imagem',
						'options' => array(
							'layout' => 'compact',
							'width' => false,
						),
					),
					array(
						'name' => 'caption',
						'type' => 'text',
						'size' => 'full',
						'label' => 'Legenda <small>(opcional)</small>',
					),
				)
			),
		)
	);
	
	$meta_boxes[] = array(
		'id' => 'work_color_box', 
		'title' => 'Cores', 
		'post_type' => array('portfolio'), 
		'context' => 'side', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'work_color_bg',
				'type' => 'color_picker',
				'label' => 'Cor do fundo',
				'layout' => 'block',
			),
			array(
				'name' => 'work_color_text',
				'type' => 'color_picker',
				'label' => 'Cor dos textos',
				'layout' => 'block',
			),
		)
	);
	
	
	$meta_boxes[] = array(
		'id' => 'post_special_image_box', 
		'title' => 'Imagem do Post', 
		'post_type' => array('portfolio'), 
		'context' => 'side', 
		'priority' => 'default',
		'help' => 'Você poderá enviar uma nova imagem ou escolher entre as imagens deste post ou uma da biblioteca.',
		'itens' => array(
			array(
				'name' => '_thumbnail_id',
				'type' => 'special_image',
				'layout' => 'block',
				'options' => array(
					'image_size' => 'large',
					'layout' => 'compact',
					'width' => 264,
				),
			),
		)
	);
	
	$my_meta_boxes = new BorosMetaBoxes( $meta_boxes );
}

add_filter( 'boros_form_element_work_description_desc_label', 'work_description_desc_label', 10, 2 );
function work_description_desc_label( $label, $obj ){
	$parent_values = get_post_meta($obj->context['post_id'], $obj->context['parent'], true);
	$name = str_replace('[desc]', '[desc_status]', $obj->data['name']);
	$checked = isset($parent_values[$obj->data['index']]['desc_status']) ? ' checked="checked"' : '';
	$label = "<span class='non_click_label'>Texto <small><label><input type='checkbox' class='sub-control-checkbox-desc' name='{$name}' {$checked} />mostrar editor</label></small></span>";
	return $label;
}

/* ========================================================================== */
/* REMOVER META BOXES ======================================================= */
/* ========================================================================== */
/**
 * Remover meta_boxes das telas de edição. As custom taxonomies são removidas nessa função em vez da declaração 'show_ui' => false',
 * pois assim é exibida as páginas de controle das taxonomias no menu principal, mas removendo os controles de histórias 
 * das páginas de edição.
 * 
 * Padrão de nomenclatura:
 * Hierachical Taxonomy:		"{$tax-name}div"
 * Non-Hierachical Taxonomy:	"tagsdiv-{$tax-name}"
 */
add_action('do_meta_boxes', 'remove_custom_meta_boxes', 10, 3);
function remove_custom_meta_boxes( $post_type, $context, $post ){
	global $wp_meta_boxes, $post;
	//pre($wp_meta_boxes);
	
	$removes = array(
		'portfolio' => array(
			'postimagediv',
		),
	);
	
	if( isset($removes[$post_type]) ){
		foreach( $removes[$post_type] as $box ){
			remove_meta_box( $box, $post_type, $context );
		}
	}
}

