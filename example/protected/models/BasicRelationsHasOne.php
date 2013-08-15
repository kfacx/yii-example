<?php

/**
 * This is the model class for table "tbl_basic_relations_has_one".
 *
 * The followings are the available columns in table 'tbl_basic_relations_has_one':
 * @property integer $id
 * @property integer $column_main_id
 * @property string $column_has_one_content
 */
class BasicRelationsHasOne extends RelationsActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @return BasicRelationsHasOne the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'tbl_basic_relations_has_one';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array ('column_has_one_content', 'required'),
			array ('column_main_id', 'unsafe', 'on' => 'insert, update'),
			array ('column_has_one_content', 'length', 'max' => 255),
			array ('id, column_main_id, column_has_one_content', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'relation_belongs_to_main' => array (self::BELONGS_TO, 'BasicRelationsMain', 'column_main_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'column_main_id' => 'Column Main ID',
			'column_has_one_content' => 'Column Has One Content',
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
		$criteria->compare('column_has_one_content',$this->column_has_one_content,true);
		return new CActiveDataProvider('BasicRelationsHasOne', array(
			'criteria'=>$criteria,
		));
	}
}
