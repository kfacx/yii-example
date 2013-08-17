<?php

class BasicrelationsController extends Controller {

	public function actionIndex() {
		$this->breadcrumbs=array('Basic Relations');

		$basic_relations_main_model=new BasicRelationsMain ('search');
		if (isset ($_POST['BasicRelationsMain']))
			$basic_relations_main_model->attributes=$_POST['BasicRelationsMain'];

		$basic_relations_belongs_to_model=new BasicRelationsBelongsTo ('search');
		if (isset ($_POST['BasicRelationsBelongsTo']))
			$basic_relations_belongs_to_model->attributes=$_POST['BasicRelationsBelongsTo'];

		$basic_relations_has_one_model=new BasicRelationsHasOne ('search');
		if (isset ($_POST['BasicRelationsHasOne']))
			$basic_relations_has_one_model->attributes=$_POST['BasicRelationsHasOne'];

		$basic_relations_has_many_model=new BasicRelationsHasMany ('search');
		if (isset ($_POST['BasicRelationsHasMany']))
			$basic_relations_has_many_model->attributes=$_POST['BasicRelationsHasMany'];

		$basic_relations_pivot_model=new BasicRelationsPivot ('search');
		if (isset ($_POST['BasicRelationsPivot']))
			$basic_relations_pivot_model->attributes=$_POST['BasicRelationsPivot'];

		$basic_relations_many_many_model=new BasicRelationsManyMany ('search');
		if (isset ($_POST['BasicRelationsManyMany']))
			$basic_relations_many_many_model->attributes=$_POST['BasicRelationsManyMany'];

		$view_vars=array (
			'basic_relations_main_model' => $basic_relations_main_model,
			'basic_relations_belongs_to_model' => $basic_relations_belongs_to_model,
			'basic_relations_has_one_model' => $basic_relations_has_one_model,
			'basic_relations_has_many_model' => $basic_relations_has_many_model,
			'basic_relations_pivot_model' => $basic_relations_pivot_model,
			'basic_relations_many_many_model' => $basic_relations_many_many_model,
		);

		$this->render('index', $view_vars);
	}

	/**
	 * Main Section
	 */

	public function actionMainindex() {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Main',
		);

		$basic_relations_main_model=new BasicRelationsMain ('search');
		if (isset ($_POST['BasicRelationsMain']))
			$basic_relations_main_model->attributes=$_POST['BasicRelationsMain'];

