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
				<?php echo "<img src='".$user["avatar"]."'>"; ?>
			</div>
		</div>
		<div class="user-name">
			<?php echo $user["nick"]; ?>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">					
				<span class="caret"></span>
			</a>
		</div>
	</div>
	<div class="user-rating">
		&nbsp;<?php echo $user["rating"]; ?>&nbsp;
	</div>
</div>