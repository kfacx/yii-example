<div class="form">

	<h2><?php
		if ($basic_relations_has_many_model->isNewRecord) {
			echo 'Create BasicRelationsHasMany';
		} else {
			echo 'Update BasicRelationsHasMany #'.$basic_relations_has_many_model->id."<br />\n";
			echo CHtml::link('Cancel and go back to the view', Yii::app()->createUrl('basicrelations/hasmanyview', array ('id' => $basic_relations_has_many_model->id)));
		} ?></h2>

	<?php $form=$this->beginWidget('CActiveForm',array(
		'id'=>'basic_relations_has_many_form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<?php echo $form->errorSummary($basic_relations_has_many_model); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($basic_relations_has_many_model,'column_boolean'); ?>
		<?php echo $form->checkBox($basic_relations_has_many_model,'column_boolean'); ?>
		<?php echo $form->error($basic_relations_has_many_model,'column_boolean'); ?>
	</div>
