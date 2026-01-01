<?php
/**
 * Contents of the Add/Edit sidebar popup in the widgets screen.
 *
 * This file is included in widgets.php.
 */
?>

<form class="wpmui-form">
	<input type="hidden" name="do" value="save" />
	<input type="hidden" name="sb" id="csb-id" value="" />
<?php wp_nonce_field( 'ps-sidebars-edit-sidebar' ); ?>
	<div class="wpmui-grid-8 no-pad-top">
		<div class="col-3">
			<label for="csb-name"><?php _e( 'Name', 'ps-sidebars' ); ?></label>
			<input type="text" name="name" id="csb-name" maxlength="40" placeholder="<?php _e( 'Name der Seitenleiste hier...', 'ps-sidebars' ); ?>" />
			<div class="hint"><?php _e( 'Der Name sollte eindeutig sein.', 'ps-sidebars' ); ?></div>
		</div>
		<div class="col-5">
			<label for="csb-description"><?php _e( 'Beschreibung', 'ps-sidebars' ); ?></label>
			<input type="text" name="description" id="csb-description" maxlength="200" placeholder="<?php _e( 'Beschreibung der Seitenleiste hier...', 'ps-sidebars' ); ?>" />
		</div>
	</div>
	<hr class="csb-more-content" />
	<div class="wpmui-grid-8 csb-more-content">
		<div class="col-8 hint">
			<strong><?php _e( 'Vorsicht:', 'ps-sidebars' ); ?></strong>
			<?php _e(
				'Vorher-Nachher-Titel-Widget-Eigenschaften definieren den HTML-Code, ' .
				'der die Widgets und ihre Titel in die Seitenleisten einschließt. Weitere Informationen dazu findest Du auf dem '.
				'<a href="http://justintadlock.com/archives/2010/11/08/sidebars-in-wordpress" target="_blank">Justin ' .
				'Tadlock Blog</a>. Verwende diese Felder nicht, wenn Du nicht sicher bist, was Du tust. Dies kann das Design Deiner ' .
				'Webseite beeinträchtigen. Lasse diese Felder leer, um das Design der Seitenleisten des Themas zu verwenden.', 'ps-sidebars'
			); ?>
		</div>
	</div>
	<div class="wpmui-grid-8 csb-more-content">
		<div class="col-4">
			<label for="csb-before-title"><?php _e( 'Vor dem Titel', 'ps-sidebars' ); ?></label>
			<textarea rows="4" name="before_title" id="csb-before-title"></textarea>
		</div>
		<div class="col-4">
			<label for="csb-after-title"><?php _e( 'Nach dem Titel', 'ps-sidebars' ); ?></label>
			<textarea rows="4" name="after_title" id="csb-after-title"></textarea>
		</div>
	</div>
	<div class="wpmui-grid-8 csb-more-content">
		<div class="col-4">
			<label for="csb-before-widget"><?php _e( 'Vor dem Widget', 'ps-sidebars' ); ?></label>
			<textarea rows="4" name="before_widget" id="csb-before-widget"></textarea>
		</div>
		<div class="col-4">
			<label for="csb-after-widget"><?php _e( 'Nach dem Widget', 'ps-sidebars' ); ?></label>
			<textarea rows="4" name="after_widget" id="csb-after-widget"></textarea>
		</div>
	</div>
	<div class="buttons">
		<label for="csb-more" class="wpmui-left">
			<input type="checkbox" id="csb-more" />
			<?php _e( 'Erweitert - Bearbeite den benutzerdefinierten Wrapper-Code', 'ps-sidebars' ); ?>
		</label>

		<button type="button" class="button-link btn-cancel"><?php _e( 'Abrechen', 'ps-sidebars' ); ?></button>
		<button type="button" class="button-primary btn-save"><?php _e( 'Seitenleiste erstellen', 'ps-sidebars' ); ?></button>
	</div>
</form>
