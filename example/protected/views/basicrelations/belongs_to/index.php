<h2><?php if (isset ($link_to_index) && $link_to_index) {
	echo CHtml::link ('BasicRelationsBelongsTo', Yii::app()->createUrl('basicrelations/belongstoindex'));
} else {
	echo 'BasicRelationsBelongsTo';
} ?></h2>
<br />
[<?php echo CHtml::link('Add a Belongs To Entry', Yii::app()->createUrl('basicrelations/belongstocreate')); ?>]
<? $this->widget('zii.widgets.grid.CGridView', array (
	'id' => 'basic_relations_belongs_to_grid',
	'dataProvider' => $basic_relations_belongs_to_model->search (),
	'filter' => $basic_relations_belongs_to_model,
	'columns'=> array(
		array (
			'class' => 'CLinkColumn',
			'header' => 'ID',
			'labelExpression' => '$data->id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicrelations/belongstoview\', array (\'id\' => $data->id))',
		),
		array ('name' => 'column_belongs_to_content'),
	),
	'enableHistory' => true,
)); ?>
