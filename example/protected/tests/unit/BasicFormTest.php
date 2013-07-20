<?php

class BasicFormTest extends CTestCase {

	/**
	 * @dataProvider rulesData
	 */
	public function testRules($argument_scenario, $argument_attributes, $argument_expects) {
		$basic_form=new BasicForm ($argument_scenario);
		$basic_form->attributes=$argument_attributes;
		$validation_results=$basic_form->validate ();
		$this->assertThat ($validation_results, $this->equalTo($argument_expects['validation_results']));
		if (!$validation_results)
			$this->assertThat ($basic_form->errors, $this->equalTo($argument_expects['errors']));
	}

	public function rulesData() {
		return array (
			// Test 0 - scenario_default, Test Required validator
			array (
				'scenario' => 'scenario_default',
				'attributes' => array (
					// Empty attributes
				),
				'expects' => array (
					'validation_results' => false,
					'errors' => array (
						'attribute_boolean' => array ('Boolean (True or False) cannot be blank.'),
						'attribute_number' => array ('Number (1 to 10) cannot be blank.'),
						'attribute_range' => array ('Range (1,3,5,7,9) cannot be blank.'),
						'attribute_regex' => array ('Regular expression (word space number) cannot be blank.'),
						'attribute_string' => array ('String (only 15 characters) cannot be blank.'),
					),
				),
			),
			// Test 1 - scenario_default, Test attribute specific validators
			array (
				'scenario' => 'scenario_default',
				'attributes' => array (
					'attribute_boolean' => 'abc',
					'attribute_number' => 'xyz',
					'attribute_range' => 'bob',
					'attribute_regex' => '!@#',
					'attribute_string' => 'abcdefghijklmnop',
					'attribute_safe' => 'Anything can go here',
				),
				'expects' => array (
					'validation_results' => false,
					'errors' => array (
						'attribute_boolean' => array ('Boolean (True or False) must be either 1 or 0.'),
						'attribute_number' => array (
							'Number (1 to 10) must be a number.',
							'Number (1 to 10) is too small (minimum is 1).',
						),
						'attribute_range' => array ('Range (1,3,5,7,9) is not in the list.'),
						'attribute_regex' => array ('Regular expression (word space number) must contain a word, a space then a number.'),
						'attribute_string' => array ('String (only 15 characters) is too long (maximum is 15 characters).'),
					),
				),
			),
			// Test 2 - scenario_default, Success
			array (
				'scenario' => 'scenario_default',
				'attributes' => array (
					'attribute_boolean' => '1',
					'attribute_number' => '6',
					'attribute_range' => '7',
					'attribute_regex' => 'neat 1',
					'attribute_string' => 'short string',
					'attribute_safe' => '',
				),
				'expects' => array (
					'validation_results' => true,
				),
			),
		);
	}

}
