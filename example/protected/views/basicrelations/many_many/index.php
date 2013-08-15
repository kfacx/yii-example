<h2><?php if (isset ($link_to_index) && $link_to_index) {
	echo CHtml::link ('BasicRelationsManyMany', Yii::app()->createUrl('basicrelations/manymanyindex'));
} else {
	echo 'BasicRelationsManyMany';
} ?></h2>
<br />
[<?php echo CHtml::link('Add a Many Many Entry', Yii::app()->createUrl('basicrelations/manymanycreate')); ?>]
<? $this->widget('zii.widgets.grid.CGridView', array (
	'id' => 'basic_relations_many_many_grid',
	'dataProvider' => $basic_relations_many_many_model->search (),
	'filter' => $basic_relations_many_many_model,
	'columns'=> array(
		array (
			'class' => 'CLinkColumn',
			'header' => 'ID',
			'labelExpression' => '$data->id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/manymanyview\', array (\'id\' => $data->id))',
		),
		array ('name' => 'column_many_many_content'),
	),
	'enableHistory' => true,
)); ?>
