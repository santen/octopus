<?php

class ToptoolbarWidget extends CWidget
{
	public function init()
	{
		
	}
 
	public function run()
	{
		$state = false;
		$user = array();

		if(isset($_COOKIE["octo"])){
			$octopus = json_parse($_COOKIE["octo"]);

			$uid = $octopus["uid"];			
			$token = Yii::app()->createController("token/getstate");
			$state = $token[0]->getstate($uid);

			if($state){
				array_push($user, array("avatar" => $profile[0]->getavatar($uid)));
				array_push($user, array("nick" => $profile[0]->getnick($uid)));
				array_push($user, array("rating" => "12.03"));
			}
		}

		$this->render('toptoolbar', array('user' => $user));
	}
}

?>