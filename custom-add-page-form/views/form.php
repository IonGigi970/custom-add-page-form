<div class="capf-form">
	<form action="" method="POST">
		<?php wp_nonce_field( CUSTOM_ADD_PAGE_FORM_NONCE_BN, CUSTOM_ADD_PAGE_FORM_NONCE_KEY ); ?>
		<div class="form-field">
			<label for="title"><?php esc_html_e( 'Title', 'custom-add-page-form' ); ?></label>
			<input type="text" name="title">
		</div>
		<div class="form-field">
			<label for="title"><?php esc_html_e( 'Content', 'custom-add-page-form' ); ?></label>
			<textarea name="content"></textarea>
		</div>
		<div class="form-field">
			<button type="submit" class="button btn"><?php esc_html_e( 'Add', 'custom-add-page-form' ); ?></button>
		</div>
	<form>
	<?php if ( ! empty( $notification ) ) : ?>
		<p class="notification notification-<?php esc_attr_e( $notification['type'] ); ?>">
			<?php echo $notification['message']; ?>
		</p>
	<?php endif; ?>
</div>