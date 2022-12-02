<?php
/*
Plugin Name: Custom Add Page Form
Description: Enables [AddPageForm] shortcode which outputs a custom form to add new pages and list them as well.
Version:     1.0.0
Author:      Grecu Victor
*/

defined( 'ABSPATH' ) or die;

define( 'CUSTOM_ADD_PAGE_FORM_FILE', __FILE__ );
define( 'CUSTOM_ADD_PAGE_FORM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CUSTOM_ADD_PAGE_FORM_NONCE_BN', basename( __FILE__ ) );
define( 'CUSTOM_ADD_PAGE_FORM_NONCE_KEY', 'capf_nonce' );
define( 'CUSTOM_ADD_PAGE_FORM_NOTIFICATION_ON', 'capf_notification' );
define( 'CUSTOM_ADD_PAGE_FORM_LIST_SIZE', 20 );
define( 'CUSTOM_ADD_PAGE_FORM_VER', '1.0.0' );

require_once( CUSTOM_ADD_PAGE_FORM_PLUGIN_PATH . 'models/add-page-form.php' );
require_once( CUSTOM_ADD_PAGE_FORM_PLUGIN_PATH . 'controllers/add-page-form.php' );

Add_Page_Form_Controller::get_instance();