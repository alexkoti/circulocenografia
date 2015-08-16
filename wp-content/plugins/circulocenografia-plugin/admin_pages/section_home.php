<?php
function section_home(){
	$args = array();
	
	$args = array();
	$args[] = array(
		'title' => 'Home',
		'desc' => 'Controles da página inicial do site',
		'block' => 'header',
	);
	$args[] = array(
		'id' => 'sliders_box',
		'title' => 'Sliders',
		'block' => 'section',
		'itens' => array(
			array(
				'name' => 'sliders', 
				'type' => 'duplicate_group',
				'label' => 'Slides',
				'label_helper' => 'Selecionar e configurar os slides',
				'options' => array(
					'compact_button' => true,
				),
				'group_itens' => array(
					array(
						'name' => 'text',
						'type' => 'textarea_editor',
						'label' => 'Texto',
						'size' => 'large',
					),
					array(
						'name' => 'link <small>opcional</small>',
						'type' => 'text',
						'label' => 'Link',
						'size' => 'large',
					),
					array(
						'name' => 'video',
						'type' => 'text',
						'label' => 'Vídeo <small>endereço do vídeo, opcional</small>',
						'size' => 'large',
					),
					array(
						'name' => 'image',
						'type' => 'special_image',
						'label' => 'Imagem',
						'options' => array(
							'image_size' => 'medium',
							'layout' => 'row',
							'width' => 100,
						),
					),
					array(
						'name' => 'active',
						'type' => 'checkbox',
						'label' => 'Ativado?',
						'input_helper' => 'ativado',
					),
				),
			),
		)
	);
	
	return $args;
}






