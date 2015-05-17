<?php
function section_content(){
	$args = array();
	$args[] = array(
		'title' => 'Opções gerais de conteúdo',
		'desc' => '',
		'block' => 'header',
	);
	$args[] = array(
		'id' => 'site_options_logo',
		'title' => 'Logo',
		'desc' => 'Definir o logo da barra superior do site',
		'block' => 'section',
		'itens' => array(
			array(
				'name' => 'site_logo',
				'type' => 'radio',
				'layout' => 'block',
				'options' => array(
					'separator' => ' ',
					'values' => array(
						'1' => '<span id="option_logo_1" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-1.png" alt="" /></span>',
						'2' => '<span id="option_logo_2" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-2.png" alt="" /></span>',
						'3' => '<span id="option_logo_3" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-3.png" alt="" /></span>',
						'4' => '<span id="option_logo_4" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-4.png" alt="" /></span>',
						'5' => '<span id="option_logo_5" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-5.png" alt="" /></span>',
						'6' => '<span id="option_logo_6" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-6.png" alt="" /></span>',
						'7' => '<span id="option_logo_7" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-7.png" alt="" /></span>',
						'8' => '<span id="option_logo_8" class="option_logo"><img src="' . CSS_IMG . '/circulo-cenografia-logo-8.png" alt="" /></span>',
					),
				),
			),
		),
	);
	$args[] = array(
		'id' => 'site_options_footer',
		'title' => 'Rodapé',
		//'desc' => 'Texto do rodapé',
		'block' => 'section',
		'itens' => array(
			array(
				'name' => 'site_footer_text',
				'type' => 'wp_editor',
				'label' => 'Texto do rodapé',
			),
		),
	);
	return $args;
}






