// ==============================================================
// CB-STANDARD for Smartphone
// --script.js--
// ==============================================================

(function($) {
	$(function() {
		
		// ==============================================================
		// ユーザーエージェント別の処理
		// ==============================================================
		var body = $("body");
		var userAgent = window.navigator.userAgent;
		
		// ユーザーエージェント判定 & bodyClass付与
		// iPhoneかiPodなら、.iosStyleをbodyに付与
		if ((userAgent.indexOf("iPhone") > 0) || (userAgent.indexOf("iPod") > 0)) {
			body.addClass("iosStyle");
			
			
			// ==============================================================
			// 初回表示用フローティングウインドウ jquery.cookie.js
			// ==============================================================
			if ($.cookie) {
				// iPhoneの場合のみ実行
				if (userAgent.indexOf("iPhone") > 0) {
					var homeAlert = $('aside.homeAlert');
					
					homeAlert.show();
					
					// .homeAlertをクリックで消去
					homeAlert.click(function() {
						$(this).fadeOut();
					});
					
					
					/* 確認のため常時表示-- ここから
					
					// 二回目以降のアクセス時には、bodyに.accessを付与する
					if($.cookie("access")) {
						$('body').addClass('access')
					};
					
					// アクセスキーをtrueに
					// クッキーの有効期限と有効範囲のパス、ドメインを指定
					var siteDomain = location.hostname;
					$.cookie("access", true, {
						expires	: 99999,
						path	: "/",
						domain	: siteDomain
					});
					
					-- ここまで */
					
				}
			}
			
		// Androidなら、.androidStyleをbodyに付与
		} else if (userAgent.indexOf("Android") > 0) {
			body.addClass("androidStyle");
		}
		
		
		// ==============================================================
		// スマホ用のタップ処理（PCではマウスダウン）
		// ==============================================================
		//.touchHoverをタップした際に.activeを付与し、離すと解除する
		$("a.touchHover, button.touchHover").bind("touchstart mousedown",function() {
			var touch = $(this);
			
			// 誤作動防止のため、若干タップ動作にタイムラグを与える
			timeout = setTimeout(function() {
				touch.addClass("active");
			}, 60);
			
			// タップ処理の解除
			$("body").bind("touchend mouseup",function() {
				clearTimeout(timeout);
				touch.removeClass("active");
			});
			$("body").bind("touchmove mousemove",function() {
				clearTimeout(timeout);
				touch.removeClass("active");
			});
		});
		
	
		// ==============================================================
		// ページの先頭へスクロール
		// ==============================================================
		// .pageTop aをクリックでページの先頭へ
		$(".pageTop a").click(function() {
			$("html, body").animate({ scrollTop : 0 });
			return false;
		});
		
		
		// ==============================================================
		// フェードイン・フェードアウト
		// ==============================================================
		$(".fade, .fadeNavi").click(function() {
			
			var elm = $(this);
			
			// 次の要素が非表示だった場合は、.fadeに.activeを付与+次の要素をフェードイン
			if (elm.next().is(":hidden")) {
				elm.addClass("active")
					.next()
					.fadeIn();
				
			// 次の要素が表示されていた場合は、.fadeと.activeを削除+次の要素をフェードアウト
			} else {
				elm.removeClass("active")
					.next()
					.fadeOut();
			}
		});
		// ブラウザバック時に初期化
		$(window).bind("pageshow pagehide", function() {
			$(".fade, .fadeNavi").removeClass("active").next().hide();
		});
		

		
		// ==============================================================
		// アコーディオンパネル
		// ==============================================================
		$(".accordion a").click(function() {
			
			var elm = $(this);
			
			// 開閉時の処理
			if (elm.next(".accordionBox").is(":visible")) {
				elm.removeClass("active")
					.next(".accordionBox")
					.slideUp(400);
					
			} else {
				
				// 兄弟要素の.activeを削除した後、クリックした要素に対して.activeを付与
				elm.next(".accordionBox")
					.slideDown(400)
					.siblings(".accordionBox")
					.slideUp(400)
					.siblings(".accordion a")
					.removeClass("active");
				elm.addClass("active");
			}
		});
		
		
		
		
	});
})(jQuery);