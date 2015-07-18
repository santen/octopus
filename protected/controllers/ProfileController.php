<?php

class ProfileController extends Controller
{
	public function actionMain()
	{
		$this->render('main');
	}

	public function actionGet($user){
		$query = Yii::app()->dbtoken->createCommand();

		$query = Yii::app()->dbprofile->createCommand();

		$query->select("*");
		$query->from("profile");
		$query->where("id = :uid"), array("uid" => $user["uid"]);

		$account = $query->queryRow();
		$this->renderPartial("profile", array("account" => $account, "act" => "get"));
	}

	public function actionNew(){

	}

	public function actionRemove($user){

	}

	public function actionUpdate($user){

	}

	private function save($user){

	}

	private function delete($id){

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