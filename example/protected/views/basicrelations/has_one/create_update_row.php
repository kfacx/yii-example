	<div class="row">
		<?php
			if (empty ($basic_relations_has_one_model))
				$basic_relations_has_one_model=new BasicRelationsHasOne;
			else
				echo $form->hiddenField($basic_relations_has_one_model,'column_main_id');
			echo $form->labelEx($basic_relations_has_one_model,'column_has_one_content');
			echo $form->textField($basic_relations_has_one_model,'column_has_one_content');
			echo $form->error($basic_relations_has_one_model,'column_has_one_content');
		?>
	</div>
