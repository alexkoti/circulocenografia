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
						'name' => 'subtitle',
						'type' => 'text',
						'size' => 'full',
						'label' => 'Subtítulo <small>(opcional)</small>',
					),
					array(
						'name' => 'desc',
						'type' => 'wp_editor',
						'size' => 'full',
						'label' => 'Texto',
						'options' => array(
							'media_buttons' => true,
						),
					),
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
							'values' => array(
								'left' => 'Esquerda',
								'right' => 'Direita',
							),
						),
					),
				)
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

