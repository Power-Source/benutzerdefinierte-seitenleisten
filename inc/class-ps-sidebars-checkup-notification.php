<?php

add_action( 'cs_init', array( 'BenutzerdefinierteSeitenleistenCheckupNotification', 'instance' ) );

/**
 * Extends the widgets section to add the advertisements.
 *
 * @since 3.0.0
 */
class BenutzerdefinierteSeitenleistenCheckupNotification extends BenutzerdefinierteSeitenleisten {

	private $dismiss_name = 'benutzerdefinierte_seitenleisten_checkup_notification_dismiss';
	private $nonce_name = 'benutzerdefinierte_seitenleisten_checkup_notification_nonce';

	/**
	 * Returns the singleton object.
	 *
	 * @since 3.0.0
	 */
	public static function instance() {
		static $instance = null;

		if ( null === $instance ) {
			$instance = new BenutzerdefinierteSeitenleistenCheckupNotification();
		}

		return $instance;
	}

	/**
	 * Constructor is private -> singleton.
	 *
	 * @since 3.0.0
	 */
	private function __construct() {
		if ( ! is_admin() ) {
			return;
		}
		//add_action( 'admin_head', array( $this, 'init_admin_head' ) );
		add_action( 'admin_head-widgets.php', array( $this, 'init_admin_head_in_widgets' ) );
		add_action( 'wp_ajax_benutzerdefinierte_seitenleisten_checkup_notification_dismiss', array( $this, 'dismiss' ) );
	}

	/**
	 * Save dismiss decision, no more show it.
	 *
	 * @since 3.0.0
	 */
	public function dismiss() {
		/**
		 * Check: is nonce send?
		 */
		if ( ! isset( $_GET['_wpnonce'] ) ) {
			die;
		}
		/**
		 * Check: is user id send?
		 */
		if ( ! isset( $_GET['user_id'] ) ) {
			die;
		}
		/**
		 * Check: nonce
		 */
		$nonce_name = $this->nonce_name . $_GET['user_id'];
		if ( ! wp_verify_nonce( $_GET['_wpnonce'], $nonce_name ) ) {
			die;
		}
		/**
		 * save result
		 */
		$result = add_user_meta( $_GET['user_id'], $this->dismiss_name, true, true );
		if ( false == $result ) {
			update_user_meta( $_GET['user_id'], $this->dismiss_name, true );
		}
		die;
	}

	/**
	 * Admin header
	 *
	 * @since 3.0.0
	 */
	public function init_admin_head() {
		add_action( 'admin_notices', array( $this, 'admin_notice_scan' ) );
	}

	/**
	 * Admin notice scan!
	 *
	 * @since 3.0.1
	 */
	public function admin_notice_scan() {
		$user_id = get_current_user_id();
		$state = get_user_meta( $user_id, $this->dismiss_name, true );
		if ( $state ) {
			return;
		}
		lib3()->ui->add( CSB_CSS_URL . 'cs-scan.css' );
?>
<script type="text/javascript">
    jQuery(document).on( 'click', '.ps-sidebars-wp-checkup .notice-dismiss', function() {
        jQuery.ajax({
            url: ajaxurl,
            data: {
            action: '<?php echo esc_attr( $this->dismiss_name ); ?>',
                _wpnonce: '<?php echo wp_create_nonce( $this->nonce_name . $user_id ) ?>',
                user_id: <?php echo $user_id ?>
            }
        })
    });
</script>
<?php
	}

	/**
	 * Admin header
	 *
	 * @since 3.0.1
	 */
	public function init_admin_head_in_widgets() {
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
	}

	/**
	 * Admin notice!
	 *
	 * @since 3.0.0
	 */
	public function admin_notices() {
		wp_enqueue_script( 'wp-util' );
		$this->show_box( 'checkup' );
	}

	/**
	 * Show box.
	 *
	 * @since 3.0.4
	 *
	 * @param string $template_name Template name.
	 */
	private function show_box( $template_name ) {
		$method = sprintf( 'show_box_%s', $template_name );
		if ( ! method_exists( $this, $method ) ) {
			return;
		}
?>
<script type="text/javascript">
	jQuery(document).ready( function() {
		setTimeout( function() {
			var template = wp.template('ps-sidebars-<?php echo $template_name; ?>');
			jQuery(".sidebars-column-1 .inner").append( template() );
		}, 1000);
	});
</script>
<script type="text/html" id="tmpl-ps-sidebars-<?php echo $template_name; ?>">
<?php
		$this->$method();
?>
</script>
<?php
	}


};
