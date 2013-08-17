	<div class="row">
		<?php
			if (isset ($iteration)) {
				echo '['.CHtml::link('x','#',array ('onclick' => '$(this).parent().remove(); return false;')).']';
				$column_prepend='['.$iteration.']';
			} else {
				$column_prepend='';
			}
		?>
		<?php if (!$basic_relations_has_many_model->isNewRecord)
			echo CHtml::activeHiddenField($basic_relations_has_many_model,$column_prepend.'id'); ?>
		<?php echo CHtml::activeLabel($basic_relations_has_many_model,$column_prepend.'column_has_many_content'); ?>
		<?php echo CHtml::activeTextField($basic_relations_has_many_model,$column_prepend.'column_has_many_content'); ?>
		<?php echo CHtml::error($basic_relations_has_many_model,$column_prepend.'column_has_many_content'); ?>
	</div>
