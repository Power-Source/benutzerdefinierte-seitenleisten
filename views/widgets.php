<?php
/**
 * Updates the default widgets page of the admin area.
 * There are some HTML to be added for having all the functionality, so we
 * include it at the begining of the page, and it's placed later via js.
 */
?>

<div id="cs-widgets-extra">

	<?php /*
	============================================================================
	===== WIDGET head
	============================================================================
	*/ ?>
	<div id="cs-title-options">
		<h2><?php _e( 'Seitenleisten', 'ps-sidebars' ); ?></h2>
		<div id="cs-options" class="csb cs-options">
			<button type="button" class="button button-primary cs-action btn-create-sidebar">
				<i class="dashicons dashicons-plus-alt"></i>
				<?php _e( 'Neue Seitenleiste erstellen', 'ps-sidebars' ); ?>
			</button>
			<?php
			/**
			 * Show additional functions in the widget header.
			 */
			do_action( 'cs_widget_header' );
			?>
		</div>
	</div>


	<?php /*
	============================================================================
	===== LANGUAGE
	============================================================================
	*/ ?>
	<script>
	csSidebarsData = {
		'title_edit': "<?php _e( 'Bearbeiten [Sidebar]', 'ps-sidebars' ); ?>",
		'title_new': "<?php _e( 'Neue benutzerdefinierte Seitenleiste', 'ps-sidebars' ); ?>",
		'btn_edit': "<?php _e( 'Änderungen speichern', 'ps-sidebars' ); ?>",
		'btn_new': "<?php _e( 'Erstelle Seitenleiste', 'ps-sidebars' ); ?>",
		'title_delete': "<?php _e( 'Lösche Seitenleiste', 'ps-sidebars' ); ?>",
		'title_location': "<?php _e( 'Definiere wo diese Seitenleiste angezeigt werden soll.', 'ps-sidebars' ); ?>",
		'title_export': "<?php _e( 'Seitenleisten importieren/exportieren', 'ps-sidebars' ); ?>",
		'benutzerdefinierte_seitenleisten': "<?php _e( 'Benutzerdefinierte Seitenleisten', 'ps-sidebars' ); ?>",
		'theme_sidebars': "<?php _e( 'Theme Seitenleisten', 'ps-sidebars' ); ?>",
		'ajax_error': "<?php _e( 'Daten aus ClassicPress konnten nicht geladen werden ...', 'ps-sidebars' ); ?>",
		'lbl_replaceable': "<?php _e( 'Diese Seitenleiste kann auf bestimmten Seiten ersetzt werden', 'ps-sidebars' ); ?>",
		'replace_tip': "<?php _e( 'Aktiviere diese Option, um die Seitenleiste durch eine Deiner benutzerdefinierten Seitenleisten zu ersetzen.', 'ps-sidebars' ); ?>",
		'filter': "<?php _e( 'Filter...', 'ps-sidebars' ); ?>",
		'replaceable': <?php echo json_encode( (object) BenutzerdefinierteSeitenleisten::get_options( 'modifiable' ) ); ?>,
		'_wpnonce_get': "<?php echo esc_attr( wp_create_nonce( 'ps-sidebars-get' ) ); ?>"
	};
	</script>


	<?php /*
	============================================================================
	===== TOOLBAR for custom sidebars
	============================================================================
	*/ ?>
	<div class="cs-custom-sidebar cs-toolbar">
		<a
			class="cs-tool delete-sidebar"
			data-action="delete"
			href="#"
			title="<?php _e( 'Lösche diese Seitenleiste.', 'ps-sidebars' ); ?>"
			>
			<i class="dashicons dashicons-trash"></i>
		</a>
		<span class="cs-separator">|</span>
		<a
			class="cs-tool"
			data-action="edit"
			href="#"
			title="<?php _e( 'Bearbeite diese Seitenleiste.', 'ps-sidebars' ); ?>"
			>
			<?php _e( 'Bearbeiten', 'ps-sidebars' ); ?>
		</a>
		<span class="cs-separator">|</span>
		<a
			class="cs-tool"
			data-action="location"
			href="#"
			title="<?php _e( 'Wo möchten Sie die Seitenleiste anzeigen?', 'ps-sidebars' ); ?>"
			>
			<?php _e( 'Seitenleisten Position', 'ps-sidebars' ); ?>
		</a>
		<span class="cs-separator">|</span>
	</div>


	<?php /*
	============================================================================
	===== TOOLBAR for theme sidebars
	============================================================================
	*/ ?>
	<div class="cs-theme-sidebar cs-toolbar">
		<label
			for="cs-replaceable"
			class="cs-tool btn-replaceable"
			data-action="replaceable"
			data-on="<?php _e( 'Diese Seitenleiste kann auf bestimmten Seiten ersetzt werden', 'ps-sidebars' ); ?>"
			data-off="<?php _e( 'Diese Seitenleiste ist auf allen Seiten immer gleich', 'ps-sidebars' ); ?>"
			>
			<span class="icon"></span>
			<input
				type="checkbox"
				id=""
				class="has-label chk-replaceable"
				/>
			<span class="is-label">
				<?php _e( 'Lasse diese Seitenleiste ersetzen', 'ps-sidebars' ); ?>
			</span>
		</label>
	</div>


	<?php /*
	============================================================================
	===== DELETE SIDEBAR confirmation
	============================================================================
	*/ ?>
	<div class="cs-delete">
	<?php include CSB_VIEWS_DIR . 'widgets-delete.php'; ?>
	</div>


	<?php /*
	============================================================================
	===== ADD/EDIT SIDEBAR
	============================================================================
	*/ ?>
	<div class="cs-editor">
	<?php include CSB_VIEWS_DIR . 'widgets-editor.php'; ?>
	</div>


	<?php /*
	============================================================================
	===== EXPORT
	============================================================================
	*/ ?>
	<div class="cs-export">
	<?php include CSB_VIEWS_DIR . 'widgets-export.php'; ?>
	</div>

	<?php /*
	============================================================================
	===== LOCATION popup.
	============================================================================
	*/ ?>
	<div class="cs-location">
	<?php include CSB_VIEWS_DIR . 'widgets-location.php'; ?>
	</div>

 </div>
