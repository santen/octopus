<?php
define("FULLPATH", "/home/st3rax/web/octopus/images/");
define("MAX_FILE", "6");
define("AV_XS", "30");
define("AV_SM", "32");
define("AV_MD", "40");
define("AV_LG", "70");
define("AV_XLG", "200");
define("P_LG", "1100");
define("P_MD", "537");
define("P_SM", "355");
define("P_VIEW", "800");

class ImageController extends Controller
{	
	$fileinfo = array();
	$multiFile = array();

	private function init(){
		$this->fileinfo = array_merge($this->fileinfo, array("partition" => ""));
		$this->fileinfo = array_merge($this->fileinfo, array("file" => ""));
		$this->fileinfo = array_merge($this->fileinfo, array("mime" => ""));
		$this->fileinfo = array_merge($this->fileinfo, array("fullpath" => ""));
		$this->fileinfo = array_merge($this->fileinfo, array("width" => ""));
		$this->fileinfo = array_merge($this->fileinfo, array("height" => ""));
		$this->fileinfo = array_merge($this->fileinfo, array("pid" => ""));
		$this->fileinfo = array_merge($this->fileinfo, array("link" => ""));
	}

	public function actionMain()
	{
		$this->render('main');
	}

	public function actionUpload(){
		$this->init();

		$curDate = date_format(date_create(), "Y-m-d");
		if($this->partitionExists($curDate))
			$path = "images/".$this->getPartition($curDate)."/";
		else
			$path = "images/".$this->newPartition()."/";
		
		$this->fileinfo["partition"] = $this->getPartition($curDate);

		$picture = $_FILES["image"];
		
		$this->fileinfo["mime"] = $this->getExtension($picture["name"]);
		$file = explode("/", $picture["tmp_name"])[2].".".$this->fileinfo["mime"]; //example: php39Jokl.png
		$this->fileinfo["file"] = $file;

		$this->fileinfo["fullpath"] = $path.$this->fileinfo["file"];

		$image = new CUploadedFile($picture, $picture["tmp_name"], "image/".$this->fileinfo["mime"], $picture["size"], 0);
		$image->saveAs($this->fileinfo["fullpath"]);
		$imageSize = getimagesize($fileinfo["fullpath"]);
		$this->fileinfo["width"] = $imageSize[0];
		$this->fileinfo["height"] = $imageSize[1];		
		
		$this->fileinfo["pid"] = $this->newPicture();

		$response = array();
		$response = array_merge($response, array("pid" => $this->fileinfo["pid"], "link" => $this->fileinfo["link"]));
		
		$this->renderPartial("uploaded", array("response" => json_encode($response)));
	}

	public function actionMultiUpload(){
		init();
		array_push($this->multiFile, $this->fileinfo);

		$curDate = date_format(date_create(), "Y-m-d");
		if($this->partitionExists($curDate))
			$partition = $this->getPartition($curDate);
		else
			$partition = $this->newPartition();

		$path = "images/".$partition."/";
		for($i = 0; $i < MAX_FILE; $i++){
			array_push($this->multiFile, $this->fileinfo);
			$this->multiFile[$i]["partition"] = $partition;

			$picture = $_FILES["images"][$i];
			$this->multiFile[$i]["mime"] = $this->getExtension($picture["name"]);
			$file = explode("/", $picture["tmp_name"])[2].".".$this->multiFile[$i]["mime"]; //example: php39Jokl.png
			$this->multiFile[$i]["file"] = $file;

			$this->multiFile[$i]["fullpath"] = $path.$this->multiFile[$i]["file"];

			$image = new CUploadedFile($picture, $picture["tmp_name"], "image/".$this->multiFile[$i]["mime"], $picture["size"], 0);
			$image->saveAs($this->multiFile[$i]["fullpath"]);
			$imageSize = getimagesize($this->multiFile[$i]["fullpath"]);
			$this->multiFile[$i]["width"] = $imageSize[0];
			$this->multiFile[$i]["height"] = $imageSize[$i];

			$this->multiFile[$i]["pid"] = $this->newPicture($multiFile[$i]);

			$response = array();
			array_push($response, array("pid" => $this->multiFile[$i]["pid"], "link" => $this->multiFile[$i]["link"]));
		}

		$this->resizeAll();

		$this->renderPartial("uploaded", array("response" => json_encode($response)));
	}

