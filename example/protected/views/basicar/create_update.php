<div class="form">

	<?php if (isset($update) && $update) {
		echo CHtml::link('Cancel and go back to the view', Yii::app()->createUrl('basicar/view', array ('id' => $basic_ar_model->id))); 
	} ?>

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_ar_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<?php echo $form->errorSummary($basic_ar_model); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($basic_ar_model,'column_boolean'); ?>
		<?php echo $form->checkBox($basic_ar_model,'column_boolean'); ?>
		<?php echo $form->error($basic_ar_model,'column_boolean'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_ar_model,'column_number'); ?>
		<?php echo $form->textField($basic_ar_model,'column_number'); ?>
		<?php echo $form->error($basic_ar_model,'column_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_ar_model,'column_range'); ?>
		<?php echo $form->textField($basic_ar_model,'column_range'); ?>
		<?php echo $form->error($basic_ar_model,'column_range'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_ar_model,'column_regex'); ?>
		<?php echo $form->textField($basic_ar_model,'column_regex'); ?>
		<?php echo $form->error($basic_ar_model,'column_regex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_ar_model,'column_string'); ?>
		<?php echo $form->textField($basic_ar_model,'column_string'); ?>
		<?php echo $form->error($basic_ar_model,'column_string'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_ar_model,'column_safe'); ?>
		<?php echo $form->textField($basic_ar_model,'column_safe'); ?>
		<?php echo $form->error($basic_ar_model,'column_safe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
