    if (possibleFlg == 1) {
	    // pagination処理
	    var page = 2;
	    var loadFlg = false;
	    $(window).on('scroll', function () {
	        var doch = $(document).innerHeight(); //ページ全体の高さ
	        var winh = $(window).innerHeight(); //ウィンドウの高さ
	        var footerh = $("footer").innerHeight();
	        var bottom = doch - winh - footerh; //ページ全体の高さ - ウィンドウの高さ = ページの最下部位置
	        //一番下までスクロールした時に実行
	        if (bottom <= $(window).scrollTop() && loadFlg == false) {
	            // ローディング表示
	            $("#loading").show();
	            
	            // ロード開始
	            loadFlg = true;
	            // contentsをajaxでロード

	            var url = '/moreTextOdaiList';
	            if (pageType == 1) {
	            	url = '/moreImgOdaiList';
	            }
	            $.ajax({
	                url: url,
	                type: 'GET',
	                data: {
	                    p: page,
	                },
	                timeout: 5000,
	            })
	            .done(function(data) {
	                // ローディング消去
	                $("#loading").hide();
	                // 通信成功時の処理を記述
	                console.log("done");
	                if (pageType == 0) {
		                $(".text_odai_list").append(data);
	                }else{
		                $(".img_odai_list").append(data);
	                }
	                page++;
	                loadFlg = false;
	            })
	            .fail(function(e) {
	                // 通信失敗時の処理を記述
	                console.log("fail");
	                console.log(e);
	                $("#loading").hide();
	                // TODO リロード処理
	            });
	        }
	    });
    }
