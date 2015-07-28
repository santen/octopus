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