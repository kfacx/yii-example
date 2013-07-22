<div class="form">

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<?php echo $form->errorSummary($basic_form_model); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($basic_form_model,'attribute_boolean'); ?>
		<?php echo $form->checkBox($basic_form_model,'attribute_boolean'); ?>
		<?php echo $form->error($basic_form_model,'attribute_boolean'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_form_model,'attribute_number'); ?>
		<?php echo $form->textField($basic_form_model,'attribute_number'); ?>
		<?php echo $form->error($basic_form_model,'attribute_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_form_model,'attribute_range'); ?>
		<?php echo $form->textField($basic_form_model,'attribute_range'); ?>
		<?php echo $form->error($basic_form_model,'attribute_range'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_form_model,'attribute_regex'); ?>
		<?php echo $form->textField($basic_form_model,'attribute_regex'); ?>
		<?php echo $form->error($basic_form_model,'attribute_regex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_form_model,'attribute_string'); ?>
		<?php echo $form->textField($basic_form_model,'attribute_string'); ?>
		<?php echo $form->error($basic_form_model,'attribute_string'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($basic_form_model,'attribute_safe'); ?>
		<?php echo $form->textField($basic_form_model,'attribute_safe'); ?>
		<?php echo $form->error($basic_form_model,'attribute_safe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
