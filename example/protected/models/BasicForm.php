<?php
/**
 * BasicForm class file.
 *
 * @author Alexander Scott <magister@kfa.cx>
 * @link https://github.com/kfacx/yii-example
 * @copyright Copyright &copy; 2013 Alexander Scott
 * @license https://github.com/kfacx/yii-example/blob/master/LICENSE
 */

/**
 * Basic form example.
 *
 * This example is based on the CFormModel which can do basic input
 * validation and any other processing on that data as necessary. It will
 * demonstrate the validation using various scenarios and produce some
 * simple output.
 *
 * Note about scenarios: The CFormModel by default the scenario is empty. In
 * the rule if the scenario is not specified then it applies to all
 * scenarios. In this example the default (empty) scenario is not used.
 */
class BasicForm extends CFormModel {
	public $attribute_boolean;
	public $attribute_number;
	public $attribute_range;
	public $attribute_regex;
	public $attribute_string;
	public $attribute_safe;

	public function rules() {
		return array (
			// scenario_default
			// The following attributes are included in this scenario:
			//   attribute_boolean
			//   attribute_number
			//   attribute_range
			//   attribute_regex
			//   attribute_string
			//   attribute_safe
			// CRequiredValidator
			array (
				'attribute_number, attribute_range, attribute_regex, attribute_string',
				'required',
				'on' => 'scenario_default',
			),
			// CBooleanValidator
			array (
				'attribute_boolean',
				'boolean',
				'on' => 'scenario_default',
			),
			// CNumberValidator
			array (
				'attribute_number',
				'numerical',
				'min' => 1,
				'max' => 10,
				'on' => 'scenario_default',
			),
			// CRangeValidator
			array (
				'attribute_range',
				'in',
				'range' => array (1,3,5,7,9),
				'on' => 'scenario_default',
			),
			// CRegularExpressionValidator
			array (
				'attribute_regex',
				'match',
				'pattern' => '/\w+ \d+/',
				'message' => '{attribute} must contain a word, a space then a number.',
				'on' => 'scenario_default',
			),
			// CStringValidator
			array (
				'attribute_string',
				'length',
				'max' => 15,
				'on' => 'scenario_default',
			),
			array (
				'attribute_safe',
				'safe',
				'on' => 'scenario_default',
			),
		);
	}

	public function attributeLabels () {
		return array (
			'attribute_boolean' => 'Boolean (True or False)',
			'attribute_number' => 'Number (1 to 10)',
			'attribute_range' => 'Range (1,3,5,7,9)',
			'attribute_regex' => 'Regular expression (word space number)',
			'attribute_string' => 'String (only 15 characters)',
			'attribute_safe' => 'Safe (anything can go here or nothing can)',
		);
	}

}
