<?php

class OctopusController extends Controller
{
	public function actionMain()
	{
		$con = $this->connect();
		$this->render('main');
	}

	public function getRoute($name){
		$query = $this->connect();

		$query->select("*");
		$query->from("route");
		$query->where("service = :name", array("name" => name));

		return json_encode($query->queryRow());
	}

	public function getNumber(){
		return 3;
	}

	private function connect(){
		return Yii::app()->dboctopus->createCommand();
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