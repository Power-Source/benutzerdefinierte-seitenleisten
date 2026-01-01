<?php
/**
 * Contents of the Location popup in the widgets screen.
 * User can define default locations where the custom sidebar will be used.
 *
 * This file is included in widgets.php.
 */

$sidebars = BenutzerdefinierteSeitenleisten::get_sidebars( 'theme' );

/**
 * Output the input fields to configure replacements for a single sidebar.
 *
 * @since  2.0
 * @param  array $sidebar Details provided by BenutzerdefinierteSeitenleisten::get_sidebar().
 * @param  string $prefix Category specific prefix used for input field ID/Name.
 * @param  string $cat_name Used in label: "Replace sidebar for <cat_name>".
 * @param  string $class Optinal classname added to the wrapper element.
 */
if ( ! function_exists( '_show_replaceable' ) ) {
	function _show_replaceable( $sidebar, $prefix, $cat_name, $class = '' ) {
		$base_id = 'cs-' . $prefix;
		$inp_id = $base_id . '-' . $sidebar['id'];
		$inp_name = '___cs___' . $prefix . '___' . $sidebar['id'];
		$sb_id = $sidebar['id'];
		$class = (empty( $class ) ? '' : ' ' . $class);
?>
    <div
        class="cs-replaceable <?php echo esc_attr( $sb_id . $class ); ?>"
        data-lbl-used="<?php _e( 'Ersetzt durch eine andere Seitenleiste:', 'ps-sidebars' ); ?>"
        >
        <label for="<?php echo esc_attr( $inp_id ); ?>">
            <input type="checkbox"
                id="<?php echo esc_attr( $inp_id ); ?>"
                class="detail-toggle"
                />
<?php printf(
	__( 'Als <strong>%1$s</strong> für ausgewählte %2$s', 'ps-sidebars' ),
	$sidebar['name'],
	$cat_name
); ?>
        </label>
        <div class="details">
            <select
                data-id="<?php echo esc_attr( $prefix ); ?>"
                class="cs-datalist <?php echo esc_attr( $base_id ); ?>"
                name="<?php echo esc_attr( $inp_name ); ?>[]"
                multiple="multiple"
                placeholder="<?php echo esc_attr(
					sprintf(
						__( 'Klicke hier, um verfügbare %1$s auszuwählen', 'ps-sidebars' ),
						$cat_name
					)
				); ?>"
            >
            </select>
        </div>
    </div>
<?php
	}
}
?>
<form class="frm-location wpmui-form">
	<input type="hidden" name="do" value="set-location" />
	<input type="hidden" name="sb" class="sb-id" value="" />

	<div class="cs-title">
		<h3 class="no-pad-top">
			<span class="sb-name">...</span>
		</h3>
	</div>
	<p class="message unique-post">
		<i class="dashicons dashicons-info light"></i>
		<?php
		printf(
			__(
				' Um diese Seitenleiste an einen eindeutigen Beitrag oder eine Seite anzuhängen, besuche bitte ' .
				'diesen <a href="%1$s">Beitrag</a> oder diese <a href="%2$s">Seite</a> & stelle sie mit ' .
				'der Seitenleisten-Metabox ein.', 'ps-sidebars'
			),
			admin_url( 'edit.php' ),
			admin_url( 'edit.php?post_type=page' )
		);
		?>
	</p>

<div class="hidden">
	<p class="message no-sidebars"><?php _e( 'Es gibt keine austauschbaren Seitenleisten. Bitte erlaube mindestens eine als austauschbar.', 'ps-sidebars' ); ?></p>
</div>
	<?php
	/**
	 * =========================================================================
	 * Box 1: SINGLE entries (single pages, categories)
	 */
	?>
	<div class="wpmui-box">
		<h3>
			<a href="#" class="toggle" title="<?php _e( 'Klicken zum Umschalten', 'ps-sidebars' ); ?>"><br></a>
			<span><?php _e( 'Für alle Einzeleinträge, die ausgewählten Kriterien entsprechen', 'ps-sidebars' ); ?></span>
		</h3>
		<div class="inside">
			<p><?php _e( 'Diese Ersetzungen werden auf jeden einzelnen Beitrag angewendet, der einem bestimmten Beitragstyp oder einer bestimmten Kategorie entspricht.', 'ps-sidebars' ); ?>

			<div class="cs-half">
			<?php
			/**
			 * ========== SINGLE -- Categories ========== *
			 */
			foreach ( $sidebars as $sb_id => $details ) {
				$cat_name = __( 'Kategorien', 'ps-sidebars' );
				_show_replaceable( $details, 'cat', $cat_name );
			}
			?>
			</div>

			<div class="cs-half">
			<?php
			/**
			 * ========== SINGLE -- Post-Type ========== *
			 */
			foreach ( $sidebars as $sb_id => $details ) {
				$cat_name = __( 'Beitragstypen', 'ps-sidebars' );
				_show_replaceable( $details, 'pt', $cat_name );
			}
			?>
            </div>
<?php
			/**
			 * Custom Taxonomies
			 */
			$taxonomies = BenutzerdefinierteSeitenleistenEditor::get_custom_taxonomies( 'allowed' );
foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
	echo '<div class="cs-half cf-custom-taxonomies">';
	foreach ( $sidebars as $sb_id => $details ) {
		_show_replaceable( $details, $taxonomy_slug, $taxonomy->label );
	}
	echo '</div>';
}
?>
        </div>
    </div>
