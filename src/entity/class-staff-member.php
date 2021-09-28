<?php

class Staff_Member {
	public $id;
	public $first_name;
	public $last_name;
	public $position;
	public $hire_date;
	public $birth_date;

	public function __construct( $id, $first_name, $last_name, $position, $hire_date, $birth_date ) {
		$this->id         = $id;
		$this->first_name = $first_name;
		$this->last_name  = $last_name;
		$this->position   = $position;
		$this->hire_date  = $hire_date;
		$this->birth_date = $birth_date;
	}
}
