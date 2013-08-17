<?php

/**
 * This is the model class for table "tbl_basic_relations_belongs_to".
 *
 * The followings are the available columns in table 'tbl_basic_relations_belongs_to':
 * @property integer $id
 * @property string $column_belongs_to_content
 */
class BasicRelationsBelongsTo extends RelationsActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @return BasicRelationsBelongsTo the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'tbl_basic_relations_belongs_to';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array ('column_belongs_to_content', 'required'),
			array ('column_belongs_to_content', 'length', 'max' => 255),
			array ('id, column_belongs_to_content', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'relation_has_many_mains' => array (self::HAS_MANY, 'BasicRelationsMain', 'column_belongs_to_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'column_belongs_to_content' => 'Column Belongs To Content',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('column_belongs_to_content',$this->column_belongs_to_content,true);
		return new CActiveDataProvider('BasicRelationsBelongsTo', array(
			'criteria'=>$criteria,
		));
	}
}
