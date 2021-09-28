<?php

class Staff_Plugin_Input_Validator {

	private const REQUIRED_FIELDS_FOR_MEMBER_CREATION = [
		'first_name',
		'last_name',
		'position',
		'hire_date',
		'birth_date',
	];

	public static function validate_input_for_staff_member_creation( $input ) {
		if ( empty( $input ) ) {
			return self::empty_input_error();
		}

		foreach ( self::REQUIRED_FIELDS_FOR_MEMBER_CREATION as $required_field ) {
			if ( ! isset( $input[ $required_field ] ) || empty( $input[ $required_field ] ) ) {
				return self::missing_field_error( $required_field );
			}
		}
	}

	public static function validate_input_for_staff_member_deletion( $input ) {
		if ( empty( $input ) ) {
			return self::empty_input_error();
		}

		if ( ! isset( $input['staff_member_id'] ) || empty( $input['staff_member_id'] ) ) {
			return self::missing_field_error( 'staff_member_id' );
		}
	}

	private static function empty_input_error() {
		return new WP_Error( 'invalid_input', 'Invalid request input: empty request', 400 );
	}

	private static function missing_field_error( $required_field ) {
		return new WP_Error( 'invalid_input', 'Invalid request input: missing parameter ' . $required_field, 400 );
	}
}
