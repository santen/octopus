<?php

class UserBlockWidget extends CWidget
{
	public function init()
	{
		
	}
 
	public function run()
	{
		$state = false;		
		$jUser = array();
		$user = array();

		/*if(isset($_COOKIE["octo"])){			
			$octopus = json_parse($_COOKIE["octo"]);

			array_push($jUser, array("uid" => $octopus["uid"]));
			array_push($jUser, array("hash" => $octopus["hash"]));
			array_push($jUser, array("email" => $octopus["soap"]));

			$profile = Yii::app()->createController("profile/signin");
			$state = $profile[0]->signin(json_encode($jUser));

			if($state){
				$account = json_decode($profile[0]->get($jUser["uid"]));
				
				array_push($user, array("uid" => $account["uid"]));
				array_push($user, array("avatar" => $account["avatar"]));
				array_push($user, array("nick" => $account["nick"]));
				array_push($user, array("rating" => "12.03"));
			}
		}*/

		$this->render('userblock', array('user' => $user));
	}
}

?>