<?php

class BasicARTest extends CDbTestCase {
	public $fixtures=array (
		'basicARs' => 'BasicAR',
	);

	/**
	 * Because this model is simple, were primarily testing the validation
	 * rules here.
	 * @dataProvider createData
	 */
	public function testCreate ($argument_attributes, $argument_expects) {
		$basic_ar=new BasicAR;
		$basic_ar->attributes=$argument_attributes;
		$validation_results=$basic_ar->validate ();
		$this->assertThat ($validation_results, $this->equalTo($argument_expects['validation_results']));
		if (!$validation_results)
			$this->assertThat ($basic_ar->errors, $this->equalTo($argument_expects['errors']));
		// a save could be performed here but its not necessary for this model
		// since it has no beforeSave or afterSave behaviors.
	}

	public function createData() {
		return array (
			// Test 0 - 
			array (
				'argument_attributes' => array (
					// Empty attributes
				),
				'argument_expects' => array (
					'validation_results' => false,
					'errors' => array (
						'column_number' => array ('Number cannot be blank.'),
						'column_range' => array ('Range cannot be blank.'),
						'column_regex' => array ('Regexp cannot be blank.'),
						'column_string' => array ('String cannot be blank.'),
					),
				),
			),
			// Test 1 - scenario_default, Test attribute specific validators
			array (
				'argument_attributes' => array (
					'column_boolean' => 'abc',
					'column_number' => 'xyz',
					'column_range' => 'bob',
					'column_regex' => '!@#',
					'column_string' => 'abcdefghijklmnop',
					'column_safe' => 'Anything can go here',
				),
				'argument_expects' => array (
					'validation_results' => false,
					'errors' => array (
						'column_boolean' => array (
							'Boolean must be an integer.',
							'Boolean must be either 1 or 0.',
						),
						'column_number' => array (
							'Number must be an integer.',
							'Number must be a number.',
							'Number is too small (minimum is 1).',
						),
						'column_range' => array (
							'Range must be an integer.',
							'Range is not in the list.',
						),
						'column_regex' => array ('Regexp must contain a word, a space then a number.'),
						'column_string' => array ('String is too long (maximum is 15 characters).'),
					),
				),
			),
			// Test 2 - Success
			array (
				'argument_attributes' => array (
					'column_boolean' => '1',
					'column_number' => '6',
					'column_range' => '7',
					'column_regex' => 'neat 1',
					'column_string' => 'short string',
					'column_safe' => '',
				),
				'argument_expects' => array (
					'validation_results' => true,
				),
			),
		);
	}

	/**
	 * @dataProvider searchData
	 */
	public function testSearch ($argument_attributes, $argument_expects) {
		$model=new BasicAR ('search');
		$model->attributes=$argument_attributes;
		$search_results=$model->search()->getData();
		$this->assertThat ($search_results, $argument_expects['search_results']);
		if (!empty ($search_results)) {
			$this->assertContainsOnly ('BasicAR', $search_results, false);
			$this->assertThat (count ($search_results), $this->equalTo ($argument_expects['search_results_count']));
		}
	}

	/**
	 * Please refer to the fixtures file:
	 * 'example/protected/tests/fixtures/tbl_basic_ar.php' to see what data is
	 * matched.
	 */
	public function searchData () {
		return array (
			// Test 0 - Find column_string that contains 'Nothing'
			array (
				'argument_attributes' => array (
					'column_string' => 'Nothing',
				),
				'argument_expects' => array (
					'search_results' => $this->isEmpty (),
				),
			),
			// Test 1 - Find column_boolean that quals 1 and column_string contains 'Le'
			array (
				'argument_attributes' => array (
					'column_boolean' => '1',
					'column_string' => 'Le',
				),
				'argument_expects' => array (
					'search_results' => $this->isType ('array'),
					'search_results_count' => 1,
				),
			),
			// Test 2 - Find column_regex that contains '2'
			array (
				'argument_attributes' => array (
					'column_regex' => '2',
				),
				'argument_expects' => array (
					'search_results' => $this->isType ('array'),
					'search_results_count' => 2,
				),
			),
		);
	}

}
