<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css?3242">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/account.css?3242">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/bootstrap-3.3.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/lib/jQuery/jquery-2.1.3.min.js" language="JavaScript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/lib/bootstrap-3.3.2/js/bootstrap.min.js" language="JavaScript"></script>		
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/octopus.js" language="JavaScript"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div class="back-layout"></div>
	<div class="cor-container">
		<?php $this->widget('application.extensions.widgets.ToptoolbarWidget'); ?>
		<div id="left-toolbar">
			<div class="left-btn" id="home-btn">
			</div>
			<div class="left-btn" id="dialog-btn">
			</div>
			<div class="left-btn active" id="favorite-btn">		
			</div>
			<div class="left-btn" id="comment-btn">
			</div>
			<div class="left-btn" id="notify-btn">
			</div>
			<div class="left-btn" id="communities-btn">
				<div class="community-caret"></div>
				<div class="back-layout">
					<div id="communities-panel">
						<div class="community-wrap">
							<div class="avatar-sm">
								<img src="http://fakeimg.pl/70x70/00CED1/FFF/?text=robots" class="avatar-rounded">
							</div>
						</div>
						<div class="community-wrap">
							<div class="avatar-sm">
								<img src="http://fakeimg.pl/70x70/00CED1/FFF/?text=robots" class="avatar-rounded">
							</div>
						</div>
						<div class="community-wrap">
							<div class="avatar-sm">
								<img src="http://fakeimg.pl/70x70/00CED1/FFF/?text=robots" class="avatar-rounded">
							</div>
						</div>
						<div class="community-wrap">
							<div class="avatar-sm">
								<img src="http://fakeimg.pl/70x70/00CED1/FFF/?text=robots" class="avatar-rounded">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="left-btn" id="write-btn">
			</div>
		</div>
	
		<div class="profile-page">
			<?php echo $content; ?>
		</div>
	
	</div>
</body>
</head>