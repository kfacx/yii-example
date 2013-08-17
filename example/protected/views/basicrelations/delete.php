<div class="form">

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_relations_main_delete_form',
	)); ?>

	<div class="row">
		<label>Delete the BasicRelationsMain with the ID of <?php echo $basic_relations_main_model->id; ?> and all the related entries?</label>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Delete', array ('name' => 'confirmed')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
