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

	public function actionSignIn(){
		$login = array("status" => false, "token" => 0);

		$user = json_decode($_POST["jUsr"]);

		$query = connect();
		$query->select("*");
		$query->from("profile");
		$query->where("id = :id and passwd = :pass and soap = :soap", 
					  array(":id" => $user["uid"],
					  		":pass" => $user["hash"],
					  		":soap" => $user["email"]));

		if($query->queryRow() > 0){
			$login["status"] = true;
			$login["token"] = 1;
		}

		$this->renderPartial("signin", array("signin" => json_encode($login)));
	}

	public function actionGet($uid){		
		$account = json_encode($this->get($uid));

		$image = Yii::app()->createController("image/generate");
		$avatar = $image[0]->actionGetLink($account["avatar_id"], "md");

		array_merge($account, array("avatar" => $avatar));

		$this->render("settings", array("account" => $account));
	}

	public function actionNew(){
		$user = json_decode($_POST["jUsr"], true);
		

		//$route = Yii::app()->createController("octopus/image");
		//$imageRoute = $route[0]->getRoute("picture");

		$image = Yii::app()->createController("image/generate");
		$avatar = $image[0]->actionGenerate();

		$sql = "insert into profile(soap, hashed_soap, passwd, cdate, avatar_id) values(:soap, :soap_hashed, :pass, now(), :avatar)";
		$query = $this->connect($sql);
		$query->bindParam(":soap", $user["email"]);
		$query->bindParam(":soap_hashed", md5($user["email"]));
		$query->bindParam(":pass", md5($user["pass"]));
		$query->bindParam(":avatar", $avatar);

		$query->execute();
		$uid = $this->getLastUID();

		$page = array();
		array_push("page", "profile/get/".$uid);

		$this->renderPartial("profile", json_encode($page), "act" => "get"));
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

	private function connect($command = ""){
		if(count($command) == 0)
			return Yii::app()->dbprofile->createCommand();
		else
			return Yii::app()->dbprofile->createCommand($command);
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