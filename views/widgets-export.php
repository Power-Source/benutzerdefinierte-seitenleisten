<?php
/**
 * Contents of the Import/Export popup in the widgets screen.
 *
 * This file is included in widgets.php.
 */
?>

<div class="wpmui-form module-export">
	<h2 class="no-pad-top"><?php _e( 'Exportieren', 'ps-sidebars' ); ?></h2>
	<form class="frm-export">
		<input type="hidden" name="do" value="export" />
		<p>
			<i class="dashicons dashicons-info light"></i>
			<?php
			_e(
				'Dadurch wird eine vollständige Exportdatei generiert, die alle Deine ' .
				'Seitenleisten und die aktuelle Seitenleistenkonfiguration enthält.', 'ps-sidebars'
			);
			?>
		</p>
		<p>
			<label for="description"><?php _e( 'Optionale Beschreibung für die Exportdatei:', 'ps-sidebars' ); ?></label><br />
			<textarea id="description" name="export-description" placeholder="" cols="80" rows="3"></textarea>
		</p>
		<p>
			<button class="button-primary">
				<i class="dashicons dashicons-download"></i> <?php _e( 'Exportieren', 'ps-sidebars' ); ?>
			</button>
        </p>
        <?php wp_nonce_field( 'ps-sidebars-export' ); ?>
	</form>
	<hr />
	<h2><?php _e( 'Importieren', 'ps-sidebars' ); ?></h2>
	<form class="frm-preview-import">
		<input type="hidden" name="do" value="preview-import" />
		<p>
			<label for="import-file"><?php _e( 'Wähle eine zu importierende Datei aus', 'ps-sidebars' ); ?></label>
			<input type="file" id="import-file" name="data" />
		</p>
		<p>
			<button class="button-primary">
				<i class="dashicons dashicons-upload"></i> <?php _e( 'Vorschau', 'ps-sidebars' ); ?>
			</button>
		</p>
        <?php wp_nonce_field( 'ps-sidebars-import' ); ?>
	</form>
</div>
