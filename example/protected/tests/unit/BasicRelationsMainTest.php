<?php
/**
 * BasicRelationsMainTest class file.
 *
 * @author Alexander Scott <magister@kfa.cx>
 * @link https://github.com/kfacx/yii-example
 * @copyright Copyright &copy; 2013 Alexander Scott
 * @license https://github.com/kfacx/yii-example/blob/master/LICENSE
 */

class BasicRelationsMainTest extends CDbTestCase {
	// Because the BasicRelationsMain class involves 
	public $fixtures=array (
		'basicRelationsMains' => 'BasicRelationsMain',
		'basicRelationsBelongsTos' => 'BasicRelationsBelongsTo',
		'basicRelationsHasOnes' => 'BasicRelationsHasOne',
		'basicRelationsHasManies' => 'BasicRelationsHasMany',
		'basicRelationsManyManies' => 'BasicRelationsManyMany',
		'basicRelationsPivots' => 'BasicRelationsPivot',
	);

	public static function tearDownAfterClass()	{
		Yii::app()->onEndRequest(new CEvent(null));
	}

	/**
	 * @dataProvider createData
	 */
	public function testCreate($argument_attributes, $argument_expects) {
		$basic_relations_main=new BasicRelationsMain;
		$basic_relations_main->attributes=$argument_attributes;
		$validation_results=$basic_relations_main->validate ();
		$this->assertThat ($validation_results, $this->equalTo($argument_expects['validation_results']));
		if (!$validation_results) {
			$this->assertThat ($basic_relations_main->errors, $this->equalTo($argument_expects['errors']));
			return;
		}
		// test beforeSave behaviour
		$this->assertThat ($basic_relations_main->save(), $this->equalTo($argument_expects['save_results']));
		$retrieved=BasicRelationsMain::model()->findByPk ($basic_relations_main->id);
		$this->assertInstanceOf ('BasicRelationsMain', $retrieved);
	}

	public function createData () {
		return array (
			array ( // Test 0 - Check that the required validator is applied correctly.
				'argument_attributes' => array (
					// Empty attributes
				),
				'argument_expects' => array (
					'validation_results' => false,
					'errors' => array (
						'column_belongs_to_id' => array (
							'Column Belongs To ID cannot be blank.',
						),
						'column_main_content' => array (
							'Column Main Content cannot be blank.'
						),
					),
				),
			),
			array ( // Test 1 - Check that built-in validators are applied correctly.
				'argument_attributes' => array (
					'column_belongs_to_id' => 'a',
					'column_main_content' => call_user_func (function(){$s='';for($i=0;$i<256;$i++)$s.='a';return $s;}), // Create a string thats too long.
				),
				'argument_expects' => array (
					'validation_results' => false,
					'errors' => array (
						'column_belongs_to_id' => array (
							'Column Belongs To ID must be an integer.',
						),
						'column_main_content' => array (
							'Column Main Content is too long (maximum is 255 characters).',
						),
					),
				),
			),
			array ( // Test 2 - Check that the remaining built-in validators are applied correctly.
				'argument_attributes' => array (
					'column_belongs_to_id' => '10',
					'column_main_content' => 'abc',
				),
				'argument_expects' => array (
					'validation_results' => false,
					'errors' => array (
						'column_belongs_to_id' => array (
							'The Column Belongs To ID of \'10\' does not exist in the tbl_basic_relations_belongs_to table.',
						),
					),
				),
			),
			array ( // Test 3 - Validation passes, save and check the related attributes.
				'argument_attributes' => array (
					'column_belongs_to_id' => '1',
					'column_main_content' => 'abc',
				),
				'argument_expects' => array (
					'validation_results' => true,
					'save_results' => true,
				),
			),
		);
	}

