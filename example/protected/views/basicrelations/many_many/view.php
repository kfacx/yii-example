<?php

$attributes_array=array (
	'column_many_many_content',
);

$this->widget('zii.widgets.CDetailView',array(
	'data'=>$basic_relations_many_many_model,
	'attributes'=>$attributes_array,
)); ?>
