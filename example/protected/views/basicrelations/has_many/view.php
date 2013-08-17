<?php

$attributes_array=array (
	'column_main_id',
	'column_has_many_content',
);

if (isset ($render_id_column) && !$render_id_column)
	unset ($attributes_array[0]);

$this->widget('zii.widgets.CDetailView',array(
	'data'=>$basic_relations_has_many_model,
	'attributes'=>$attributes_array,
)); ?>
