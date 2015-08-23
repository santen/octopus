var usr = {
			email: "",
			pass: "",
			retype: "",
			page: "",
			avatar: "",
			rating: "",
			name: ""}

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
		window.usr.email = $("#email").val();
		window.usr.pass = $("#pass").val();
		window.usr.avatar = "";
		window.usr.rating = 124.03;
		window.usr.name = "sh2kerr";

		$("#authWindow").hide();		
		
		$.ajax({
			type: "POST",
			url: "index.php?r=/profile/signin",
			data: "jUsr=" + JSON.stringify(window.usr),
			success: function(response){
				var res = JSON.parse(response);
				if(res.token != 0)
					userBlockBuild(res);
			}
		});
	});

	$("#regBtn").click(function(){
		console.log(JSON.stringify(window.usr));

		window.usr.email = $("#emailr").val();
		window.usr.pass = $("#passr").val();
		window.usr.retype = $("#retype").val();

		$.ajax({
			type: "POST",
			url: "index.php?r=/profile/new",
			data: "jUsr="+ JSON.stringify(window.usr),
			success: function(response){
				var res = JSON.parse(response);
				window.usr.page = res.path;
				window.location.href = "index.php?r=" + window.usr.page;
			}
		});
	});

	function userBlockBuild(usr){
		/*$(".user-block").children().remove();

		$(".user-block").append("<div class='avatar-wrap'></div>");
		$(".avatar-wrap").append("<img class='avatar-xs' src='"+ usr.avatar +"'>");
		$(".user-block").append("<div class='user-name'>"+ usr.name +"</div>");
		$(".user-name").append("<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'></a>");
		$(".dropdown-toggle").append("<span class='caret'></span>");
		$(".user-block").append("<div class='user-rating'>&nbsp;"+ usr.rating +"&nbsp;</div>");*/
	}

	$("#uplAvatarBtn").click(function(){
		$("#uplAvatarFile").click();
	});

	$("#uplAvatarFile").change(function(){
		var fdAvatar = new FormData();
		fdAvatar.append("image", $("#uplAvatarFile")[0].files[0]);

		$.ajax({
			type: "POST",
			url: "index.php?r=/image/upload",
			processData: false,
			contentType: false,
			data: fdAvatar,
			success: function(response){
				res = JSON.parse(response);
				$("#avatarImg").attr("src", "/octopus/"+res.link);
			}			
		});
	});
});