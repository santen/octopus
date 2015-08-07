<div class="user-block">
	<?php 
		if(count($user) > 0){
			echo "<div class='avatar-wrap'>";
			//echo "<div class='avatar-xs'>";
			echo "<img class='avatar-xs' src='".$user["avatar"]."'>";
			echo "</div>";
			echo "<div class='user-name'>";
			echo $user["nick"];
			echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>";
			echo "<span class='caret'></span>";
			echo "</a></div></div>";
			echo "<div class='user-rating'>";
			echo "&nbsp;".$user["rating"]."&nbsp;";
		}
		else
			echo "<button type='button' class='btn btn-default' id='signinBtn'>Войти</button>";
	?>
</div>