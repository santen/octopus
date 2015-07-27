<?php

class ProfileController extends Controller
{
	public $layout = "account";

	public function actionMain()
	{
		$route = Yii::app()->createController("octopus/getnumber");
		$num = $route[0]->getnumber();

		$this->render('main', array("num" => $num));
	}

	/*public function actionLogin(){
		//$layout = "land";
		//$this->render("login");
	}

	public function actionLogin($person){
		//$user = json_decode($person);
	}

	public function actionLogout($pid){

	}*/

	public function actionGet($user){
		$user = json_decode($user);
		$account = json_encode($this->get($user["uid"]));

		$this->renderPartial("profile", array("account" => $account, "act" => "get"));
	}

	public function actionNew($user){
		$query = $this->connect();

		$route = Yii::app()->createController("octopus/main");
		$imageRoute = $route[0]->getRoute("picture");

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
		$this->delete($user["uid"]);


	}

	public function actionChangeMind($uid, $val){
		$result = $this->save($uid, "mind", $val);

		if($result == 1)
			$this->renderPartial("profile", array("val" => true, "act" => "upd"));
		else
			$this->renderPartial("profile", array("val" => false, "act" => "upd"));
	}

	public function actionChangeAvatar($uid, $val){
		$result = $this->save($uid, "avatar_id", $val);

		if($result == 1)
			$this->renderPartial("profile", array("val" => true, "act" => "upd"));
		else
			$this->renderPartial("profile", array("val" => false, "act" => "upd"));
	}

	public function actionChangePasswd($uid, $pass1, $pass2){
		$result = 0;

		if(strcmp($pass1, $pass2))
			$result = $this->save($uid, "pass", md5($pass2));

		if($result == 1)
			$this->renderPartial("profile", array("val" => true, "act" => "upd"));
		else
			$this->renderPartial("profile", array("val" => false, "act" => "upd"));
	}

	//show brief account data for the forum, for example
	public function actionBrief($users){
		//get avatar, nick, common rating, mind
		$route = Yii::app()->createController("octopus/getroute");
		$picService = $route[0]->getroute("pictures");

		$route = Yii::app()->createController($picService."/getlink");
		$profiles = array();
		for($i = 0; $i < count($users); $i++){
			array_push($profiles, $this->getBrief($user["uid"]));
			
			$image = $route[0]->getLink($profiles[$i]["avatar_id"], "xs");
			array_push($profiles[$i], array("avatar" => $image));
		}

		$this->renderPartial("profilelist", array("profiles" => $profiles));
	}

	private function save($uid, $field, $val){
		$query = $this->connect();

		return $query->update("profile", array($field => $val), "id=:id", array(":id" => $uid));
	}

	private function delete($uid){
		$query = $this->connect();

		return $query->update("profile", array("removed" => 1), "id=:id", array(":id" => $uid));
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
		$query = $this->connect();

		$query->select("id, nickname, avatar_id, mind");
		$query->from("profile");
		$query->where("id = :id", array(":id" => $uid));

		return $query->queryRow();
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