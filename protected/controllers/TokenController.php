<?php

class TokenController extends Controller
{
	public function actionMain()
	{
		$this->render('main');
	}

	public function actionGetState($uid){
		$query = $this->connect();

		$query->select("*");
		$query->from("token");
		$query->where("uid = :id", array(":id" => $uid));

		$state = $query->queryRow();

		$this->renderPartial("getstate", array("state" => $state));
	}

	private function connect(){
		return Yii::app()->dbtoken->createCommand();
	}

	private function getLastUID(){
		return Yii::app()->dbtoken->getLastInsertID();
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}