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
						'name' => 'align',
						'type' => 'radio',
						'label' => 'Alinhamento da imagem',
						'std' => 'left',
						'options' => array(
							'separator' => ' ',
							'values' => array(
								'left' => 'Esquerda',
								'right' => 'Direita',
								'full' => 'Coluna cheia',
							),
						),
					),
					array(
						'name' => 'desc',
						'type' => 'textarea_editor',
						'size' => 'full',
						'label' => 'Texto',
						'options' => array(
							'editor' => array(
								'toolbar' => 'formatselect bold italic link bullist numlist alignleft aligncenter alignright undo redo image charmap code',
								'buttons' => 'bold,italic,link,bullist,numlist,image,|,justifyleft,justifycenter,justifyright,|,undo,redo,|,code',
								'buttons2' => '',
							),
						),
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
	
	$my_meta_boxes = new BorosMetaBoxes( $meta_boxes );
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
		'post' => array(
			'postimagediv',
			'categorydiv',
		),
	);
	
	if( isset($removes[$post_type]) ){
		foreach( $removes[$post_type] as $box ){
			remove_meta_box( $box, $post_type, $context );
		}
	}
}

