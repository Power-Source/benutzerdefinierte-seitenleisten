<?php
/**
 * Metabox inside posts/pages where user can define custom sidebars for an
 * individual post.
 *
 * Uses:
 *   $selected
 *   $wp_registered_sidebars
 *   $post_id
 */

$sidebars = BenutzerdefinierteSeitenleisten::get_options( 'modifiable' );

$is_front = get_option( 'page_on_front' ) == $post_id;
$is_blog = get_option( 'page_for_posts' ) == $post_id;
/**
 * check is WooCommerce shop
 */
$is_woo_shop = intval( $post_id ) === ( function_exists( 'wc_get_page_id' )? intval( wc_get_page_id( 'shop' ) ) : 0 );
/**
 * local display helper
 *
 * @since 3.2.0
 *
 * @param string $page_name Page Name to display.
 * @param string $img Image to display.
 * @param string $archive Archive name to display.
 */
if ( ! function_exists( 'benutzerdefinierte_seitenleisten_replace_not_allowed' ) ) {
	function benutzerdefinierte_seitenleisten_replace_not_allowed( $page_name, $img, $archive = null ) {
		echo '<p>';
		printf(
			'<strong>%s</strong>',
			sprintf(
				esc_html__( 'So änderst Du die Seitenleiste für %s', 'ps-sidebars' ),
				$page_name
			)
		);
		echo '<ul>';
		printf(
			'<li>%s</li>',
			sprintf(
				__( 'Gehe zur <a href="%1$s">Widgets Seite</a>', 'ps-sidebars' ),
				admin_url( 'widgets.php' )
			)
		);
		printf(
			'<li>%s</li>',
			esc_html__( 'Klicke auf "Sidebar Position"', 'ps-sidebars' )
		);
		printf(
			'<li>%s</li>',
			esc_html__( 'Öffne die Registerkarte "Archivtypen"', 'ps-sidebars' )
		);
		printf(
			'<li>%s</li>',
			sprintf(
				esc_html__( 'Wähle "%s"', 'ps-sidebars' ),
				esc_html( empty( $archive )? $page_name : $archive )
			)
		);
		echo '</ul>';
		echo '</p>';
		$url = esc_url( CSB_IMG_URL . 'metabox/' . $img . '?version=3.2.3' );
		printf(
			'<a href="%s" target="_blank"><img src="%s" style="width:100%%" /></a>',
			esc_url( $url ),
			esc_url( $url )
		);
	}
}
/**
 * show
 */
if ( $is_front  ) {
	$page_name = esc_html__( 'Startseite', 'ps-sidebars' );
	benutzerdefinierte_seitenleisten_replace_not_allowed( $page_name, 'frontpage-info.png' );
} elseif ( $is_blog ) {
	$page_name = esc_html__( 'Blog-Seite', 'ps-sidebars' );
	$archive = esc_html__( 'Beitragsindex', 'ps-sidebars' );
	benutzerdefinierte_seitenleisten_replace_not_allowed( $page_name, 'blogpage-info.png', $archive );
} elseif ( $is_woo_shop ) {
	$page_name = esc_html__( 'WooCommerce Shop', 'ps-sidebars' );
	$post_type_object = get_post_type_object( 'product' );
	$archive = sprintf( esc_html__( '%s Archive
	', 'ps-sidebars' ), $post_type_object->label );
	benutzerdefinierte_seitenleisten_replace_not_allowed( $page_name, 'wooshop-info.png', $archive );
} else {
	echo '<p>';
	_e( 'Hier kannst Du die Standard-Seitenleisten ersetzen. Wähle einfach die Seitenleiste aus, die Du für diesen Beitrag anzeigen möchtest!', 'ps-sidebars' );
	echo '</p>';
	if ( ! empty( $sidebars ) ) {
		global $wp_registered_sidebars;
		$available = BenutzerdefinierteSeitenleisten::sort_sidebars_by_name( $wp_registered_sidebars );
		foreach ( $sidebars as $s ) { ?>
            <?php $sb_name = $available[ $s ]['name']; ?>
            <p>
                <label for="cs_replacement_<?php echo esc_attr( $s ); ?>">
                    <b><?php echo esc_html( $sb_name ); ?></b>:
                </label>
                <select name="cs_replacement_<?php echo esc_attr( $s ); ?>"
                    id="cs_replacement_<?php echo esc_attr( $s ); ?>"
                    class="cs-replacement-field <?php echo esc_attr( $s ); ?>">
                    <option value=""></option>
                    <?php foreach ( $available as $a ) { ?>
                    <option value="<?php echo esc_attr( $a['id'] ); ?>" <?php selected( $selected[ $s ], $a['id'] ); ?>>
                        <?php echo esc_html( $a['name'] ); ?>
                    </option>
                    <?php } ?>
                </select>
            </p>
<?php
		}
	} else {
		echo '<p id="message" class="updated">';
		printf(
			__( 'Alle Seitenleisten wurden gesperrt, Du kannst sie nicht ersetzen. Gehe zur <a href="%s">Widget Seite</a> um eine Seitenleiste zu entsperren.', 'ps-sidebars' ),
			admin_url( 'widgets.php' )
		);
		echo '</p>';
	}
}
