<?php

class m130725_214722_basic_relations extends CDbMigration {
	public function up() {
		// Create the tables.
		$this->createTable('tbl_basic_relations_main', array(
			'id' => 'pk',
			'column_belongs_to_id' => 'integer',
			'column_main_content' => 'string',
		));
		$this->createTable('tbl_basic_relations_belongs_to', array(
			'id' => 'pk',
			'column_belongs_to_content' => 'string',
		));
		$this->createTable('tbl_basic_relations_has_one', array(
			'id' => 'pk',
			'column_main_id' => 'integer',
			'column_has_one_content' => 'string',
		));
		$this->createTable('tbl_basic_relations_has_many', array(
			'id' => 'pk',
			'column_main_id' => 'integer',
			'column_has_many_content' => 'string',
		));
		$this->createTable('tbl_basic_relations_pivot', array(
			'id' => 'pk',
			'column_main_id' => 'integer',
			'column_many_many_id' => 'string',
		));
		$this->createTable('tbl_basic_relations_many_many', array(
			'id' => 'pk',
			'column_many_many_content' => 'string',
		));

		// Populate some example data.
		$this->insert('tbl_basic_relations_main', array (
			'column_belongs_to_id' => '2',
			'column_main_content' => 'Main contents',
		));
		$this->insert('tbl_basic_relations_main', array (
			'column_belongs_to_id' => '1',
			'column_main_content' => 'Second main contents',
		));

		$this->insert('tbl_basic_relations_belongs_to', array (
			'column_belongs_to_content' => 'Main 2 belongs to this record',
		));
		$this->insert('tbl_basic_relations_belongs_to', array (
			'column_belongs_to_content' => 'Main 1 belongs to this record',
		));

		$this->insert('tbl_basic_relations_has_one', array (
			'column_main_id' => '1',
			'column_has_one_content' => 'Main 1 has one with this record',
		));
		$this->insert('tbl_basic_relations_has_one', array (
			'column_main_id' => '2',
			'column_has_one_content' => 'Main 2 has one with this record',
		));

		$this->insert('tbl_basic_relations_has_many', array (
			'column_main_id' => '1',
			'column_has_many_content' => 'Main 1 has many, this is the first',
		));
		$this->insert('tbl_basic_relations_has_many', array (
			'column_main_id' => '1',
			'column_has_many_content' => 'Main 1 has many, this is the second',
		));
		$this->insert('tbl_basic_relations_has_many', array (
			'column_main_id' => '1',
			'column_has_many_content' => 'Main 1 has many, this is the third',
		));

		$this->insert('tbl_basic_relations_pivot', array (
			'column_main_id' => '1',
			'column_many_many_id' => '1',
		));
		$this->insert('tbl_basic_relations_pivot', array (
			'column_main_id' => '1',
			'column_many_many_id' => '2',
		));
		$this->insert('tbl_basic_relations_pivot', array (
			'column_main_id' => '2',
			'column_many_many_id' => '1',
		));
		$this->insert('tbl_basic_relations_pivot', array (
			'column_main_id' => '2',
			'column_many_many_id' => '2',
		));

		$this->insert('tbl_basic_relations_many_many', array (
			'column_many_many_content' => 'First Many Many',
		));
		$this->insert('tbl_basic_relations_many_many', array (
			'column_many_many_content' => 'Second Many Many',
		));
	}

	public function down() {
		$this->dropTable('tbl_basic_relations_main');
		$this->dropTable('tbl_basic_relations_belongs_to');
		$this->dropTable('tbl_basic_relations_has_one');
		$this->dropTable('tbl_basic_relations_has_many');
		$this->dropTable('tbl_basic_relations_pivot');
		$this->dropTable('tbl_basic_relations_many_many');
	}
}