	/**
	 * Test the delete cascading.
	 */
	public function testDelete () {
		$basic_relations_main_model=BasicRelationsMain::model()->findByPk (1);
		$basic_relations_main_model->cascade(true);
		$basic_relations_main_model->delete();
		$this->assertNull (BasicRelationsMain::model()->findByPk (1));
		$this->assertNull (BasicRelationsHasOne::model()->findByPk (1));
		$this->assertNull (BasicRelationsHasMany::model()->findByPk (1));
		$this->assertNull (BasicRelationsHasMany::model()->findByPk (2));
		$this->assertNull (BasicRelationsHasMany::model()->findByPk (3));
		$this->assertNull (BasicRelationsPivot::model()->findByPk (1));
		$this->assertNull (BasicRelationsPivot::model()->findByPk (2));
	}

	/**
	 * Test the results of the search() method.
	 */
	public function testSearch () {
		$basic_relations_main_model=new BasicRelationsMain ('search');
		$basic_relations_main_model->attributes=array (
			'column_main_content' => 'Second',
		);
		$results=$basic_relations_main_model->search()->getData();
		$this->assertContainsOnly ('BasicRelationsMain', $results, false);
		$this->assertThat (count($results), $this->equalTo (1));
	}

	/**
	 * @dataProvider post_AttributesData
	 */
	public function testPost_Attributes ($pk, $post, $expects) {
		if (!empty ($pk))
			$basic_relations_main_model=BasicRelationsMain::model()->findByPk ($pk);
		else
			$basic_relations_main_model=new BasicRelationsMain;
		$basic_relations_main_model->post_attributes=$post;
		$validation_results=$basic_relations_main_model->validate ();
		if (!$validation_results) {
			//var_export ($basic_relations_main_model->allerrors);
			$this->assertThat ($basic_relations_main_model->errors, $this->equalTo ($expects['errors']), 'Expected Errors');
			return;
		}
		$basic_relations_main_model->save ();
		$basic_relations_main_model->refresh ();
		$this->assertInstanceOf ('BasicRelationsHasOne', $basic_relations_main_model->relation_has_one, 'Instance Of Has One');
		$this->assertContainsOnly ('BasicRelationsHasMany', $basic_relations_main_model->relation_has_many, false, 'Contains Only Has Many');
		$this->assertThat (count ($basic_relations_main_model->relation_has_many), $this->equalTo ($expects['has_many_count']), 'Has Many Count');
		$this->assertContainsOnly ('BasicRelationsManyMany', $basic_relations_main_model->relation_many_many, false, 'Contains Only Many Many');
		$this->assertThat (count ($basic_relations_main_model->relation_many_many), $this->equalTo ($expects['many_many_count']), 'Many Many Count');
	}

	public function post_AttributesData () {
		return array (
			array ( // Test 0 - New model
				'pk' => null,
				'post' => array (
					'BasicRelationsMain' => array (
						'column_belongs_to_id' => '1',
						'column_main_content' => 'Blah!',
						'magic_attribute_many_many_selected' => array (
							'2',
							'3',
						),
					),
					'BasicRelationsHasOne' => array (
						'column_has_one_content' => 'Has One Foo!',
					),
					'BasicRelationsHasMany' => array (
						array (
							'column_has_many_content' => 'Booyah, First Has Many!',
						),
						array (
							'column_has_many_content' => 'Wah, Wah, Waaah, Another Has Many!',
						),
					),
				),
				'expects' => array (
					'validation_results' => true,
					'has_many_count' => 2,
					'many_many_count' => 2,
					'errors' => array (
						'relation_has_one' => array (),
					),
				),
			),
			array ( // Test 1 - Existing model
				'pk' => '1',
				'post' => array (
					'BasicRelationsMain' => array (
						'column_belongs_to_id' => '1',
						'column_main_content' => 'Blah!',
						'magic_attribute_many_many_selected' => array (
							'2',
							'3',
						),
					),
					'BasicRelationsHasOne' => array (
						'column_has_one_content' => 'Has One Foo!',
					),
					'BasicRelationsHasMany' => array (
						array (
							'id' => '1',
							'column_has_many_content' => 'Updated Has Many!',
						),
						array (
							'column_has_many_content' => 'This is a new Has Many!',
						),
					),
				),
				'expects' => array (
					'validation_results' => true,
					'has_many_count' => 2,
					'many_many_count' => 2,
				),
			),
		);
	}

}
