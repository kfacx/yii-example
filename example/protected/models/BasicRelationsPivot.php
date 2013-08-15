<?php

/**
 * This is the model class for table "tbl_basic_relations_pivot".
 *
 * The followings are the available columns in table 'tbl_basic_relations_pivot':
 * @property integer $id
 * @property integer $column_main_id
 * @property string $column_many_many_id
 */
class BasicRelationsPivot extends RelationsActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @return BasicRelationsPivot the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'tbl_basic_relations_pivot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array ('column_main_id', 'numerical', 'integerOnly' => true),
			array ('column_many_many_id', 'length', 'max' => 255),
			array ('id, column_main_id, column_many_many_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'relation_belongs_to_main' => array (self::BELONGS_TO, 'BasicRelationsMain', 'column_main_id'),
			'relation_belongs_to_many_many' => array (self::BELONGS_TO, 'BasicRelationsManyMany', 'column_many_many_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'column_main_id' => 'Column Main ID',
			'column_many_many_id' => 'Column Many Many ID',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('column_main_id',$this->column_main_id);
		$criteria->compare('column_many_many_id',$this->column_many_many_id,true);
		return new CActiveDataProvider('BasicRelationsPivot', array(
			'criteria'=>$criteria,
		));
	}
}
