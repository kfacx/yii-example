<?php

class m130723_035921_basic_ar extends CDbMigration {
	public function up() {
		$this->createTable('tbl_basic_ar', array(
			'id' => 'pk',
			'column_boolean' => 'boolean',
			'column_number' => 'integer',
			'column_range' => 'integer',
			'column_regex' => 'string',
			'column_string' => 'string',
			'column_safe' => 'string',
		));
	}

	public function down() {
		$this->dropTable('tbl_basic_ar');
	}
}