	//@param size = xs||sm||md||lg default value is original
	public function actionGetLink($pid, $origin = 0){
		if($origin == 0)
			$link = $this->getPicture($pid);
		else
			$link = $this->getOrigin($pid);

		return $link;
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

	public function actionResizing(){
		$query = $this->connect();
		$query->select("origin, width, height, cdate, fname as partition");
		$query->from("resize_queue rq");
		$query->join("image", "rq.image_id = image.id");
		$query->join("partitions ps", "image.partition_id = ps.id");
		$images = $query->queryAll();

		for($i = 0; $i < count($images); $i++){
			$path = $images[$i]["partition"]."/".$images[$i]["origin"];
			$this->resize($images[$i]);
		}
	}

	public function actionSaveArea($jArea){
		$area = json_decode($jArea, true);


	}

	private function resizePrepare($count){
		if($count == 1)
			return P_LG;
		elseif($count == 2)
			return P_MD;
		elseif($count >=3)
			return P_SM;
	}

	public function resize($newSize){
		$image = new Imagick($fileinfo["fullpath"]);

		if($this->fileinfo["width"] > P_MD){
			$this->getScaledSize(P_SM, $scaledSize);
			$image->resizeImage($scaledSize["height"], $scaledSize["width"], imagick::FILTER_GAUSSIAN, 1); // do sm
			$scaledSize = $this->getScaledSize(P_MD, $scaledSize);
			$image->resizeImage($scaledSize["height"], $scaledSize["width"], imagick::FILTER_GAUSSIAN, 1); // do xs
		}
		else{
			$scaledSize = $this->getScaledSize($picture["width"], $picture["height"], "xs");
			$image->resizeImage($scaledSize["height"], $scaledSize["width"], imagick::FILTER_GAUSSIAN, 1); // do xs
		}

		if($picture["height"] > MD_H){
			$scaledSize = $this->getScaledSize($picture["width"], $picture["height"], "md");
			$image->resizeImage($scaledSize["height"], $scaledSize["width"], imagick::FILTER_GAUSSIAN, 1); // do md
		}
	}

	private function cropSq($filename, $x, $y, $size){
		$image = imagecreatetruecolor(LIST, LIST);
		$srcImage = $this->imageFromFile($filename["fullpath"]);

		if(imagecopyresampled($image, $srcImage, 0, 0, $x, $y, 70, 70, $size, $size)){
			return $this->saveAs($filename["path"], $image, $this->getExtension($filename));
		}

		return null;
	}

	private function resizeAll(){
		$count = count($this->multiFile);
		$size = $this->resizePrepare($count);
		$done = array();

		for($i = 0; $i < $count; $i++){
			$tmpName = tempnam(FULLPATH.$this->multiFile[$i]["partition"]."/").".".$this->multiFile[$i]["mime"];
			if(copy($this->multiFile[$i]["fullpath"], $tmpName)){
				$image = new Imagick($tmpName);
				$this->getScaledSize($size, $scaledSize, $this->multiFile[$i]);
				$image->resizeImage($scaledSize["height"], $scaledSize["width"], imagick::FILTER_GAUSSIAN, 1);

				array_push($done, 1);
			}
			else
				array_push($done, 0);
		}

		return $done;
	}

	private function crop($filename, $area){
		$image = imagecreatetruecolor($area["width"], $area["height"]);
		$srcImage = $this->imageFromFile($filename["fullpath"]);

		if(imagecopyresampled($image, $srcImage, 0, 0, 
							  $area["x"], $area["y"], 
							  $area["width"], $area["height"], 
							  $area["width"], $area["height"])){

			return $this->saveAs($filename["path"], $image, $this->getExtension($filename));
		}

		return null;
	}

	private function getRatio($pathToImg){
		$size = getimagesize($pathToImg);
		$ratio = $size[0] / $size[1];

		return $ratio;
	}

	private function getScaledSize($size, $scaledSize, $fileinfo){
		$scaledSize = array();
		$scaledSize = array_merge($scaledSize, array("width" => 0));
		$scaledSize = array_merge($scaledSize, array("height" => 0));

		switch($size){			
			case AV_XLG:
				$ratio = AV_XLG / ($fileinfo["width"] / 100);
				$scaledSize["width"] = $fileinfo["width"] * $ratio;
				$scaledSize["height"] = $fileinfo["height"] * $ratio;
				break;
			case P_SM:
				$ratio = P_SM / ($fileinfo["width"] / 100);
				$scaledSize["width"] = $fileinfo["width"] * $ratio;
				$scaledSize["height"] = $fileinfo["height"] * $ratio;
				break;
			case P_MD:
				$ratio = P_MD / ($fileinfo["width"] / 100);
				$scaledSize["width"] = $fileinfo["width"] * $ratio;
				$scaledSize["height"] = $fileinfo["height"] * $ratio;
				break;
			case P_LG:
				$ratio = P_LG / ($fileinfo["width"] / 100);
				$scaledSize["width"] = $fileinfo["width"] * $ratio;
				$scaledSize["height"] = $fileinfo["height"] * $ratio;
				break;
			case P_VIEW:
				$ratio = P_VIEW / ($fileinfo["height"] / 100);
				$scaledSize["width"] = $fileinfo["width"] * $ratio;
				$scaledSize["height"] = $fileinfo["height"] * $ratio;
				break;
		}

		return $scaledSize;
	}

	private function imageFromFile($filename){
		$extension = $this->getExtension($filename);

		switch($extension){
			case "png":
				return imagecreatefrompng($filename);
			case "jpg":
			case "jpeg":
				return imagecreatefromjpeg($filename);
			case "gif":
				return imagecreatefromgif($filename);
		}
	}

	private function saveAs($path, $imageSrc, $ext){
		$filename = tempnam($path).".".$ext;		
		$saved = false;		

		switch($ext){
			case "png":
				$saved = imagepng($imageSrc, $filename);
				break;
			case "jpg":
			case "jpeg":
				$saved = imagejpeg($imageSrc, $filename);
				break;
			case "gif":
				$saved = imagegif($imageSrc, $filename);
				break;
		}

		if($saved)
			return $filename;
		else
			return null;
	}

	private function getFilename($path){
		$pathExploded = explode("/", $path);
		$pathLen = count($pathExploded);
		$filename = $path[$pathLen - 1];

		return $filename;
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

		return strtolower($extension);
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