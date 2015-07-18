<?php

class ProfileController extends Controller
{
	public function actionMain()
	{
		$this->render('main');
	}

	public function actionGet($user){
		$user = json_decode($user);
		$account = json_encode($this->get($user["uid"]));

		$this->renderPartial("profile", array("account" => $account, "act" => "get"));
	}

	public function actionNew($user){
		$query = $this->connect();

		$image = Yii::app()->createController("image/generate");
		$avatar = $image[0]->actionGenerate();

		$sql = "insert into profile(nickname, passwd, cdate, avatar_id) values(:nick, :pass, now(), :avatar)";
		$query->bindParam(":nick", $user["nick"]);
		$query->bindParam(":pass", md5($user["pass"]));
		$query->bindParam(":avatar", $avatar["pid"]);

		$query->execute();
		$uid = $this->getLastUID();

		$account = json_encode($this->get($uid));

		$this->renderPartial("profile", array("account" => $account, "act" => "get"));
	}

	public function actionRemove($user){

	}

	public function actionUpdate($user){

	}

	//show brief account data for the forum, for example
	public function actionBrief($user){
		
	}

	private function save($user){

	}

	private function delete($uid){

	}

	private function get($uid){
		$query = $this->connect();

		$query->select("*");
		$query->from("profile");
		$query->where("id = :uid"), array("uid" => $user["uid"]);

		$account = $query->queryRow();

		return $account;
	}

	private function connect(){
		return Yii::app()->dbprofile->createCommand();
	}

	private function getLastUID(){
		return Yii::app()->dbprofile->getLastInsertID();
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