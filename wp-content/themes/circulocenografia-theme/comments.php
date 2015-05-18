<?php
/**
 * Artigo para entender melhor os hooks de comentários:
 * @link http://wpengineer.com/2205/comment-form-hooks-visualized/
 * 
 * Adicionar campos no form de comentários
 * @link http://wpengineer.com/2214/adding-input-fields-to-the-comment-form/
 */
?>
		<div id="comments">
			
		<?php
		if( post_password_required() ){
			echo '<p class="nopassword">Este post está protegido por senha.</p></div>';
			return;
		}
		?>

		<?php if( have_comments() ){ ?>
			<h2>Comentários</h2>
			
			<?php
			// comments navigations above
			if( get_comment_pages_count() > 1 && get_option( 'page_comments' ) )
				$paged_comments = true;
			if( isset($paged_comments) && $paged_comments ){
			?>
			<nav id="comment-nav-above" class="navigation" role="navigation">
				<?php paginate_comments_links(); ?>
			</nav> <!-- .navigation -->
			<?php } ?>

				<ol class="dl_list dl_list_comments list-unstyled">
					<?php
					// incluir modelo de comment single
					include_once('comment.php');
					wp_list_comments( array('callback' => 'boros_comment_template') );
					?>
				</ol>

			<?php
			// comments navigations below
			if( isset($paged_comments) && $paged_comments ){
			?>
			<nav id="comment-nav-below" class="navigation" role="navigation">
				<?php paginate_comments_links(); ?>
			</nav><!-- .navigation -->
			<?php } ?>

		<?php } else { ?>
		
			<?php if( ! comments_open() ){ ?>
			<p class="nocomments">Comentários fechados para este post.</p>
			<?php } ?>
			
		<?php } ?>

<?php
/**
 * Formulário de comments
 * 
 * 
 */
 
$commenter = wp_get_current_commenter();

$name_field_value = ( !empty($commenter['comment_author']) ) ? esc_attr( $commenter['comment_author'] ) : '';
$email_field_value = ( !empty($commenter['comment_author_email']) ) ? esc_attr( $commenter['comment_author_email'] ) : '';

$comment_type = 'comentario';
$fields =  array(
	'simple_text'	=>	'<p>Seu e-mail não será publicado. Seu comentário poderá ser moderado.</p>',
	'author'		=>	'<div class="form-group form_element form_element_text" id="comment-form-author">
							<label for="author">Nome</label>
							<input type="text" size="30" value="' . $name_field_value . '" name="author" class="form-control" id="author">
						</div>',
	'email'			=>	'<div class="form-group form_element form_element_text" id="comment-form-email">
							<label for="email">E-mail (não será publicado)</label>
							<input type="text" size="30" value="' . $email_field_value . '" name="email" class="form-control" id="email">
						</div>',
	'url'			=>	'<div class="form-group form_element form_element_text comment-form-url">
							<label for="url">Site</label>
							<input type="text" size="30" value="' . esc_attr( $commenter['comment_author_url'] ) . '" name="url" class="form-control" id="url">
						</div>',
);

$args = array(
	'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
	'comment_field'        => '<div class="form-group form_element form_element_textarea" id="comment-form-message">
									<label for="comment">Comentário</label><br>
									<textarea placeholder="Digite sua mensagem aqui" class="form-control required" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
								</div>',
	'comment_notes_before' => '',
	'comment_notes_after'  => '',
	'id_submit'            => 'comment_submit',
	'class_submit'         => 'btn btn-default',
	'label_submit'         => 'Enviar',
);
comment_form( $args );
?>

		</div>
