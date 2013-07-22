<?php $this->beginWidget('zii.widgets.CDetailView',array(
	'data'=>$basic_form_model,
	'attributes'=>array(
		'attribute_boolean',
		'attribute_number',
		'attribute_range',
		'attribute_regex',
		'attribute_string',
		'attribute_safe',
	),
));

$this->endWidget();

// Create a hidden form to store the values in so it can be sent back to the
// input page.
$form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

<?php echo $form->hiddenField($basic_form_model,'attribute_boolean'); ?>
<?php echo $form->hiddenField($basic_form_model,'attribute_number'); ?>
<?php echo $form->hiddenField($basic_form_model,'attribute_range'); ?>
<?php echo $form->hiddenField($basic_form_model,'attribute_regex'); ?>
<?php echo $form->hiddenField($basic_form_model,'attribute_string'); ?>
<?php echo $form->hiddenField($basic_form_model,'attribute_safe'); ?>

<div class="row buttons"><?php echo CHtml::submitButton('Back to Input',array('name'=>'back_to_input')); ?></div>

<?php $this->endWidget(); ?>
