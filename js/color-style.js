(function($){
	"use strict";
	$(document).ready(function () {
		color.init();
	});
	var color = {
		init: function () {
			$("#color-styles h2 a").click(function(e){
				e.preventDefault();
				var div = $("#color-styles");
				console.log(div.css("right"));
				if (div.css("right") === "-140px") {
					$("#color-styles").animate({
						right: "0px"
					}); 
				} else {
					$("#color-styles").animate({
						right: "0px"
					});
				}
			})
			$(".colors li a").click(function(e){
				e.preventDefault();
				var color = $(this).attr('class');
				color = color.replace('active', '').trim();
				$("#template-color" ).attr("href", "css/acme-color-" + color + ".css" );
				$(this).parent().parent().find("a").removeClass("active");
				$(this).addClass("active");
			})
		}
	}
})(jQuery);
(function($){
	"use strict";
	$(document).ready(function () {
		color.init();
	});
	var color = {
		init: function () {
			$("#color-styles h2 a").click(function(e){
				e.preventDefault();
				var div = $("#color-styles");
				//console.log(div.css("left"));
				if (div.css("right") === "-140px") {
					$("#color-styles").animate({
						right: "0"
					}); 
				} else {
					$("#color-styles").animate({
						right: "-140px"
					});
				}
			})
			$(".layout li a").click(function(e){
				e.preventDefault();
				var color = $(this).attr('class');
				color = color.replace('active', '').trim();
				$("#template-layout" ).attr("href", "css/corpon-" + color + ".css" );
				$(this).parent().parent().find("a").removeClass("active");
				$(this).addClass("active");
			})
		}
	}
})
(jQuery);