<?php
/**
 * BasicarController class file.
 *
 * @author Alexander Scott <magister@kfa.cx>
 * @link https://github.com/kfacx/yii-example
 * @copyright Copyright &copy; 2013 Alexander Scott
 * @license https://github.com/kfacx/yii-example/blob/master/LICENSE
 */

/*
 * BasicAR example controller.
 *
 * Note that in the filename and class name the 'ar' is lowercase. Yii can
 * only match the class name if the first letter of the controller name is
 * upper case.
 */
class BasicarController extends Controller {

	public function actionIndex() {
		$this->breadcrumbs=array('Basic AR');
		$basic_ar_model=new BasicAR ('search');
		if (isset ($_POST['BasicAR']))
			$basic_ar_model->attributes=$_POST['BasicAR'];
		$this->render('index', array ('basic_ar_model' => $basic_ar_model));
	}

	public function actionCreate() {
		$this->breadcrumbs=array(
			'Basic AR' => array('basicar/index'),
			'Create',
		);

		$basic_ar_model=new BasicAR;
		if (isset ($_POST['BasicAR'])) {
			$basic_ar_model->attributes=$_POST['BasicAR'];
			if ($basic_ar_model->save ()) {
				$this->redirect (array ('basicar/view', 'id' => $basic_ar_model->id));
			}
		}
		$this->render('create_update', array('basic_ar_model'=>$basic_ar_model));
	}

	public function actionView ($id) {
		$this->breadcrumbs=array(
			'Basic AR' => array('basicar/index'),
		);

		$basic_ar_model=BasicAR::model()->findByPk ($id);
		if (empty ($basic_ar_model))
			throw new CHttpException (404, "View: Unable to find the ID {$id} for BasicAR");

		$this->breadcrumbs[]=$basic_ar_model->id;

		$this->render('view', array('basic_ar_model' => $basic_ar_model));
	}

	public function actionUpdate ($id) {
		$this->breadcrumbs=array(
			'Basic AR' => array('basicar/index'),
		);

		$basic_ar_model=BasicAR::model()->findByPk ($id);
		if (empty ($basic_ar_model))
			throw new CHttpException (404, "Update: Unable to find the ID {$id} for BasicAR");

		$this->breadcrumbs[$basic_ar_model->id] = array('basicar/view', 'id' => $basic_ar_model->id);
		$this->breadcrumbs[]='Update';

		if (isset ($_POST['BasicAR'])) {
			$basic_ar_model->attributes=$_POST['BasicAR'];
			if ($basic_ar_model->save ()) {
				$this->redirect (array ('basicar/view', 'id' => $basic_ar_model->id));
			}
		}

		$this->render('create_update', array('basic_ar_model' => $basic_ar_model, 'update' => true));
	}

	public function actionDelete ($id) {
		$this->breadcrumbs=array(
			'Basic AR' => array('basicar/index'),
		);

		$basic_ar_model=BasicAR::model()->findByPk ($id);
		if (empty ($basic_ar_model))
			throw new CHttpException (404, "Delete: Unable to find the ID {$id} for BasicAR");

		$this->breadcrumbs[$basic_ar_model->id] = array('basicar/view', 'id' => $basic_ar_model->id);
		$this->breadcrumbs[]='Delete';

		if (isset ($_POST['confirmed'])) {
			$basic_ar_model->delete();
			$this->redirect (array ('basicar/index'));
		}

		$this->render('delete', array('basic_ar_model' => $basic_ar_model));
	}
}
