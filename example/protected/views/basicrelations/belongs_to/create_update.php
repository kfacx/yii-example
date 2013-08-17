<div class="form">
	<h2><?php
		if ($basic_relations_belongs_to_model->isNewRecord) {
			echo 'Create BasicRelationsBelongsTo';
		} else {
			echo 'Update BasicRelationsBelongsTo #'.$basic_relations_belongs_to_model->id."<br />\n";
			echo CHtml::link('Cancel and go back to the view', Yii::app()->createUrl('basicrelations/belongstoview', array ('id' => $basic_relations_belongs_to_model->id)));
		} ?></h2>

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_relations_belongs_to_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<?php echo $form->errorSummary($basic_relations_belongs_to_model); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($basic_relations_belongs_to_model,'column_belongs_to_content'); ?>
		<?php echo $form->textField($basic_relations_belongs_to_model,'column_belongs_to_content'); ?>
		<?php echo $form->error($basic_relations_belongs_to_model,'column_belongs_to_content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
