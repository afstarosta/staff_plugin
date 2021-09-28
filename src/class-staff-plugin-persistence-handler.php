<?php

class Staff_Plugin_Persistence_Handler {
	private $database_interface;

	public function __construct() {
		global $wpdb;
		$this->database_interface = $wpdb;
	}

	const GET_ALL_STAFF_MEMBERS_QUERY = 'SELECT * FROM `staff_member`';

	public function get_all_staff_members() {
		$statement = $this->database_interface->prepare(
			self::GET_ALL_STAFF_MEMBERS_QUERY
		);

		return $this->database_interface->get_results( $statement );
	}

	public function create_staff_member( $staff_member ) {
		$insertion_result = $this->database_interface->insert(
			'staff_member',
			array(
				'first_name' => $staff_member->first_name,
				'last_name'  => $staff_member->last_name,
				'position'   => $staff_member->position,
				'hire_date'  => $staff_member->hire_date,
				'birth_date' => $staff_member->birth_date,
			),
			array( '%s', '%s', '%s', '%s', '%s' )
		);

		if ( false === $insertion_result ) {
			return self::staff_member_creation_error( $this->database_interface->last_error );
		}

		return $this->database_interface->insert_id;
	}

	const DELETE_STAFF_MEMBER_STATEMENT = 'DELETE FROM `staff_member` WHERE `id` = %d';

	public function delete_staff_member( $staff_member_id ) {
		$statement = $this->database_interface->prepare(
			self::DELETE_STAFF_MEMBER_STATEMENT,
			$staff_member_id
		);

		return $this->database_interface->query( $statement );
	}


	private static function staff_member_creation_error( $error_message ) {
		return new WP_Error( 'database_error', 'Error creating Staff Member.' . $error_message, 500 );
	}
}
