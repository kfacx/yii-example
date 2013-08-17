<?php
/**
 * BasicRelationsManyMany class file.
 *
 * @author Alexander Scott <magister@kfa.cx>
 * @link https://github.com/kfacx/yii-example
 * @copyright Copyright &copy; 2013 Alexander Scott
 * @license https://github.com/kfacx/yii-example/blob/master/LICENSE
 */

/**
 * This is the model class for table "tbl_basic_relations_many_many".
 *
 * The followings are the available columns in table 'tbl_basic_relations_many_many':
 * @property integer $id
 * @property string $column_many_many_content
 */
class BasicRelationsManyMany extends RelationsActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @return BasicRelationsManyMany the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'tbl_basic_relations_many_many';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array ('column_many_many_content', 'length', 'max' => 255),
			array ('id, column_many_many_content', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'relation_many_mains' => array (self::MANY_MANY, 'BasicRelationsMain', 'tbl_basic_relations_pivot(column_many_many_id, column_main_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'column_many_many_content' => 'Column Many Many Content',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('column_many_many_content',$this->column_many_many_content,true);
		return new CActiveDataProvider('BasicRelationsManyMany', array(
			'criteria'=>$criteria,
		));
	}
}
