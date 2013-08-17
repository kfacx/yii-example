<div class="form">

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_relations_delete_form',
	)); ?>

	<div class="row">
		<label>Delete the <?php echo $class_name ?> with the ID of <?php echo $model->id; ?> and all the related entries?</label>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Delete', array ('name' => 'confirmed')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
