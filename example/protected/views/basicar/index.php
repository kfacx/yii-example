<h1>Basic AR Example</h1>

<p>This example uses the CActiveRecord as the base model. This screen uses
the CGridView widget to display the rows in the table. The create/update
screen uses the CActiveForm for user input and validation error display. The
view screen uses the CDetailView widget to display a single row.</p>

<?php echo CHtml::link('Add a row', Yii::app()->createUrl('basicar/create')); ?>

<? $this->widget('zii.widgets.grid.CGridView', array (
	'id' => 'basic_ar_grid',
	'dataProvider' => $basic_ar_model->search (),
	'filter' => $basic_ar_model,
	'columns'=> array(
		array (
			'class' => 'CLinkColumn',
			'header' => 'ID',
			'labelExpression' => '$data->id',
			'urlExpression' => 'Yii::app()->createUrl (\'basicar/view\', array (\'id\' => $data->id))',
		),
		array ('name' => 'column_boolean'),
		array ('name' => 'column_number'),
		array ('name' => 'column_range'),
		array ('name' => 'column_regex'),
		array ('name' => 'column_string'),
		array ('name' => 'column_safe'),
	),
	'enableHistory' => true,
)); ?>
