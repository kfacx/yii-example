<?php echo CHtml::link('Update', Yii::app()->createUrl('basicrelations/belongstoupdate', array ('id' => $basic_relations_belongs_to_model->id))); ?>
&nbsp;
<?php echo CHtml::link('Delete', Yii::app()->createUrl('basicrelations/belongstodelete', array ('id' => $basic_relations_belongs_to_model->id))); ?>

<?php $this->widget('zii.widgets.CDetailView',array(
	'data'=>$basic_relations_belongs_to_model,
	'attributes'=>array(
		'column_belongs_to_content',
		array (
			'name' => 'Assigned Mains',
			'type' => 'raw',
			// Call anonymous function
			'value' => call_user_func (function ($mains_array) {
				if (empty ($mains_array))
					return '<div>No Has Many Mains assigned.</div>';
				$rendered='';
				// Itterate over the Has Many objects and render each one. Appending
				// the output to a string.
				foreach ($mains_array as $main_object) {
					$rendered.=$this->renderPartial ('main/view_simple', array (
						'basic_relations_main_model' => $main_object,
					), true, false);
					$rendered.="\n";
				}
				// Return rendered output.
				return $rendered;
			// Make sure the anonymous function is passed the array of Has Many
			// objects.
			}, $basic_relations_belongs_to_model->relation_has_many_mains),
		),
	),
)); ?>
