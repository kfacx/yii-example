<?php

/*
 * BasicForm example controller.
 *
 * Note that in the filename and class name the f in form is lowercase. Yii
 * can only match the class name if the first letter of the controller name
 * is upper case.
 */
class BasicformController extends Controller {

	public function actionIndex() {
		$this->breadcrumbs=array('Basic Form');
		$this->render('index');
	}

	public function actionInput() {
		$this->breadcrumbs=array(
			'Basic Form' => array('basicform/index'),
			'Input',
		);
		$basic_form_model=new BasicForm ('scenario_default');
		if (isset ($_POST['BasicForm'])) {
			$basic_form_model->attributes=$_POST['BasicForm'];
			// If back_to_input is set (the button on the display was clicked)
			// then we dont need to validate or redirect.
			if (!isset ($_POST['back_to_input']) && $basic_form_model->validate()) {
				// forward is used here to keep the POST variable intact.
				$this->forward('display');
			}
		}
		$this->render('input', array('basic_form_model'=>$basic_form_model));
	}

	public function actionDisplay() {
		$this->breadcrumbs=array(
			'Basic Form' => array('basicform/index'),
			'Input',
		);
		$basic_form_model=new BasicForm ('scenario_default');
		if (isset ($_POST['BasicForm'])) {
			$basic_form_model->attributes=$_POST['BasicForm'];
		}
		$this->render('display', array('basic_form_model'=>$basic_form_model));
	}
}
