<div class="form">
	<h2><?php
		if ($basic_relations_main_model->isNewRecord) {
			echo 'Create BasicRelationsMain';
		} else {
			echo 'Update BasicRelationsMain #'.$basic_relations_main_model->id."<br />\n";
			echo CHtml::link('Cancel and go back to the view', Yii::app()->createUrl('basicrelations/mainview', array ('id' => $basic_relations_main_model->id)));
		} ?></h2>

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_relations_main_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<?php echo $form->errorSummary($basic_relations_main_model); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($basic_relations_main_model,'column_belongs_to_id'); ?>
		<?php echo $form->dropDownList(
			$basic_relations_main_model,
			'column_belongs_to_id',
			//$basic_relations_main_model->magic_attribute_belongs_to_list,
			CHtml::listData (BasicRelationsBelongsTo::model()->findAll(), 'id', 'column_belongs_to_content'),
			array('empty' => ''));
		?>
		<?php echo $form->error($basic_relations_main_model,'column_belongs_to_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_relations_main_model,'column_main_content'); ?>
		<?php echo $form->textField($basic_relations_main_model,'column_main_content'); ?>
		<?php echo $form->error($basic_relations_main_model,'column_main_content'); ?>
	</div>

	<?php
		echo $this->renderPartial (
			'has_one/create_update_row',
			array (
				'basic_relations_has_one_model' => $basic_relations_main_model->relation_has_one,
				'form' => $form,
			),
			true,
			false
		);
 ?>


	<div class="row" id="has_many_box">
		<label>Has Many</label>
		<div style="border: 1px solid #bbb; padding: 5px;">
			<?php
				if (!empty ($basic_relations_main_model->relation_has_many)) {
					foreach ($basic_relations_main_model->relation_has_many as $i => $basic_relations_has_many_model) {
						echo $this->renderPartial ('has_many/create_update_row', array (
							'basic_relations_has_many_model' => $basic_relations_has_many_model,
							'iteration' => $i,
						), true, false);
					}
				} else {
					echo "None";
				}
			?>
			<div id="new_has_many">
				[ <?php echo CHtml::ajaxLink ('+', array ('basicrelations/hasmanycreate'), array (
					'success' => 'js:function(data){$(\'#new_has_many\').before(data);}'
				)); ?> ]
			</div>
		</div>
	</div>

	<div class="row">
		<label>Many Many</label>
		<div style="border: 1px solid #bbb; padding: 5px;">
			<?php
				echo CHtml::activeListBox(
					$basic_relations_main_model,
					'magic_attribute_many_many_selected',
					CHtml::listData (
						BasicRelationsManyMany::model()->findAll(),
						'id',
						'column_many_many_content'
					),
					array ('multiple' => 'multiple')
				);
			?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
