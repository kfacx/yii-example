<?php
/**
 * BasicAR class file.
 *
 * @author Alexander Scott <magister@kfa.cx>
 * @link https://github.com/kfacx/yii-example
 * @copyright Copyright &copy; 2013 Alexander Scott
 * @license https://github.com/kfacx/yii-example/blob/master/LICENSE
 */

/**
 * This is the model class for table "tbl_basic_ar".
 *
 * The followings are the available columns in table 'tbl_basic_ar':
 * @property integer $id
 * @property integer $column_boolean
 * @property integer $column_number
 * @property integer $column_range
 * @property string $column_regex
 * @property string $column_string
 * @property string $column_safe
 */
class BasicAR extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @return BasicAR the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'tbl_basic_ar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			// CRequiredValidator
			array (
				'column_number, column_range, column_regex, column_string',
				'required',
			),
			// The following columns in the DB are created as a INTEGER type,
			// meaning that they cannot be floats.
			array (
				'column_boolean, column_number, column_range',
				'numerical',
				'integerOnly' => true,
			),
			// CBooleanValidator
			array (
				'column_boolean',
				'boolean',
			),
			// CNumberValidator
			array (
				'column_number',
				'numerical',
				'min' => 1,
				'max' => 10,
			),
			// CRangeValidator
			array (
				'column_range',
				'in',
				'range' => array (1,3,5,7,9),
			),
			// The following colums are strings, but the migration defaults to a
			// maximum length of 255 characters.
			array (
				'column_regex, column_safe',
				'length',
				'max' => 255,
			),
			// CStringValidator, column_string in the db is defined as 255, but
			// were constraining it to 15 characters.
			array (
				'column_string',
				'length',
				'max' => 15,
			),
			// CRegularExpressionValidator
			array (
				'column_regex',
				'match',
				'pattern' => '/\w+ \d+/',
				'message' => '{attribute} must contain a word, a space then a number.',
			),
			// When the scenario is 'search' any data set in these attributes is
			// valid.
			// NOTE: The column 'id' should only be allowed in the 'search'
			// scenario, never in the 'insert' or 'update' scenario.
			array (
				'id, column_boolean, column_number, column_range, column_regex, column_string, column_safe',
				'safe',
				'on' => 'search',
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'column_boolean' => 'Boolean',
			'column_number' => 'Number',
			'column_range' => 'Range',
			'column_regex' => 'Regexp',
			'column_string' => 'String',
			'column_safe' => 'Safe',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare ('id', $this->id);
		$criteria->compare ('column_boolean', $this->column_boolean);
		$criteria->compare ('column_number', $this->column_number);
		$criteria->compare ('column_range', $this->column_range);
		$criteria->compare ('column_regex', $this->column_regex, true);
		$criteria->compare ('column_string', $this->column_string, true);
		$criteria->compare ('column_safe', $this->column_safe, true);

		return new CActiveDataProvider('BasicAR', array(
			'criteria' => $criteria,
		));
	}
}
