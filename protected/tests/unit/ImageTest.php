<?php

class ImageTest extends CTestCase{
	protected function setUp()
	{
		parent::setUp();
	}

	public function testNewPatition(){
		$this->setUp();

		$image = Yii::app()->createController("image/newpartition");

		$curDate = date_format(date_create(), "Y-m-d");
		$this->assertNotEquals("", $image[0]->newPartition());
	}

	public function testPartitionExists(){
		$this->setUp();

		$image = Yii::app()->createController("image/partitionexists");

		$curDate = date_format(date_create(), "Y-m-d");
		$this->assertNotEquals(0, $image[0]->partitionexists($curDate));
	}
}