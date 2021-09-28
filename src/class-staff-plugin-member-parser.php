<?php

require 'entity/class-staff-member.php';

class Staff_Plugin_Member_Parser {
	public static function parse_member_from_request_input( $input ) {
		$staff_member = new Staff_Member(
			1,
			$input['first_name'],
			$input['last_name'],
			$input['position'],
			$input['hire_date'],
			$input['birth_date']
		);

		return $staff_member;
	}
}
