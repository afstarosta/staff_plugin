<?php

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class Staff_Plugin_Db_Setup {
	static function init_database() {
		self::create_staff_table();
	}

	const CREATE_STAFF_TABLE_STATEMENT = <<<SQL
        CREATE TABLE IF NOT EXISTS `staff_member` (
            `id` int NOT NULL AUTO_INCREMENT,
            `first_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
            `last_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
            `position` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
            `hire_date` date NOT NULL,
            `birth_date` date NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    SQL;

	private static function create_staff_table() {
		dbDelta( self::CREATE_STAFF_TABLE_STATEMENT );
	}
}
