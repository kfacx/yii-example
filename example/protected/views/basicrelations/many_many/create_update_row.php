	<div class="row">
		<?php
			if (empty ($basic_relations_many_many_model))
				$basic_relations_many_many_model=new BasicRelationsManyMany;
			else
				echo $form->hiddenField($basic_relations_many_many_model,'column_main_id');
// This probably need to be different since the many to many should not be created at the same time as the related entry
// Many to manies are only assigned.
			echo $form->labelEx($basic_relations_many_many_model,'column_many_many_content');
			echo $form->textField($basic_relations_many_many_model,'column_many_many_content');
			echo $form->error($basic_relations_many_many_model,'column_many_many_content');
		?>
	</div>
