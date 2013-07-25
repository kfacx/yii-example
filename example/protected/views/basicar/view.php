<?php echo CHtml::link('Update', Yii::app()->createUrl('basicar/update', array ('id' => $basic_ar_model->id))); ?>
&nbsp;
<?php echo CHtml::link('Delete', Yii::app()->createUrl('basicar/delete', array ('id' => $basic_ar_model->id))); ?>

<?php $this->widget('zii.widgets.CDetailView',array(
	'data'=>$basic_ar_model,
	'attributes'=>array(
		'column_boolean',
		'column_number',
		'column_range',
		'column_regex',
		'column_string',
		'column_safe',
	),
)); ?>
