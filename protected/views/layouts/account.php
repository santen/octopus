<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css?3242">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/account.css?3242">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/settings.css?320">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/toptoolbar.css?9320">	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/lefttoolbar.css?909">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/lib/bootstrap-3.3.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/lib/jQuery/jquery-2.1.3.min.js" language="JavaScript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/lib/bootstrap-3.3.2/js/bootstrap.min.js" language="JavaScript"></script>		
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/octopus.js" language="JavaScript"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div class="back-layout"></div>
	<div class="cor-container">
		<div id="top-toolbar">
			<div class="logo-block">
				<img src="http://fakeimg.pl/120x40/00CED1/FFF/?text=coral+logo">
			</div>
			<div class="search-block">
				<div class="input-group input-group-sm">
					<input type="text" class="form-control control-sm" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
					</span>
				</div>
			</div>
			<div class="buttons-block">
				<button type="button" class="btn btn-success" aria-label="Left Align">
					<span class="glyphicon glyphicon-random" aria-hidden="true"></span>
				</button>
			</div>
			<div class="user-block">
				<div class="avatar-wrap">
					<div class="avatar-xs">
						<img src="http://fakeimg.pl/40x40/00CED1/FFF/?text=aVa">
					</div>
				</div>
				<div class="user-name">
					st3rax
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">					
						<span class="caret"></span>
					</a>
				</div>
			</div>
			<div class="user-rating">
				&nbsp;1848.49&nbsp;
			</div>
		</div>
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