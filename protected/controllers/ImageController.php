<?php

class ImageController extends Controller
{
	public function actionMain()
	{
		$this->render('main');
	}

	public function actionUpload(){
		$curDate = date_format(date_create(), "Y-m-d");
		if($this->partitionExists($curDate))
			$path = "images/".$this->getPartition($curDate)."/";
		else
			$path = "images/".$this->newPartition()."/";

		

		$picture = $_FILES["image"];

		$extension = $this->getExtension($picture["name"]);
		$fullPath = $path.explode("/", $picture["tmp_name"])[2].".".$extension;
		$image = new CUploadedFile($picture, $picture["tmp_name"], "image/".$extension, $picture["size"], 0);
		$image->saveAs($fullPath);
		$imageSize = getimagesize($fullPath);
		
		$figure = array();
		$figure = array_merge($figure, array("origin" => $fullPath));
		$figure = array_merge($figure, array("width" => $imageSize[0]));
		$figure = array_merge($figure, array("height" => $imageSize[1]));
		$id = $this->newPicture($figure);

		$response = array();
		$response = array_merge($response, array("pid" => $id, "link" => $fullPath));

		$this->toResizeQueue($id);

		$this->renderPartial("uploaded", array("response" => json_encode($response)));
	}

	//@param size = xs||sm||md||lg default value is original
	public function actionGetLink($pid, $size = ""){

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
		return $image;
		$this->renderPartial("getlink", array("picture" => $image));
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

	private function newPicture($picture){
		$sql = "insert into image(origin, cdate, is_default, width, height)
				values (:origin, now(), 0, :width, :height)";
		$query = $this->connect($sql);
		$query->bindParam(":origin", $picture["origin"]);
		$query->bindParam(":width", $picture["width"]);
		$query->bindParam(":height", $picture["height"]);
		$query->execute();

		return $this->getLastPID();
	}

	//private
	public function newPartition(){
		$folderName = uniqid();

		$sql = "insert into partitions (fname, cdate) values (:fname, now())";
		$query = $this->connect($sql);
		$query->bindParam(":fname", $folderName);
		$query->execute();
		$query->reset();		
		
		$path = "/home/st3rax/web/octopus/images/".$folderName;
		mkdir($path, 0777);

		return $folderName;
	}

	//private
	public function getPartition($date){
		$query = $this->connect();

		$query->select("fname");
		$query->from("partitions");
		$query->where("cdate > :date", array(":date" => $date));
		$partition = $query->queryRow();

		return $partition["fname"];
	}

	//private
	public function partitionExists($date){
		$query = $this->connect();

		$query->select("count(fname) as partitions");
		$query->from("partitions");
		$query->where("cdate > :date", array(":date" => $date));
		$partitions = $query->queryRow();

		if($partitions["partitions"] != 0)
			return true;
		else
			return false;
	}

	private function toResizeQueue($pid){
		$sql = "insert into resize_queue (image_id, cdate) values(:pid, now())";

		$query = $this->connect($sql);
		$query->bindParam(":pid", $pid);

		return $query->execute();
	}

	private function getOrigin($pid){
		$query = $this->connect();

		$query->select("origin");
		$query->from("image");
		$query->where("id = :id", array(":id" => $pid));

		return $query->queryRow()["origin"];
	}

	private function getPicture($pid, $size){
		$query = $this->connect();

		$query->select($size);
		$query->from("size");
		$query->where("image_id = :id", array(":id" => $pid));

		return $query->queryRow();
	}

	private function getExtension($filename){
		$extension = explode(".", $filename)[1];

		return $extension;
	}

	private function connect($command = ""){
		if(count($command) == 0)
			return Yii::app()->dbimage->createCommand();
		else
			return Yii::app()->dbimage->createCommand($command);
	}

	private function getLastPID(){
		return Yii::app()->dbimage->getLastInsertID();
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