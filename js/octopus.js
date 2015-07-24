$(document).ready(function(){	
    $(".community-bar").perfectScrollbar();	

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
});