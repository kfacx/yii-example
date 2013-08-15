<h2><?php if (isset ($link_to_index) && $link_to_index) {
	echo CHtml::link ('BasicRelationsPivot', Yii::app()->createUrl('basicrelations/pivotindex'));
} else {
	echo 'BasicRelationsPivot';
} ?></h2>
<br />
<? $this->widget('zii.widgets.grid.CGridView', array (
	'id' => 'basic_relations_pivot_grid',
	'dataProvider' => $basic_relations_pivot_model->search (),
	'filter' => $basic_relations_pivot_model,
	'columns'=> array(
		array ('name' => 'id'),
		array (
			'class' => 'CLinkColumn',
			'header' => 'Main ID',
			'labelExpression' => '$data->column_main_id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/mainview\', array (\'id\' => $data->column_main_id))',
		),
		array (
			'class' => 'CLinkColumn',
			'header' => 'Main ID',
			'labelExpression' => '$data->column_many_many_id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/manymanyview\', array (\'id\' => $data->column_many_many_id))',
		),
	),
	'enableHistory' => true,
)); ?>
