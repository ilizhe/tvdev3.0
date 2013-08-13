$(function() {	
	var moveCount=1;
	var lenCount = $("#bimg div img").size();	
	var sWidth = $("#bimg img").width(); //获取焦点图的宽度（显示面积）
	var sHeight = $("#bimg img").height();//获取焦点图的高度
	var len = $("#bimg div img").length; //获取焦点图个数
	var nowLeft;
	$("#bimg").css("height",sHeight);
	$("#bimg div").css({"width":(sWidth+20) * (len),"height":sHeight});
	
	var aWidth=$("#bimg div").width()-20;
	var bWidth=$("#bimg").width();	
	if(aWidth<= bWidth){//不用移动
		$("#bimg span").hide();
	}else if(aWidth-bWidth<bWidth){
			$("#bimg .next").click(function(){
				$("#bimg div").stop(true,false).animate({"left":-(aWidth-bWidth)},300);
			});
			$("#bimg .pre").click(function(){
				$("#bimg div").stop(true,false).animate({"left":0},300);
			});
	}else{
		$("#bimg .pre").hide();
		$("#bimg .pre").click(function(){
				if(moveCount > 1){
					$("#bimg div").animate({left:(-sWidth-20)*(moveCount-2)+'px'},1000 );
					moveCount--;
					$("#bimg .next").show();
					if(moveCount <= 1){
						$("#bimg .pre").hide();
					}
				}
				
		});
		$("#bimg .next").click(function(){
			if(moveCount+1 < lenCount){
				$("#bimg div").animate({left:(-sWidth-20)*moveCount+'px'},1000 );
				moveCount++;
				$("#bimg .pre").show();
				if(moveCount+1 >= lenCount){
					$("#bimg .next").hide();
				}
			}
		});
	}
	
});