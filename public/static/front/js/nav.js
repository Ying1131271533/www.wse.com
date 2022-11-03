/* ====================
    必要js
==================== */
var navCliiapsed = "normal";
function changePageStyle(){
	if(navCliiapsed=="min"){		
		$("body").addClass("nav-collapsed-min");		
	}else{
		$("body").removeClass("nav-collapsed-min");
	}
}
$(function(){
	/** 回到顶部事件*/
	 $(window).scroll(function(){  
        if ($(window).scrollTop()>100){  
            $("#back-to-top").fadeIn(300);  
        }else{  
            $("#back-to-top").fadeOut(300);  
        }  
    }); 
    $("#back-to-top").click(function(){  
        $('body,html').animate({scrollTop:0},300);  
        return false;  
    });  
	
	/** 顶部左上角菜单栏变窄事件 */
 	$(".toggle-min").click(function(){
		if(navCliiapsed=="normal"){
			navCliiapsed="min";
		}else{
			navCliiapsed="normal";
		}
		$("#nav").children(".dropdown").each(function(){
			$(this).removeClass("open");
			$(this).children("ul").hide();
		});
		changePageStyle();
		return false;
  	});  
  
  /** 顶部右上角菜单展开按钮(当屏幕宽度小于768px时才显示) */
	var oncanvasbool = false;
    $(".menu-button").click(function(){
		if(oncanvasbool){
			$("body").removeClass("on-canvas");			
			oncanvasbool = false;
		}else if(!oncanvasbool){
			$("body").addClass("on-canvas");			
			oncanvasbool = true;
		}
	});  
  
	/** 顶部菜单栏展开事件 */
	$(".top-nav").find(".dropdown").children("a").on("click",function(e){
		if ( e && e.stopPropagation ){
			e.preventDefault();
			e.stopPropagation(); 
		}else{
			window.event.returnValue = false
			window.event.cancelBubble = true;
		}
		var open = true;
		var that = $(this);
		var parentObj = that.parent(".dropdown");
		if(parentObj.hasClass("active")){
			open = false;
		}
		$(".top-nav").find(".dropdown").removeClass("active");
		$(".top-nav").find(".dropdown .dropdown-menu").hide();		
		if(open){
			parentObj.find(".dropdown-menu").show();
			parentObj.addClass("active");
		}
		
	});
	$(".top-nav").find(".dropdown-menu").click(function(e){
		if ( e && e.stopPropagation ){
			stopPropagation(e);
		}else{
			window.event.cancelBubble = true;
		}
  	});
 
    $("body").click(function(){
   		$(".top-nav").find(".dropdown").removeClass("active");
		$(".top-nav").find(".dropdown .dropdown-menu").hide();
	});
	/** 左侧菜单栏展开事件 */
    $("#nav").children(".dropdown").children("a").click(function(){
		if(!$('body').hasClass('nav-collapsed-min')){
			var parentObj = $(this).parent(".dropdown");
			parentObj.siblings(".dropdown,li").children("ul").stop(true,true).slideUp();
			parentObj.siblings(".dropdown,li").removeClass("open")
			if(parentObj.hasClass("open")){
				parentObj.children("ul").stop(true,true).slideUp();
				parentObj.removeClass("open");
			}else{
				parentObj.children("ul").stop(true,true).slideDown();
				parentObj.addClass("open");
			}
		}
		return false;
	});
	/** 元素浮动事件 */
	var fixedTopParentObj = $(".toBeFixedTop");
	if(fixedTopParentObj&&fixedTopParentObj.length){
		var fixTop = parseInt(fixedTopParentObj.offset().top);
		var fixLeft = parseInt(fixedTopParentObj.offset().left);
		var fixedTopObj = $(".toBeFixedTop").children(".panel");
		var fixHeight = parseInt(fixedTopObj.height())+parseInt(fixedTopObj.css("margin-top"))+parseInt(fixedTopObj.css("margin-bottom"))+parseInt(fixedTopObj.css("border-top"))+parseInt(fixedTopObj.css("border-bottom"));
		fixedTopParentObj.height(fixHeight);
		$(window).scroll(function(){
			fixTop = parseInt(fixedTopParentObj.offset().top);
			fixLeft = parseInt(fixedTopParentObj.offset().left);
			if ($(window).scrollTop()>fixTop){
			   fixedTopObj.css({"position":"fixed","z-index":"999","left":fixLeft+"px","top":"0","right":"15px"});
			}else{  
			   fixedTopObj.css({"position":"relative","z-index":"300","left":"0","top":"0","right":"0"});
			   //fixedTopObj.css({"position":"relative","z-index":"999","left":"0","top":"0","right":"0"});
			}  
		}); 
	}
});