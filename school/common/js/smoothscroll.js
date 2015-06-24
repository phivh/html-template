(function($) {
	$(document).ready(function() {
		$(".pageTop a").click(function() {
			$("html, body").animate({ scrollTop : 0 });
			return false;
		});
		
		$(".group p a").click(function() {
			$("html, body").animate({ scrollTop : 320 });
			return false;
		});
		
		$('a[href^=#]').click(function(e) {
			var anchorLink = $(this).attr('href')+"Link";
			if (anchorLink != '#Link') {
				var offTop = $(anchorLink).offset().top;
				$('body, html').stop().animate({scrollTop:offTop}, 500);
			}
			return false;
		});
		$(".hover").hover(function() {
			$(this).stop().fadeTo("fast", 0.6);
		},function(){
			$(this).stop().fadeTo("fast", 1.0);
		});
		
		$(window).load(function(e) {
			var myhash = location.hash+'Link';
			if (myhash != "Link")
			{
				var offTop = $(myhash).offset().top;
				$('body, html').stop().animate({scrollTop:offTop}, 500);
			}
		});
		
	});
})(jQuery);