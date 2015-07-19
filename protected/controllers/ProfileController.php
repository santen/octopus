<?php

class ProfileController extends Controller
{
	public function actionMain()
	{
		$route = Yii::app()->createController("octopus/getnumber");
		$num = $route[0]->getnumber();
		$this->render('main', array("num" => $num));
	}

	public function actionGet($user){
		$user = json_decode($user);
		$account = json_encode($this->get($user["uid"]));

		$this->renderPartial("profile", array("account" => $account, "act" => "get"));
	}

	public function actionNew($user){
		$query = $this->connect();

		$route = Yii::app()->createController("octopus/main");
		$imageRoute = $route[0]->getRoute("image");

		$image = Yii::app()->createController($imageRoute."/generate");
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
		$result = $this->save($user, "removed", 1);

		if($result == 1)
			$this->renderPartial("profile", array("val" => true, "act" => "upd"));
		else
			$this->renderPartial("profile", array("val" => false, "act" => "upd"));
	}

	//show brief account data for the forum, for example
	public function actionBrief($users){
		//get avatar, nick, common rating, mind

		for($i = 0, $i < count($users); $i++){

		}
	}

	private function save($uid, $field, $val){
		$query = $this->connect();

		return $query->update("profile", array($field => $val), "id=:id", array(":id" => $uid));
	}

	private function delete($uid){

	}

	private function get($uid){
		$query = $this->connect();

		$query->select("*");
		$query->from("profile");
		$query->where("id = :uid", array("uid" => $user["uid"]));

		$account = $query->queryRow();

		return $account;
	}

	private function getBrief($uid){
		
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