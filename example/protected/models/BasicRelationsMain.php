<?php
/**
 * BasicRelationsMain class file.
 *
 * @author Alexander Scott <magister@kfa.cx>
 * @link https://github.com/kfacx/yii-example
 * @copyright Copyright &copy; 2013 Alexander Scott
 * @license https://github.com/kfacx/yii-example/blob/master/LICENSE
 */

/**
 * This is the model class for table "tbl_basic_relations_main".
 *
 * The followings are the available columns in table 'tbl_basic_relations_main':
 * @property integer $id
 * @property integer $column_belongs_to_id
 * @property string $column_main_content
 */
class BasicRelationsMain extends RelationsActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @return BasicRelationsMain the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'tbl_basic_relations_main';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array ('column_belongs_to_id, column_main_content', 'required'),
			array ('column_belongs_to_id', 'numerical', 'integerOnly' => true),
			array ('column_belongs_to_id', 'validBelongsToID'), // Custom validator to check for the presence of the specified ID
			array ('column_main_content', 'length', 'max' => 255),
			array ('magic_attribute_many_many_selected', 'safe'),
			array ('id, column_belongs_to_id, column_main_content', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'relation_belongs_to' => array (self::BELONGS_TO, 'BasicRelationsBelongsTo', 'column_belongs_to_id'),
			'relation_has_one' => array (self::HAS_ONE, 'BasicRelationsHasOne', 'column_main_id'),
			'relation_has_many' => array (self::HAS_MANY, 'BasicRelationsHasMany', 'column_main_id'),
			'relation_many_many' => array (self::MANY_MANY, 'BasicRelationsManyMany', 'tbl_basic_relations_pivot(column_main_id, column_many_many_id)'),
		);
	}

	/**
	 * Returns an array mapping many to many relations to their pivot class
	 * and magic list attribute. (Pivot class is not currently used).
	 */
	public function many_many_map () {
		return array (
			'relation_many_many' => array (
				'class' => 'BasicRelationsPivot',
				'attribute' => 'magic_attribute_many_many_selected'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'column_belongs_to_id' => 'Column Belongs To ID',
			'column_main_content' => 'Column Main Content',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('column_belongs_to_id',$this->column_belongs_to_id);
		$criteria->compare('column_main_content',$this->column_main_content,true);

		return new CActiveDataProvider('BasicRelationsMain', array(
			'criteria'=>$criteria,
		));
	}

	/*************
	 * Validators
	 *************/

	/**
	 * Validator for the column_belongs_to_id. It verifies that the specified
	 * id exists in the tbl_basic_relations_belongs_to table.
	 */
	public function validBelongsToID ($attribute, $params) {
		// If an error is already present for this attribute, skip the check.
		if (isset ($this->errors) && isset ($this->errors[$attribute]))
			return;
		$t_params=array (
			'{attribute}' => $this->getAttributeLabel($attribute),
			'{attribute_value}' => $this->$attribute,
			'{basic_relations_belongs_to_table}' => BasicRelationsBelongsTo::tableName(),
		);
		if (!BasicRelationsBelongsTo::model()->idPresent ($this->$attribute))
			$this->addError ($attribute, Yii::t ('basic_relations', 'The {attribute} of \'{attribute_value}\' does not exist in the {basic_relations_belongs_to_table} table.', $t_params));
	}

	/*******************
	 * Magic Attributes
	 *******************/

	/**
	 * 
	 */
	public function getMagic_Attribute_Many_Many_Selected () {
		return $this->magicRelationManyManySelectedRead ('relation_many_many');
	}

	/**
	 * 
	 */
	public function setMagic_Attribute_Many_Many_Selected ($selected_list) {
		$this->magicRelationManyManySelectedWrite ('relation_many_many', $selected_list);
	}
}
