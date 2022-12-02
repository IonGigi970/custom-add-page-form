<div class="capf-list">
	<ul>
		<?php foreach( $page_ids as $page_id ) : ?>
			<li class="page">
				<a href="<?php esc_attr_e( get_permalink( $page_id ) ); ?>"><?php esc_html_e( get_the_title( $page_id ) ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>