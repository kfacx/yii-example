	<div class="row">
		<?php
			if (empty ($basic_relations_pivot_model))
				$basic_relations_pivot_model=new BasicRelationsPivot;
			else
				echo $form->hiddenField($basic_relations_pivot_model,'column_main_id');
//			echo $form->labelEx($basic_relations_pivot_model,'column_pivot_content');
//			echo $form->textField($basic_relations_pivot_model,'column_pivot_content');
//			echo $form->error($basic_relations_pivot_model,'column_pivot_content');
		?>
	</div>
