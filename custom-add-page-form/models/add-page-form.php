<?php
defined( 'ABSPATH' ) or die;

if ( ! class_exists( 'Add_Page_Form_Model' ) ) {
	class Add_Page_Form_Model {
		public function get_page_ids() {
			global $wpdb;
			return $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'publish' ORDER BY ID DESC LIMIT %d", CUSTOM_ADD_PAGE_FORM_LIST_SIZE ) );
		}

		public function save_notification( $notification ) {
			update_option( CUSTOM_ADD_PAGE_FORM_NOTIFICATION_ON . '_' . get_current_user_id(), $notification );
		}

		public function get_notification() {
			$notification = get_option( CUSTOM_ADD_PAGE_FORM_NOTIFICATION_ON . '_' . get_current_user_id() );
			if ( $notification != '' ) update_option( CUSTOM_ADD_PAGE_FORM_NOTIFICATION_ON . '_' . get_current_user_id(), '' );
			return $notification;
		}

		public function add_page( $title, $content ) {
			return wp_insert_post( array(
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_type' => 'page'
			) );
		}
	}
}