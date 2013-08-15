<?php

class BasicRelationsManyManyTest extends CDbTestCase {
	public $fixtures=array (
		'basicRelationsManyManies' => 'BasicRelationsManyMany',
		'basicRelationsPivots' => 'BasicRelationsPivot',
		'basicRelationsMains' => 'BasicRelationsMain',
	);

	public function testRelationManyMains () {
		$basic_relations_many_many=BasicRelationsManyMany::model()->findByPk ('1');
		$this->assertThat (
			$basic_relations_many_many->relation_many_mains,
			$this->isType('array'),
			'Relation Many Mains is an array'
		);
		$this->assertThat (
			count ($basic_relations_many_many->relation_many_mains),
			$this->equalTo ('2'),
			'Relation Many Mains array count of 2'
		);
		$this->assertContainsOnly (
			'BasicRelationsMain',
			$basic_relations_many_many->relation_many_mains,
			false, // Set to false if not a php native type
			'Relation Many Mains array contains only BasicRelationsMain objects'
		);
	}
}
