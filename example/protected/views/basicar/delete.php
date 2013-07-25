<div class="form">

	<div class="errorMessage row">Are you sure you want to delete BasicAR <?php echo $basic_ar_model->id; ?>?</div>

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_ar_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Confirm', array('name' => 'confirmed')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div>
