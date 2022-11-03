var App = function () {
	
	function handleMsViewport() {
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
			var msViewportStyle = document.createElement('style')
			msViewportStyle.appendChild(
			  document.createTextNode(
				'@-ms-viewport{width:auto!important}'
			  )
			)
			document.querySelector('head').appendChild(msViewportStyle)
		}
	}
	function handleAndroidSelect() {
		 var nua = navigator.userAgent
		 var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
		 if (isAndroid) {
			 jQuery('select.form-control').removeClass('form-control').css('width', '100%')
		 }
	} 

	function handleBootstrap() {
		$("#owl-demo").owlCarousel(
		{
			singleItem : true,
			paginationNumbers : true,
			autoPlay:true,
			stopOnHover:true,
			transitionStyle : "fade"
		});  
		$("#owl-indexproduct").owlCarousel({
			autoPlay: 3000, 
			pagination: false,
			items : 4,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [979,3],
			itemsDesktopSmall : [979,3],
			itemsTablet : [768,3],
			itemsMobile : [479,1] 
		});
	}

	function insertBeforePic(str,auto) 
	{
		var lazy = $("[" + str + "]");
		for (var i = 0; i < lazy.length; i++) {
			var source = lazy[i].getAttribute(str);
			var img = new Image();
			img.src = source;
			img.alt = lazy[i].getAttribute("data-alt");
			if(auto)
			{
			   var str=source.split('.');
			   var str1=str[0].split('_');
			   img.width = str1[1];
			   img.height = str1[2];
			}else {
				img.width = lazy[i].getAttribute("data-width");
				img.height = lazy[i].getAttribute("data-height");
			}
			lazy[i].insertBefore(img, lazy[i].firstChild)
		}
	}

	function handleLazyResponsive()
	{   
		if (window.matchMedia("(max-width: 30em)").matches) {
			var src = "data-src-480";
		} else if (window.matchMedia("(max-width: 40em)").matches) {
			var src = "data-src-640";
		} else if (window.matchMedia("(max-width: 48em)").matches) {
			var src = "data-src-768";
		} else if (window.matchMedia("(max-width: 62em)").matches) {
			var src = "data-src-992";
		} else {
			var src = "data-src-1200";
		}
		insertBeforePic(src,true);
        insertBeforePic("data-src-origin",false);
	}

	function handleCaptcha()
	{
		if($("#captchaLink").length > 0 ) {
			 $('#captchaLink').on('click', function(e) {
				var radom = Math.random();
				var urlVal = $("#captchaLink")[0].getAttribute("data-captcha");
				if(urlVal.indexOf("?") == -1 ){
					urlVal = urlVal+'/'+radom;
				}else{
					urlVal = urlVal + '&random'+radom;
				}
				$('#captchaImg').attr('src',urlVal);
				e.preventDefault();
			 });
			 $('#captchaLink').click();
		}    
	}
    
	function handleJobValidation()
	{
		if($("#validation-job").length > 0 ) {
		   $('#validation-job').validate({
				errorElement: 'div',
				errorClass: 'help-block',
				focusInvalid: false,
				rules: {  
					resumename: {  required: true},  
					resumetel: {  required: true},  
					resumeemail: { required: true,  email: true}
				},  
				messages: {  
					resumename: { required: "姓名不能为空�?" },  
					resumetel: { required: "联系电话不能为空�?" },    
					resumeemail: { required: "E-mail不能为空�?", email: "E-mail格式错误" }
				}, 
				highlight: function (e) {
					$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
				},
				success: function (e) {
					$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
					$(e).remove();
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				}
		   });
		}      
	}
    
	function handleMessageValidation()
	{
		if($("#validation-message").length > 0 ) {
		   $('#validation-message').validate({
				errorElement: 'div',
				errorClass: 'help-block',
				focusInvalid: false,
				rules: {  
					username: {  required: true},  
					messagetitle: {  required: true},  
					messagecontent: {  required: true},  
					email: { required: true,  email: true},
					captcha: { required: true,remote:  $('#checkCaptchaUrl').val()}
				},  
				messages: {  
					username: { required: "用户名不能为空！" },  
					messagetitle: { required: "留言标题不能为空�?" },  
					messagecontent: { required: "留言内容不能为空�?" },  
					email: { required: "邮件不能为空�?", email: "格式错误" },
					captcha:{required: '请输入字符串',remote: '输入正确的验证码'}
				}, 
				highlight: function (e) {
					$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
				},
				success: function (e) {
					$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
					$(e).remove();
				},
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				}
		   });
		}      
	}

	return {
        init: function () {
			handleMsViewport();
			handleAndroidSelect();
			handleBootstrap();
			handleLazyResponsive();
			handleCaptcha();
			handleMessageValidation();
			handleJobValidation();
        },
		initMap: function (tip,x,y) {
			var geocoder,map,marker = null;
			var center = new qq.maps.LatLng(x,y);
			map = new qq.maps.Map(document.getElementById('map'),{center: center,zoom: 17});
			var infoWin = new qq.maps.InfoWindow({map: map});
			infoWin.open();
			infoWin.setContent(tip);
			infoWin.setPosition(center);
			geocoder = new qq.maps.Geocoder({
				complete : function(result){
					map.setCenter(result.detail.location);
					var marker = new qq.maps.Marker({map:map,position: result.detail.location});
				}
			});
		}
	};

}();