<?php
	/**
	 * =========================================================================
	 * Box 2: ARCHIVE pages
	 */
	?>
	<div class="wpmui-box closed">
		<h3>
			<a href="#" class="toggle" title="<?php _e( 'Klicken zum Umschalten', 'ps-sidebars' );?>"><br></a>
			<span><?php _e( 'Für Archive', 'ps-sidebars' ); ?></span>
		</h3>
		<div class="inside">
			<p><?php _e( 'Diese Ersetzungen werden auf Beiträge und Seiten vom Typ Archiv angewendet.', 'ps-sidebars' ); ?>
			<h3 class="wpmui-tabs">
				<a href="#tab-arch" class="tab active"><?php _e( 'Archivtypen', 'ps-sidebars' ); ?></a>
				<a href="#tab-catg" class="tab"><?php _e( 'Kategorie Archive', 'ps-sidebars' ); ?></a>
				<a href="#tab-aut" class="tab"><?php _e( 'Autoren', 'ps-sidebars' ); ?></a>
			</h3>
			<div class="wpmui-tab-contents">
				<div id="tab-arch" class="tab active">
					<?php
					/**
					 * ========== ARCHIVE -- Special ========== *
					 */
					foreach ( $sidebars as $sb_id => $details ) {
						$cat_name = __( 'Archivtypen', 'ps-sidebars' );
						_show_replaceable( $details, 'arc', $cat_name );
					}
					?>
				</div>
				<div id="tab-catg" class="tab">
					<?php
					/**
					 * ========== ARCHIVE -- Category ========== *
					 */
					foreach ( $sidebars as $sb_id => $details ) {
						$cat_name = __( 'Kategorie Archive', 'ps-sidebars' );
						_show_replaceable( $details, 'arc-cat', $cat_name );
					}
					?>
				</div>
				<div id="tab-aut" class="tab">
					<?php
					/**
					 * ========== ARCHIVE -- Author ========== *
					 */
					foreach ( $sidebars as $sb_id => $details ) {
						$cat_name = __( 'Autoren Archive', 'ps-sidebars' );
						_show_replaceable( $details, 'arc-aut', $cat_name );
					}
					?>
				</div>
			</div>
		</div>
    </div>

<?php
	/**
	 * =========================================================================
	 * Box 3: SCREEN size
	 */
	?>
	<div class="wpmui-box closed csb-media-screen-width">
		<h3>
			<a href="#" class="toggle" title="<?php _e( 'Klicken zum Umschalten', 'ps-sidebars' ); ?>"><br></a>
			<span><?php _e( 'Für Bildschirmgrößen', 'ps-sidebars' ); ?></span>
        </h3>
        <div class="inside">
            <p class="description"><?php _e( 'Diese Einstellungen laden keine Seitenleisten zum Entladen, sondern blenden nur Widgets ein oder aus, NICHT SIDEBARS, abhängig von der Bildschirmbreite des Mediums.', 'ps-sidebars' ); ?></p>
            <table class="form-table">
                <thead>
                    <tr>
                        <th><?php echo esc_attr_x( 'Bildschirm', 'Medienbildschirmbreitentabelle', 'ps-sidebars' ); ?></th>
                        <th><?php echo esc_attr_x( 'Zeige',  'Medienbildschirmbreitentabelle', 'ps-sidebars' ); ?></th>
                        <th><?php echo esc_attr_x( 'Bildschirmbreite', 'Medienbildschirmbreitentabelle',  'ps-sidebars' ); ?></th>
                        <th class="num"><span class="dashicons dashicons-trash"></span></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr><td colspan="3"><div class="notice notice-info inline"><p><?php esc_html_e( 'Es gibt keine definierten Regeln.', 'ps-sidebars' ); ?></p></div></td></tr>
                </tfoot>
            </table>
            <button class="button btn-add-rule"><?php esc_html_e( 'Neue Regel hinzufügen', 'ps-sidebars' ); ?></button>
        </div>
    </div>

	<?php
	/**
	 * =========================================================================
	 * Box 4: Plugin integration
	 */
					$integrations = apply_filters( 'benutzerdefinierte_seitenleisten_integrations', array() );
	if ( ! empty( $integrations )  ) {
	?>
	<div class="wpmui-box closed cs-3rd-part">
<h3>
<a href="#" class="toggle" title="<?php _e( 'Klicken zum Umschalten', 'ps-sidebars' ); ?>"><br></a>
<span><?php _e( 'Plugins von Drittanbietern', 'ps-sidebars' ); ?></span>
</h3>
<div class="inside">
<p><?php _e( 'Diese Ersetzungen werden auf Plugins von Drittanbietern angewendet.', 'ps-sidebars' ); ?>

<h3 class="wpmui-tabs">
<?php
		$classes = array( 'tab', 'active' );
foreach ( $integrations as $id => $one ) {
	printf(
		'<a href="#tab-%s" class="%s">%s</a>',
		esc_attr( $id ),
		esc_attr( implode( ' ', $classes ) ),
		esc_html( $one['title'] )
	);
	$classes = array( 'tab' );
}
?>
</h3>
<div class="wpmui-tab-contents">
<?php
		$classes = array( 'tab', 'active' );
foreach ( $integrations as $id => $one ) {
	printf(
		'<div id="tab-%s" class="%s">',
		esc_attr( $id ),
		esc_attr( implode( ' ', $classes ) )
	);
	foreach ( $sidebars as $sb_id => $details ) {
		_show_replaceable( $details, $id, $one['cat_name'] );
	}
	echo '</div>';
	$classes = array( 'tab' );
}
?>
</div>
</div>
</div>
<?php
	}
?>

	<div class="buttons">
		<button type="button" class="button-link btn-cancel"><?php _e( 'Abbrechen', 'ps-sidebars' ); ?></button>
		<button type="button" class="button-primary btn-save"><?php _e( 'Änderungen speichern', 'ps-sidebars' ); ?></button>
    </div>
    <?php wp_nonce_field( 'ps-sidebars-set-location' ); ?>
</form>