		$this->render('main/index', array('basic_relations_main_model' => $basic_relations_main_model));
	}

	public function actionMainview ($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Main' => array('basicrelations/mainindex'),
		);

		$basic_relations_main_model=BasicRelationsMain::model()->findByPk ($id);
		if (empty ($basic_relations_main_model))
			throw new CHttpException (404, "View: Unable to find the ID {$id} for BasicRelationsMain");

		$this->breadcrumbs[]=$basic_relations_main_model->id;

		$this->render('main/view', array('basic_relations_main_model' => $basic_relations_main_model));
	}

	public function actionMaincreate () {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Main' => array('basicrelations/mainindex'),
			'Create',
		);

		$basic_relations_main_model=new BasicRelationsMain;
		if (isset ($_POST['BasicRelationsMain'])) {
			$basic_relations_main_model->post_attributes=$_POST;
			if ($basic_relations_main_model->save ())
				$this->redirect (array ('basicrelations/mainview', 'id' => $basic_relations_main_model->id));
		}

		$this->render('main/create_update', array('basic_relations_main_model' => $basic_relations_main_model));
	}

	public function actionMainupdate($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Main' => array('basicrelations/mainindex'),
		);

		$basic_relations_main_model=BasicRelationsMain::model()->findByPk ($id);
		if (!$basic_relations_main_model)
			throw new CHttpException (404, "Update: Unable to find the ID {$id} for BasicRelationsMain");

		$this->breadcrumbs[$id]=array ('basicrelations/mainview', 'id' => $id);
		$this->breadcrumbs[]='Update';

		if (isset ($_POST['BasicRelationsMain'])) {
			$basic_relations_main_model->post_attributes=$_POST;
			if ($basic_relations_main_model->save ())
				$this->redirect (array ('basicrelations/mainview', 'id' => $basic_relations_main_model->id));
		}

		$this->render('main/create_update', array('basic_relations_main_model' => $basic_relations_main_model));
	}

	public function actionMaindelete($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Main' => array('basicrelations/mainindex'),
		);

		$basic_relations_main_model=BasicRelationsMain::model()->findByPk ($id);
		if (!$basic_relations_main_model)
			throw new CHttpException (404, "Delete: Unable to find the ID {$id} for BasicRelationsMain");

		$this->breadcrumbs[$id]=array ('basicrelations/mainview', 'id' => $id);
		$this->breadcrumbs[]='Delete';

		if (isset ($_POST['confirmed'])) {
			if ($basic_relations_main_model->delete ())
				$this->redirect (array ('basicrelations/mainindex'));
		}

		$this->render('main/delete', array('basic_relations_main_model' => $basic_relations_main_model));
	}

	/**
	 * Belongs To Section
	 */

	public function actionBelongstoindex() {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Belongs To',
		);

		$basic_relations_belongs_to_model=new BasicRelationsBelongsTo ('search');
		if (isset ($_POST['BasicRelationsBelongsTo']))
			$basic_relations_main_model->attributes=$_POST['BasicRelationsBelongsTo'];

		$this->render('belongs_to/index', array('basic_relations_belongs_to_model' => $basic_relations_belongs_to_model));
	}

	public function actionBelongstoview($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Belongs To' => array('basicrelations/belongstoindex'),
		);

		$basic_relations_belongs_to_model=BasicRelationsBelongsTo::model()->findByPk ($id);
		if (empty ($basic_relations_belongs_to_model))
			throw new CHttpException (404, "View: Unable to find the ID {$id} for BasicRelationsBelongsTo");

		$this->breadcrumbs[]=$basic_relations_belongs_to_model->id;

		$this->render('belongs_to/view', array('basic_relations_belongs_to_model' => $basic_relations_belongs_to_model));
	}

	/**
	 * Has One Section
	 */

	public function actionHasoneindex() {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Has One',
		);

		$basic_relations_has_one_model=new BasicRelationsHasOne ('search');
		if (isset ($_POST['BasicRelationsHasOne']))
			$basic_relations_main_model->attributes=$_POST['BasicRelationsHasOne'];

		$this->render('has_one/index', array('basic_relations_has_one_model' => $basic_relations_has_one_model));
	}

	public function actionHasoneview($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Has One' => array('basicrelations/hasoneindex'),
		);

		$basic_relations_has_one_model=BasicRelationsHasOne::model()->findByPk ($id);
		if (empty ($basic_relations_has_one_model))
			throw new CHttpException (404, "View: Unable to find the ID {$id} for BasicRelationsHasOne");

		$this->breadcrumbs[]=$basic_relations_has_one_model->id;

		$this->render('has_one/view', array('basic_relations_has_one_model' => $basic_relations_has_one_model));
	}

	/**
	 * Has Many Section
	 */

	public function actionHasmanyindex() {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Has Many',
		);

		$basic_relations_has_many_model=new BasicRelationsHasMany ('search');
		if (isset ($_POST['BasicRelationsHasMany']))
			$basic_relations_main_model->attributes=$_POST['BasicRelationsHasMany'];

		$this->render('has_many/index', array('basic_relations_has_many_model' => $basic_relations_has_many_model));
	}

	public function actionHasmanyview($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Has Many' => array('basicrelations/hasmanyindex'),
		);

		$basic_relations_has_many_model=BasicRelationsHasMany::model()->findByPk ($id);
		if (empty ($basic_relations_has_many_model))
			throw new CHttpException (404, "View: Unable to find the ID {$id} for BasicRelationsHasMany");

		$this->breadcrumbs[]=$basic_relations_has_many_model->id;

		$this->render('has_many/view', array('basic_relations_has_many_model' => $basic_relations_has_many_model));
	}

	/**
	 * Pivot Section
	 */
	public function actionPivotindex() {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Pivot',
		);

		$basic_relations_pivot_model=new BasicRelationsPivot ('search');
		if (isset ($_POST['BasicRelationsPivot']))
			$basic_relations_main_model->attributes=$_POST['BasicRelationsPivot'];

		$this->render('pivot/index', array('basic_relations_pivot_model' => $basic_relations_pivot_model));
	}

	public function actionPivotview($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Pivot' => array('basicrelations/pivotindex'),
		);

		$basic_relations_pivot_model=BasicRelationsPivot::model()->findByPk ($id);
		if (empty ($basic_relations_pivot_model))
			throw new CHttpException (404, "View: Unable to find the ID {$id} for BasicRelationsPivot");

		$this->breadcrumbs[]=$basic_relations_pivot_model->id;

		$this->render('pivot/view', array('basic_relations_pivot_model' => $basic_relations_pivot_model));
	}

	/**
	 * Many Many Section
	 */

	public function actionManymanyindex() {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Many Many',
		);

		$basic_relations_many_many_model=new BasicRelationsManyMany ('search');
		if (isset ($_POST['BasicRelationsManyMany']))
			$basic_relations_main_model->attributes=$_POST['BasicRelationsManyMany'];

		$this->render('many_many/index', array('basic_relations_many_many_model' => $basic_relations_many_many_model));
	}

	public function actionManymanyview($id) {
		$this->breadcrumbs=array(
			'Basic Relations' => array('basicrelations/index'),
			'Many Many' => array('basicrelations/manymanyindex'),
		);

		$basic_relations_many_many_model=BasicRelationsManyMany::model()->findByPk ($id);
		if (empty ($basic_relations_many_many_model))
			throw new CHttpException (404, "View: Unable to find the ID {$id} for BasicRelationsManyMany");

		$this->breadcrumbs[]=$basic_relations_many_many_model->id;

		$this->render('many_many/view', array('basic_relations_many_many_model' => $basic_relations_many_many_model));
	}

}
