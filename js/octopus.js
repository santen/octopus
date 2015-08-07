$(document).ready(function(){	
    //$(".community-bar").perfectScrollbar();	

    var communitiesBtn = {
			top: $("#communities-btn").offset().top,
			left: $("#communities-btn").offset().left
		};

	$(".community-caret").click(function(){
		communitiesBtn.top = $("#communities-btn").offset().top;
		communitiesBtn.left = $("#communities-btn").offset().left;

		$(".back-layout").css("top", communitiesBtn.top - 2 + "px");
		$("#communities-panel").css("top", communitiesBtn.top - 2 + "px");
		$("#communities-panel").css("left", communitiesBtn.left + "px");
		$("#communities-panel").show();

		console.log("top = " + communitiesBtn.top);
		console.log("left = " + communitiesBtn.left);

		$(".back-layout").show();
	});

	$(".back-layout").mouseover(function(){
		$(".back-layout").hide();
		$("#communities-panel").hide();
	});

	$("#signinBtn").click(function(){
		$("#authWindow").show();
	});

	$("#signinTab").click(function(){
		$("#signinTab").switchClass("tab", "tab-active");
		$("#signupTab").switchClass("tab-active", "tab");

		$("#signUpForm").hide();
		$("#signInForm").show();
	});

	$("#signupTab").click(function(){
		$("#signinTab").switchClass("tab-active", "tab");
		$("#signupTab").switchClass("tab", "tab-active");

		$("#signUpForm").show();
		$("#signInForm").hide();
	});

	$("#enterBtn").click(function(){
		var usr = {
			email: $("#email").val(),
			pass: $("#pass").val(),
			avatar: "",
			rating: 124.03,
			name: "sh2kerr"
		};

		$("#authWindow").hide();		
		
		$.ajax({
			type: "POST",
			url: "index.php?r=/profile/signin",
			data: "jUsr=" + JSON.stringify(usr),
			success: function(response){
				var res = JSON.parse(response);
				if(res.token != 0)
					userBlockBuild(res);
			}
		});
	});

	$("#regBtn").click(function(){
		var usr = {
			email: $("#emailr").val(),
			pass: $("#passr").val(),
			retype: $("#retype").val(),
			page: ""
		};

		console.log(JSON.stringify(usr));

		$.ajax({
			type: "POST",
			url: "index.php?r=/profile/new",
			data: "jUsr="+ JSON.stringify(usr),
			success: function(response){
				var res = JSON.parse(response);
				usr.page = res.path;
			}/*,
			complete: function(){
				if(usr.page.length > 0)
					window.location.replace(usr.page);
			}*/
		});
	});

	function userBlockBuild(usr){
		$(".user-block").children().remove();

		$(".user-block").append("<div class='avatar-wrap'></div>");
		$(".avatar-wrap").append("<img class='avatar-xs' src='"+ usr.avatar +"'>");
		$(".user-block").append("<div class='user-name'>"+ usr.name +"</div>");
		$(".user-name").append("<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'></a>");
		$(".dropdown-toggle").append("<span class='caret'></span>");
		$(".user-block").append("<div class='user-rating'>&nbsp;"+ usr.rating +"&nbsp;</div>");
	}
});