<?php echo CHtml::link('Update', Yii::app()->createUrl('basicrelations/mainupdate', array ('id' => $basic_relations_main_model->id))); ?>
&nbsp;
<?php echo CHtml::link('Delete', Yii::app()->createUrl('basicrelations/maindelete', array ('id' => $basic_relations_main_model->id))); ?>

<?php $this->widget('zii.widgets.CDetailView',array(
	'data'=>$basic_relations_main_model,
	'attributes'=>array(
//		'magic_attribute_belongs_to_content', // Magic attribute style
		'relation_belongs_to.column_belongs_to_content', // relation aware style.
		'column_main_content', // Actual column in the basic_relations_main table.
//		'magic_attribute_has_one', // magic attribute style
		'relation_has_one.column_has_one_content', // relation aware style.
		// Since the CDetailView does not support array data the Has Many and
		// Many Many relations need to be pre-process into a string.
		array (
			'name' => 'Has Manies Rendered',
			'type' => 'raw',
			// Call anonymous function
			'value' => call_user_func (function ($has_many_array) {
				if (empty ($has_many_array))
					return '<div>No Has Many relations found.</div>';
				$rendered='';
				// Itterate over the Has Many objects and render each one. Appending
				// the output to a string.
				foreach ($has_many_array as $has_many_object) {
					$rendered.=$this->renderPartial ('has_many/view', array (
						'basic_relations_has_many_model' => $has_many_object,
						'render_id_column' => false,
					), true, false);
					$rendered.="\n";
				}
				// Return rendered output.
				return $rendered;
			// Make sure the anonymous function is passed the array of Has Many
			// objects.
			}, $basic_relations_main_model->relation_has_many),
		),
		// Same as above.
		array (
			'name' => 'Many Manies Rendered',
			'type' => 'raw',
			// Call anonymous function
			'value' => call_user_func (function ($many_many_array) {
				if (empty ($many_many_array))
					return '<div>No Many Many relations found.</div>';
				$rendered='';
				// Itterate over the Many Many objects and render each one. Appending
				// the output to a string.
				foreach ($many_many_array as $many_many_object) {
					$rendered.=$this->renderPartial ('many_many/view', array (
						'basic_relations_many_many_model' => $many_many_object,
					), true, false);
					$rendered.="\n";
				}
				// Return rendered output.
				return $rendered;
			// Make sure the anonymous function is passed the array of Has Many
			// objects.
			}, $basic_relations_main_model->relation_many_many),
		),
	),
)); ?>
