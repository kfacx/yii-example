<h1>Basic Relations Example</h1>

<?php $this->renderPartial ('main/index', array ('basic_relations_main_model' => $basic_relations_main_model, 'link_to_index' => true)); ?>

<?php $this->renderPartial ('belongs_to/index', array ('basic_relations_belongs_to_model' => $basic_relations_belongs_to_model, 'link_to_index' => true)); ?>

<?php $this->renderPartial ('has_one/index', array ('basic_relations_has_one_model' => $basic_relations_has_one_model, 'link_to_index' => true)); ?>

<?php $this->renderPartial ('has_many/index', array ('basic_relations_has_many_model' => $basic_relations_has_many_model, 'link_to_index' => true)); ?>

<?php $this->renderPartial ('pivot/index', array ('basic_relations_pivot_model' => $basic_relations_pivot_model, 'link_to_index' => true)); ?>

<?php $this->renderPartial ('many_many/index', array ('basic_relations_many_many_model' => $basic_relations_many_many_model, 'link_to_index' => true)); ?>
