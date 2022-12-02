<?php
defined( 'ABSPATH' ) or die;

if ( ! class_exists( 'Add_Page_Form_Controller' ) ) {
	class Add_Page_Form_Controller {
		public static function get_instance() {
			if ( self::$instance == null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		private static $instance = null;

		private function __clone() { }

		private function __wakeup() { }

		private function __construct() {
			// Set model
			$this->model = new Add_Page_Form_Model;

			// WP Actions
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
			add_action( 'wp_ajax_oairg_generate', array( $this, 'ajax_generate' ) );

			// Shortcode
			add_shortcode( 'AddPageForm', array( $this, 'output_shortcode' ) );
		}

		public function init() {
			load_plugin_textdomain( 'custom-add-page-form', false, dirname( plugin_basename( CUSTOM_ADD_PAGE_FORM_FILE ) ) . '/languages' );
		}

		public function register_assets() {
			wp_register_style( 'custom-add-page-form', plugins_url( 'css/style.css', CUSTOM_ADD_PAGE_FORM_FILE ), array(), CUSTOM_ADD_PAGE_FORM_VER, 'all' );
			wp_register_script( 'custom-add-page-form', plugins_url( 'js/script.js', CUSTOM_ADD_PAGE_FORM_FILE ), array( 'jquery' ), CUSTOM_ADD_PAGE_FORM_VER, true );
		}

		public function output_shortcode( $atts, $content, $tag ) {
			if ( ! is_user_logged_in() ) {
				global $wp;
				return sprintf( __( 'You must be logged in to access this resource. %sLog in%s', 'custom-add-page-form' ), '<a href="' . esc_attr( wp_login_url( home_url( $wp->request ) ) ) . '">', '</a>' );
			}

			if ( ! current_user_can( 'administrator' ) ) return __( 'Unauthorized', 'custom-add-page-form' );

			$this->maybe_add_page();

			wp_enqueue_style( 'custom-add-page-form' );
			wp_enqueue_script( 'custom-add-page-form' );

			$page_ids = $this->model->get_page_ids();
			$notification = $this->model->get_notification();

			ob_start();
			require CUSTOM_ADD_PAGE_FORM_PLUGIN_PATH . '/views/form.php';
			require CUSTOM_ADD_PAGE_FORM_PLUGIN_PATH . '/views/list.php';
			return ob_get_clean();
		}

		private function maybe_add_page() {
			if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) return;

			if ( empty( $_POST[CUSTOM_ADD_PAGE_FORM_NONCE_KEY] ) || ! wp_verify_nonce( $_POST[CUSTOM_ADD_PAGE_FORM_NONCE_KEY], CUSTOM_ADD_PAGE_FORM_NONCE_BN ) ) {
				$this->model->save_notification( array( 'type' => 'error', 'message' => __( 'Invalid Request', 'custom-add-page-form' ) ) );
				return;
			}

			$errors = array();
			$title = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
			$content = isset( $_POST['content'] ) ? sanitize_text_field( $_POST['content'] ) : '';

			if ( empty( $title ) ) array_push( $errors, __( 'Empty Title', 'custom-add-page-form' ) );	
			if ( empty( $content ) ) array_push( $errors, __( 'Empty Content', 'custom-add-page-form' ) );	

			if ( ! empty( $errors ) ) {
				$this->model->save_notification( array( 'type' => 'error', 'message' => implode( '<br>', $errors ) ) );
				return;
			}

			if ( $this->model->add_page( $title, $content ) ) {
				$this->model->save_notification( array( 'type' => 'success', 'message' => __( 'Page successfully created!', 'custom-add-page-form' ) ) );
			} else {
				$this->model->save_notification( array( 'type' => 'error', 'message' => __( 'Error', 'custom-add-page-form' ) ) );
			}
		}
	}
}