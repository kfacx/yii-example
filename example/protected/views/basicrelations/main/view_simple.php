<?php $this->widget('zii.widgets.CDetailView',array(
	'data'=>$basic_relations_main_model,
	'attributes'=>array(
		'relation_belongs_to.column_belongs_to_content',
		'column_main_content',
		'relation_has_one.column_has_one_content',
	),
)); ?>
