<?php
$baseUrl = Yii::app()->session->get('basicUrl');
if(1){//$checkUser
	if(1){//$MYSESS['chatPermit']
?>
<link type="text/css" rel="stylesheet" href="<?=$baseUrl?>/css/chat2.css">
<script language="javascript">
window.onload = function(){	
	// Chat Function //

//Ask mouse left button is clicked!
var  bClicked = false;
var  bResized = false;
var  pos;
var  offsetX,offsetY;
// screen window dimension //
var   wndWidth;
var   wndHeight;
// trigger window's cordinate  //
var   trig_topPos;
var   trig_leftPos;
// chat entering window's cordinate  //
var   enter_topPos;
var   enter_leftPos;
// chatting window's cordinate  //
var   chat_topPos;
var   chat_leftPos;

function  chatCordinateCalc() {

	wndWidth = $(window).width();
	wndHeight = $(window).height();
    trig_topPos =(wndHeight - $('.chatTrigger').height())/2;
	trig_leftPos = wndWidth - $('.chatTrigger').width();
	enter_topPos = trig_topPos;
	enter_leftPos =  wndWidth;
	chat_topPos = (wndHeight - $('.chat').height())/2;
	chat_leftPos = enter_leftPos - $('.chat').width() - 20 ;
}
function  moveWindows() {

	var  scrollPosTop = $(window).scrollTop();
	var  scrollPosLeft = $(window).scrollLeft();

    var  topPos = scrollPosTop + trig_topPos;
	var  leftPos = scrollPosLeft + trig_leftPos;
	$('.chatTrigger').css('top',topPos+'px');
	$('.chatTrigger').css('left',leftPos+'px');

	topPos = scrollPosTop + enter_topPos;
	leftPos = scrollPosLeft + enter_leftPos;

	topPos = scrollPosTop + chat_topPos;
	leftPos = scrollPosLeft + chat_leftPos;
	$('.chat').css('top',topPos+'px');
	$('.chat').css('left',leftPos+'px');

}

function  chatInit() {

    chatCordinateCalc();

	$('.chatTrigger').css('top',trig_topPos+'px');
	$('.chatTrigger').css('left',trig_leftPos+'px');
	$('.chatTrigger').css('visibility','visible');
	$('.chat').css('top',chat_topPos+'px');
	$('.chat').css('left',chat_leftPos+'px');

	$('.chatTrigger .btnExtend').mouseenter(function() {$(this).css('background-image', 'url(<?=$baseUrl?>/images/btnExtend_c.gif)');});
	$('.chatTrigger .btnExtend').mouseleave(function() {$(this).css('background-image', 'url(<?=$baseUrl?>/images/btnExtend_n.gif)');});
	$('.chatTrigger').click(
		function() {
		    $(this).animate({width:['toggle','linear'], 'left':wndWidth + 'px'}, 250, 'linear', function() {
		    	$('.chat').css('visibility','visible');
		    });
	});
	$('.chat .mc .closeImg2').click(function() {$('.chat').css('visibility','hidden');$('.chatTrigger').animate({width:['toggle','linear'], 'left':trig_leftPos + 'px'}, 250, 'linear', function() {});});
}

$('.chat  .mc .titleText1').mousedown(function(e){

	bClicked = true;
	pos = $('.chat').position();
	offsetX = e.pageX - pos.left;
	offsetY = e.pageY - pos.top;
	$(".aboutBackground").show();
});
$('.chat  .mc .titleText1').mouseup(function(){$(".aboutBackground").hide();bClicked = false;bResized = false;});
$('.chat .mc .resizeWindow').mousedown(function(e){	bResized = true;$(".aboutBackground").show();});

$(document).ready(function(){
	$(document).mouseup(function(){$(".aboutBackground").hide();bResized = false;});
	$(document).mousemove(function(e) {
		if (bClicked) {
		    var  leftPos = e.pageX - offsetX;
		    var  topPos  = e.pageY - offsetY;
			$('.chat').css('top',topPos+'px');
			$('.chat').css('left',leftPos+'px');
		}
		if (bResized) {
			leftPos = parseInt($('.chat').css('left'));
			topPos = parseInt($('.chat').css('top'));
			wndWidth = e.pageX - leftPos + 4;
			wndHeight = e.pageY - topPos + 4;
			dX = wndWidth - 377;
			if(dX < 0){
				dX = 0;
				wndWidth = 377;
				 //return false;
			}
			dY = wndHeight - 270;
			if(dY < 0){
				dY = 0;
				wndHeight = 270;
				//return false;
			}
			$('.chat').css('width',(377+dX)+'px');
			$('.chat').css('height',(270+dY)+'px');
			$('.chat .mc').css('width',(377+dX)+"px");
			$('.chat .titleText1').css('width',(310+dX)+"px");
			$('.chat #alltext').css('width',(354+dX)+"px");
			$('.chat #alltext div').css('width',(270+dX)+"px");
			$('.chat #sentText').css('width',(354+dX)+"px");
			$('.chat #alltext').css('height',(120+dY)+"px");
			$('.chat .mc').css('height',(270+dY)+"px");
			//window.status = wndWidth + ":" + wndHeight;
		}
	});
});

chatInit();


$(window).resize(function()  {
	chatCordinateCalc();
	moveWindows();
});
	
	$(window).scroll(function() {
		var  scrollPos = $(window).scrollTop();
		scrollPos+= 150;
	    $('.chat').animate({
    		top: scrollPos
  		}, 8, function(){});
	    $('.chatTrigger').animate({
    		top: scrollPos
  		}, 8, function(){});

	});
	
	$("#sentText").keydown(function(e){
		if((e.keyCode == 13)&&(e.ctrlKey)) sendChatFunc();
	});

	setInterval("GetMyChat();", 5000);
}

</script>
<STYLE>
	div#alltext{line-height:130%; font-size:12px;}
	div#alltext font{display:block; width:55px; margin-right:5px;float:left; overflow:hidden; height:14px; text-align: right; font-size:12px;}
	div#alltext div{width: 270px; float:left;}
</STYLE>
<div class="chatTrigger"><div class="btnExtend"></div></div>
<div class="chat" style="border: 1px solid #FDB73D;z-index:10000002;background-color:#E9E6D3;">
	<div class="mc" style="width:377px;border:0px;background-Image: none;">
		<div>
			<div class="emoconImg2" style="float:left;width:20px;height: 18px; margin:4px;background: url(<?=$baseUrl?>/images/Emocon8.jpg) no-repeat;"></div>
			<div class="closeImg2" style="float:right;width:15px;height:13px;margin:5px;cursor: pointer;background: url(<?=$baseUrl?>/images/btnClose1_n.gif) no-repeat;"></div>
			<p class="titleText1" style="float:left; width:310px; padding:3px;word-break:break-all;">发消息给用戶</p>
			<div style="clear:both;"></div>
		</div>
		<div id="alltext" style="width:354px;padding:0px; height:120px;"></div>
		<p class="titleText2" style="visibility: hidden;">聊天记录</p>
		<textarea  id="sentText" style="width:354px;"></textarea>
		<div class="btnSec" style="text-align:left;"><a id="sendMsg" style="text-decoration:none;" style="cursor:pointer;" onclick="javascript: sendChatFunc();"><span>发送</span></a><a style="text-decoration:none;" style="cursor:pointer;" onclick="javascript: delChatFunc();"><span>删除</span></a>&nbsp;&nbsp;&nbsp;
		<span id="recvUser" name="recvUser" style="background:none;border:0;"></span>
		</div>
		<div style="background-color:#E9E6D3;">
			<div class="resizeWindow" style="float:right;margin:0px;width:15px;height:13px;cursor: NW-resize;background: url(<?=$baseUrl?>/images/resize.jpg) no-repeat;"></div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<input type=hidden id="recvGuestIndex" name="recvGuestIndex" value="0">
	<input type=hidden id="sessionProcID" name="sessionProcID" value="">
</div>
<script language="javascript">
	function delChatFunc()
	{
		$("#alltext").html("")
	}
	
	function sendChatFunc()
	{
		if($("#sentText").attr("value") == "") return false;
		if($("#recvUser").html() == "") return false;
		
		strSend = $("#sentText").attr("value");
		strArr = strSend.split("\n");
		strSend2 = "";
		for(i=0; i<strArr.length; i++){
			if(strArr[i] != "") strSend2 += strArr[i]+"<BR>";
		}
		
		if(strSend2 != ""){
			$("#alltext").html($("#alltext").html() + "<font color=#6666FF><b>商城: </b></font><div>" + strSend2 + "</div>");
		  	$("#alltext").attr("scrollTop", $("#alltext").attr("scrollTop")+100);
		    $.post("../guest/procFunctionModule.php", {caseNum:3,chatContent:strSend2,recvGuestIndex:$("#recvGuestIndex").attr("value"), sessionProcID:$("#sessionProcID").attr("value")}, function(data){
		    	$("#sentText").attr("value","");
	   	    })
   	    }
	}
	
	function GetMyChat()
	{
	    $.post("../guest/procFunctionModule.php", {caseNum:4}, function(data){
	  		$("#alltext").html($("#alltext").html() + data);
	  		$("#alltext").attr("scrollTop", $("#alltext").attr("scrollTop")+100);
   	    })
	}
	
	function createCookie(name,value,days,Tdom){
		var Tdom=(Tdom)?Tdom:"/";
		if(days){
			var date=new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires="; expires="+date.toGMTString();}else{
			var expires="";
		}
		document.cookie=name+"="+value+expires+"; path="+Tdom;
	}
	
	function readCookie(name){
		var nameEQ=name+"=";
		var ca=document.cookie.split(';');
		for(var i=0;i<ca.length;i++){
			var c=ca[i];
			while(c.charAt(0)==' '){c=c.substring(1,c.length);}
			if(c.indexOf(nameEQ)==0){return c.substring(nameEQ.length,c.length);}
		}
		return null;
	}		
</script>
<?php
    }
?>
<div class="aboutBackground" style="display:none;position:absolute;top:0;left:0;width:100%; height:100%; z-index:10000001;background:#000;border:0;filter:alpha(opacity=1);opacity:0.01;"></div>
<div class="aboutBox" style="display:none;position:absolute; width: 200px; height: 90px; background-color:white; border: 1px solid #59A40C; z-index:10000003; margin:0px; padding:3px;">
	<img src="<?=$baseUrl?>/images/mark14.gif" style="display:block; margin:10px 5px 5px 7px; float:left;">
	<span style="display: block; color: #39840C; float:left; font-size:14px; font-weight:bold; margin-top:25px;">通知</span>
	<a name="offBtn" id="close_day" style="display:block;cursor:pointer; float:right;" onclick="closeMini();"><img src="../images/btn_close01.jpg" alt="close" border="0"></a>
	<div style="clear:both;"></div>
	<div class="aboutBoxContent" style="width:180px; padding-left: 60px; font-size:12px; display:block; height:28px; overflow-y:hidden;" 1onclick="closeMini();"></div>
</div>
<div class="aboutBox2" style="display:none;position:absolute; width: 200px; height: 120px; background-color:white; border: 1px solid #59A40C; z-index:10000003; margin:0px; padding:3px;">
	<img src="../images/mark14.gif" style="display:block; margin:10px 5px 5px 7px; float:left;">
	<span style="display: block; color: #39840C; float:left; font-size:14px; font-weight:bold; margin-top:25px;">通知</span>
	<a name="offBtn" id="close_day" style="display:block;cursor:pointer; float:right;" onclick="closeMini2();"><img src="../images/btn_close01.jpg" alt="close" border="0"></a>
	<div style="clear:both;"></div>
	<div class="aboutBoxContent" style="color: #29540C; width:180px; padding-left: 20px; font-size:12px; display:block;"></div>
</div>
<script language="javascript">
$(document).ready(function(){
	MyLeftPos = (parseInt($(window).width()) - parseInt($(".aboutBox").css("width")) - 20) + "px";
	MyHeightPos = (parseInt($(window).height()) - parseInt($(".aboutBox").css("height")) - 10) + "px";
	$(".aboutBox").css("left", MyLeftPos);
	$(".aboutBox").css("top", MyHeightPos);
	$(".aboutBox2").css("left", MyLeftPos);
	$(".aboutBox2").css("top", MyHeightPos);
	if(navigator.appName == "Microsoft Internet Explorer") $(".aboutBackground").css("height", $("body").innerHeight());
	else $(".aboutBackground").css("position", "fixed");
});

function closeMini()
{
	if($(".aboutBox").css("display")=="none") return false;
	$('.aboutBox').animate({
    		height: "20px",
    		top: $(window).height()-30
  		}, 150, function(){$(".aboutBox").hide();});
}

function closeMini2()
{
	if($(".aboutBox2").css("display")=="none") return false;
	$('.aboutBox2').animate({
    		height: "20px",
    		top: $(window).height()-30
  		}, 150, function(){$(".aboutBox2").hide();$(".aboutBackground").hide();});
}
</script>
<script language="javascript">
	$(document).ready(function(){
		setInterval("GetOrderInfo();", 60000);
	});

	function GetOrderInfo()
	{
	    $.post("../guest/procFunctionModule.php", {caseNum:8}, function(data){
	    	if(data){
	    		if(data.length){
	    			$(".aboutBox .aboutBoxContent").html(data);
	    			MyLeftPos = (parseInt($(window).width()) - parseInt($(".aboutBox").css("width")) - 20) + "px";
	    			$(".aboutBox").css("left", MyLeftPos);
	    			$(".aboutBox").show();
	    			$('.aboutBox').animate({
	    				height: 90,
    					top: $(window).height()-100
  					}, 450, function(){});
  				} else {
	    			$(".aboutBox .aboutBoxContent").html(data);
  					closeMini();
  				}
	    	} else closeMini();;
   	    })
   	    setTimeout("closeMini();", 50000);
	}
</script>
<?php
    }
?>