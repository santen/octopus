<?php

class ImageController extends Controller
{
	public function actionMain()
	{
		$this->render('main');
	}

	public function actionUpload(){
		$picture = $_FILES["picture"];

		$extension = $this->getExtension($picture["name"]);
		$path = "pictures/";
		$image = new CUploadedFile($picture, $picture["tmp_name"], "image/".$extension, $picture["size"], 0);
		$image->saveAs($path);

		$response = array();
		$id = $this->save($path);
		array_push($response, $id);		
			$this->renderPartial("uploaded", array("response" => json_encode($response)));
	}

	//@param size = xs||sm||md||lg default value is original
	public function actionGetLink($pid, $size){

		switch(strtolower($size)){
			case "xs":
				$image = $this->getPicture($pid, "xs");
				break;
			case "sm":
				$image = $this->getPicture($pid, "sm");
				break;
			case "md":
				$image = $this->getPicture($pid, "md");
				break;
			case "lg":
				$image = $this->getPicture($pid, "lg");
				break;
			default:
				$image = $this->getOrigin($pid);
		}

		$this->renderPartial("getlink", array("picture" => json_encode($image)));
	}

	public function actionConfirmed($pid){
		$query = $this->connect();

		$result = $query->update("image", array("is_temp" => 0), "id=:id", array(":id" => $pid));

		if($result == 1){
			$this->toResizeQueue($pid);
			renderPartial("picture", array("act" => "upd", "res" => true));
		}
		else
			renderPartial("picture", array("act" => "upd", "res" => false));
	}

	public function actionGenerate(){
		return 1;
	}

	private function newPartition(){
		$folderName = uniqid();

		$sql = "insert into partitions (fname, cdate) values (:fname, now())";
		$query = $this->connect($sql);
		$query->bindParam(":fname", $folderName);
		$query->execute();
		
		mkdir(Yii::app()->request->baseUrl."/images/".$folderName);

		return $folderName;
	}

	private function getPartition($date){
		$query = $this->connect();

		$query->select("fname");
		$query->from("partitions");
		$query->where("cdate = :date", array(":date" => $date));
		$partition = $query->queryRow();

		return $partition["fname"];
	}

	private function toResizeQueue($pid){
		$sql = "insert into resize_queue (image_id, cdate) values(:pid, now())";

		$query = $this->connect();
		$query->bindParam(":pid", $pid);
		return $query->execute();
	}

	private function getOrigin($pid){
		$query = $this->connect();

		$query->select("origin");
		$query->from("image");
		$query->where("id = :id", array(":id" => $pid));

		return $query->queryRow();
	}

	private function getPicture($pid, $size){
		$query = $this->connect();

		$query->select($size);
		$query->from("size");
		$query->where("image_id = :id", array(":id" => $pid));

		return $query->queryRow();
	}

	private function connect($command = ""){
		if(count($command) == 0)
			return Yii::app()->dbimage->createCommand();
		else
			return Yii::app()->dbimage->createCommand($command);
	}

	private function getLastUID(){
		return Yii::app()->dbimage->getLastInsertID();
	}

	private function save($path){
		$sql = "insert into image () values()";

		return false;
	}

	private function getExtension($filename){
		$extension = explode(".", $filename)[1];

		return $extension;
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