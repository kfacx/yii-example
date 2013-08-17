<h2><?php if (isset ($link_to_index) && $link_to_index) {
	echo CHtml::link ('BasicRelationsHasMany', Yii::app()->createUrl('basicrelations/hasmanyindex'));
} else {
	echo 'BasicRelationsHasMany';
} ?></h2>
<br />
<? $this->widget('zii.widgets.grid.CGridView', array (
	'id' => 'basic_relations_has_many_grid',
	'dataProvider' => $basic_relations_has_many_model->search (),
	'filter' => $basic_relations_has_many_model,
	'columns'=> array(
		array (
			'class' => 'CLinkColumn',
			'header' => 'ID',
			'labelExpression' => '$data->id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/hasmanyview\', array (\'id\' => $data->id))',
		),
		array (
			'class' => 'CLinkColumn',
			'header' => 'Main ID',
			'labelExpression' => '$data->column_main_id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/mainview\', array (\'id\' => $data->column_main_id))',
		),
		array ('name' => 'column_has_many_content'),
	),
	'enableHistory' => true,
)); ?>
