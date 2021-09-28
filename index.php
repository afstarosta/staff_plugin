<?php

/**
 * Plugin Name: Staff Plugin
 * Version: 1.0.0
 * Description: Plugin for registering your WordPress Staff
 * Author: Andre Starosta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'src/class-staff-plugin-api-router.php';
require_once 'migrations/class-staff-plugin-db-setup.php';
require_once 'staff-plugin-admin-page.php';

add_action( 'admin_menu', 'add_admin_page' );
function add_admin_page() {
	add_menu_page(
		'Staff Plugin Settings',
		'Staff Plugin',
		'manage_options',
		'staff-plugins',
		'staff_plugin_admin_page_html'
	);
}

add_action(
	'rest_api_init',
	function() {
		$api_router = new Staff_Plugin_Api_Router();
		$api_router->register_routes();
	}
);

register_activation_hook(
	__FILE__,
	function() {
		Staff_Plugin_Db_Setup::init_database();
	}
);
