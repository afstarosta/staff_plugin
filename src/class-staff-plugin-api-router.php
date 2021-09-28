<?php

require 'class-staff-plugin-input-validator.php';
require 'class-staff-plugin-member-parser.php';
require 'class-staff-plugin-persistence-handler.php';

class Staff_Plugin_Api_Router extends WP_REST_Controller {
	private $persistence_handler;

	const API_NAMESPACE    = 'staff_plugin';
	const API_STAFF_MEMBER = 'staff_member';

	public function __construct() {
		$this->persistence_handler = new Staff_Plugin_Persistence_Handler();
	}

	public function register_routes() {
		register_rest_route(
			self::API_NAMESPACE,
			'/' . self::API_STAFF_MEMBER,
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_staff_members' ],
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				],
			]
		);

		register_rest_route(
			self::API_NAMESPACE,
			'/' . self::API_STAFF_MEMBER,
			[
				[
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => [ $this, 'create_staff_member' ],
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				],
			]
		);

		register_rest_route(
			self::API_NAMESPACE,
			'/' . self::API_STAFF_MEMBER,
			[
				[
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => [ $this, 'delete_staff_member' ],
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				],
			]
		);
	}


	public function get_staff_members( WP_REST_Request $request ) {
		$staff_members = $this->persistence_handler->get_all_staff_members();
		return [ 'result' => $staff_members ];
		return $staff_members;
	}

	public function create_staff_member( WP_REST_Request $request ) {
		$input = $request->get_json_params();

		$validation_result = Staff_Plugin_Input_Validator::validate_input_for_staff_member_creation( $input );
		if ( is_wp_error( $validation_result ) ) {
			return $validation_result;
		}

		$staff_member    = Staff_Plugin_Member_Parser::parse_member_from_request_input( $input );
		$creation_result = $this->persistence_handler->create_staff_member( $staff_member );

		if ( is_wp_error( $creation_result ) ) {
			return $creation_result;
		}

		return [ 'staff_member_id' => $creation_result ];

	}

	public function delete_staff_member( WP_REST_Request $request ) {
		$input = $request->get_json_params();

		$validation_result = Staff_Plugin_Input_Validator::validate_input_for_staff_member_deletion( $input );
		if ( is_wp_error( $validation_result ) ) {
			return $validation_result;
		}

		$deletion_result = $this->persistence_handler->delete_staff_member( $input['staff_member_id'] );
		if ( is_wp_error( $deletion_result ) ) {
			return $deletion_result;
		}

		return [ 'success' => boolval( $deletion_result ) ];
	}
}
