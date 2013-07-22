<h1>Basic Form Example</h1>

<p>This example uses the CFormModel as the base model. It uses the
CActiveForm widget for generating the html form. Lastly it uses the
CDetailView widget to display the results on successfull validation.</p>

<p>Go to the <?php echo CHtml::link('Input', Yii::app()->createUrl('basicform/input')); ?>
 page to interact with the form. If the submission passes validation then it
redirects to the <?php echo CHtml::link('Display', Yii::app()->createUrl('basicform/display')); ?> page.</p>
