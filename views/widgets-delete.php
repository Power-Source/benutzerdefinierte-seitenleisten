<?php
/**
 * Contents of the Delete-sidebar popup in the widgets screen.
 *
 * This file is included in widgets.php.
 */
?>

<div class="wpmui-form">
	<div>
	<?php _e(
		'Bitte bestätige, dass Du die <strong class="name"></strong>Seitenleiste löschen möchtest<strong class="name"></strong>.', 'ps-sidebars'
	); ?>
	</div>
	<div class="buttons">
		<button type="button" class="button-link btn-cancel"><?php _e( 'Abbrechen', 'ps-sidebars' ); ?></button>
		<button type="button" class="button-primary btn-delete"><?php _e( 'Ja, lösche sie', 'ps-sidebars' ); ?></button>
<?php wp_nonce_field( 'ps-sidebars-delete-sidebar', '_wp_nonce_cs_delete_sidebar' ); ?>
	</div>
</div>
