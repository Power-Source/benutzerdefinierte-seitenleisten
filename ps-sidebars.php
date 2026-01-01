<?php
/**
 * Plugin Name: PS Power-Seitenleisten
 * Plugin URI:  https://github.com/Power-Source/piestingtal-source-project/ps-seitenleisten/
 * Description: Ermöglicht das Erstellen von Widget-Bereichen und benutzerdefinierten Seitenleisten. Ersetze ganze Seitenleisten oder einzelne Widgets für bestimmte Beiträge und Seiten.
 * Version:     1.0.0
 * Author:      PSOURCE
 * Author URI:  https://github.com/Power-Source
 * Textdomain:  ps-sidebars
 * 
 */

/*
Copyright DerN3rd (https://github.com/Power-Source)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// PS Update Manager - Hinweis wenn nicht installiert
add_action( 'admin_notices', function() {
    // Prüfe ob Update Manager aktiv ist
    if ( ! function_exists( 'ps_register_product' ) && current_user_can( 'install_plugins' ) ) {
        $screen = get_current_screen();
        if ( $screen && in_array( $screen->id, array( 'plugins', 'plugins-network' ) ) ) {
            // Prüfe ob bereits installiert aber inaktiv
            $plugin_file = 'ps-update-manager/ps-update-manager.php';
            $all_plugins = get_plugins();
            $is_installed = isset( $all_plugins[ $plugin_file ] );
            
            echo '<div class="notice notice-warning is-dismissible"><p>';
            echo '<strong>PSOURCE MANAGER:</strong> ';
            
            if ( $is_installed ) {
                // Installiert aber inaktiv - Aktivierungs-Link
                $activate_url = wp_nonce_url(
                    admin_url( 'plugins.php?action=activate&plugin=' . urlencode( $plugin_file ) ),
                    'activate-plugin_' . $plugin_file
                );
                echo sprintf(
                    __( 'Aktiviere den <a href="%s">PS Update Manager</a> für automatische Updates von GitHub.', 'psource-chat' ),
                    esc_url( $activate_url )
                );
            } else {
                // Nicht installiert - Download-Link
                echo sprintf(
                    __( 'Installiere den <a href="%s" target="_blank">PS Update Manager</a> für automatische Updates aller PSource Plugins & Themes.', 'psource-chat' ),
                    'https://github.com/Power-Source/ps-update-manager/releases/latest'
                );
            }
            
            echo '</p></div>';
        }
    }
});

function inc_sidebars_init() {
	if ( class_exists( 'BenutzerdefinierteSeitenleisten' ) ) {
		return;
	}

	/**
	 * Do not load plugin when saving file in WP Editor
	 */
	if ( isset( $_REQUEST['action'] ) && 'edit-theme-plugin-file' == $_REQUEST['action'] ) {
		return;
	}

	/**
	 * if admin, load only on proper pages
	 */
	if ( is_admin() && isset( $_SERVER['SCRIPT_FILENAME'] ) ) {
		$file = basename( $_SERVER['SCRIPT_FILENAME'] );
		$allowed = array(
			'edit.php',
			'admin-ajax.php',
			'post.php',
			'post-new.php',
			'widgets.php',
		);
		/**
		 * Allowed pages array.
		 *
		 * To change where Custom Sidebars is loaded, use this filter.
		 *
		 * @since 3.2.3
		 *
		 * @param array $allowed Allowed pages list.
		 */
		$allowed = apply_filters( 'benutzerdefinierte_seitenleisten_allowed_pages_array', $allowed );
		if ( ! in_array( $file, $allowed ) ) {
			return;
		}
	}

	$plugin_dir = dirname( __FILE__ );
	$plugin_dir_rel = dirname( plugin_basename( __FILE__ ) );
	$plugin_url = plugin_dir_url( __FILE__ );

	define( 'CSB_PLUGIN', __FILE__ );
	define( 'CSB_IS_PRO', false );
	define( 'CSB_VIEWS_DIR', $plugin_dir . '/views/' );
	define( 'CSB_INC_DIR', $plugin_dir . '/inc/' );
	define( 'CSB_JS_URL', $plugin_url . 'assets/js/' );
	define( 'CSB_CSS_URL', $plugin_url . 'assets/css/' );
	define( 'CSB_IMG_URL', $plugin_url . 'assets/img/' );

	// Include function library.
	$modules[] = CSB_INC_DIR . 'external/wpmu-lib/core.php';
	$modules[] = CSB_INC_DIR . 'class-ps-sidebars.php';
	
	// Free-version configuration - no drip campaign yet...
	$cta_label = false;
	$drip_param = false;
	

	

	foreach ( $modules as $path ) {
		if ( file_exists( $path ) ) { require_once $path; }
	}


	// Initialize the plugin
	BenutzerdefinierteSeitenleisten::instance();
}

inc_sidebars_init();

if ( ! class_exists( 'BenutzerdefinierteSeitenleistenEmptyPlugin' ) ) {
	class BenutzerdefinierteSeitenleistenEmptyPlugin extends WP_Widget {
		public function __construct() {
			parent::__construct( false, $name = 'BenutzerdefinierteSeitenleistenEmptyPlugin' );
		}
		public function form( $instance ) {
			//Nothing, just a dummy plugin to display nothing
		}
		public function update( $new_instance, $old_instance ) {
			//Nothing, just a dummy plugin to display nothing
		}
		public function widget( $args, $instance ) {
			echo '';
		}
	} //end class
} //end if class exists


// Translation.
function inc_sidebars_init_translation() {
	load_plugin_textdomain( 'ps-sidebars', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'inc_sidebars_init_translation' );
