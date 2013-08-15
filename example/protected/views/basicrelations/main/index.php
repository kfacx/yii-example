<h2><?php if (isset ($link_to_index) && $link_to_index) {
	echo CHtml::link ('BasicRelationsMain', Yii::app()->createUrl('basicrelations/mainindex'));
} else {
	echo 'BasicRelationsMain';
} ?></h2>
<br />
[<?php echo CHtml::link('Add a Main Entry', Yii::app()->createUrl('basicrelations/maincreate')); ?>]
<? $this->widget('zii.widgets.grid.CGridView', array (
	'id' => 'basic_relations_main_grid',
	'dataProvider' => $basic_relations_main_model->search (),
	'filter' => $basic_relations_main_model,
	'columns'=> array(
		array (
			'class' => 'CLinkColumn',
			'header' => 'ID',
			'labelExpression' => '$data->id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/mainview\', array (\'id\' => $data->id))',
		),
		array (
			'class' => 'CLinkColumn',
			'header' => 'Belongs To ID',
			'labelExpression' => '$data->column_belongs_to_id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/belongstoview\', array (\'id\' => $data->column_belongs_to_id))',
		),
		array ('name' => 'column_main_content'),
	),
	'enableHistory' => true,
)); ?>
