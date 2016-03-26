<?php
    $baseUrl = Yii::app()->session->get('basicUrl');
	//include_once("basis/classBasis.php");
	//LogHomepageHistory();
?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="<?=$baseUrl?>/js/jquery-1.4.2.min.js"></script>
<? //include("../guest/chat.php"); ?>
<LINK REL="stylesheet" TYPE="text/css" HREF="<?=$baseUrl?>/css/head.css">
<LINK REL="stylesheet" TYPE="text/css" HREF="<?=$baseUrl?>/css/mwLogin.css">
<DIV class="MyScriptDiv" style="display:none;"></DIV>
<!--<DIV class="mwLogin">
	<DIV class=bg></DIV>
	<DIV id=login>
		<input type=hidden id="nextURL" value="">
		<div id=scriptObj style="display:none;"></div>
		<A class=close title="关闭" style="cursor:pointer;">X</A> 
		<p class="warningText">只要登录才能进入此页面！</p>
		<DIV class=item style="height:35px;padding-lef:0px;"><LABEL class=iLabel for=uid>用户名</LABEL><INPUT class="iText uid" id=uid name=""> </DIV>
		<DIV class=item style="height:35px;padding-lef:0px;"><LABEL class=iLabel for=upw>密码</LABEL><INPUT 	class="iText upw" id=upw type=password name="" style="FONT: bold 11px Tahoma;"> </DIV>
		<P class=keeping><INPUT class=iCheck id=keepid type=checkbox value="" name=""><LABEL for=keepid>记住用户名</LABEL>&nbsp;<INPUT class=iCheck id=keepme type=checkbox value="" name=""><LABEL for=keepme>自动登录</LABEL></P>
		<SPAN class=btnLogin><INPUT type=button value="请登录" id="logonConfirm"></SPAN> 
		<UL class=help>			  
		<LI>新用户？<A href="../user/guestRegister.php">免费注册</A></UL>	 
	</DIV>
</DIV>
--><script type="text/javascript" src="<?=$baseUrl?>/js/mwLogin.js"></script>
<script language="javascript">
function LogonDialog(urlData)
{
	$(".thickdiv").remove();
	$(".thickbox").remove();
	if(navigator.appName == "Microsoft Internet Explorer") $(".bg").css("height", 20 + $("body").innerHeight());
	$.post("../guest/procFunctionModule.php",{caseNum:17},function(data){
		if(data == "1") window.location.href = urlData;
		else {
			$("#nextURL").attr("value", urlData);
			$('.mwLogin').addClass('open');
		}
	});
}

function LogonDialog2(urlData)
{
	$(".thickdiv").remove();
	$(".thickbox").remove();
	if(navigator.appName == "Microsoft Internet Explorer") $(".bg").css("height", 20 + $("body").innerHeight());
	$.post("../guest/procFunctionModule.php",{caseNum:17},function(data){
		if(data == "1") eval(urlData);
		else {
			$("#nextURL").attr("value", urlData);
			$('.mwLogin').addClass('open');
		}
	});
}

$(document).ready(function(){
	$("a.logonUserOnly").attr("target","_self").attr("href","#").click(function(){LogonDialog($(this).attr("href2"));});
});
</script>
<div class="header" id="header2nd">
	<div class="shortcut">
		<a href="<?=$this->createUrl('product/helpCenter');?>" style="background:url(<?=$baseUrl?>/images/emocon2.gif) no-repeat left center; padding-left:18px;">客户帮助</a><span> | </span>
		<a href="<?=$this->createUrl('product/helpCenter');?>" style="background:url(<?=$baseUrl?>/images/emocon3.gif) no-repeat left center; padding-left:18px;">礼品卡</a><span> | </span>		
		<a class="logonUserOnly" href2="../guest/guestMenu.php?linkURL=guestContent0.php">我的商城</a><span> | </span>
		<a class="logonUserOnly" href2="../guest/guestMenu.php?linkURL=guestContent3.php">我的订单</a>
<?if(!isset($GUESTSESS)||($GUESTSESS['guestIndex']==0)){?>
		<span>&nbsp;</span>
		<span>&nbsp;</span>	
		<a href="../user/guestRegister.php" id="blue">[ 免费注册 ]</a>                 
		<span class="comment">新用户？</span>
		<a href="../user/guestLogon.php" id="blue" target="_self">[请登录]</a>
		<span class="comment" style="background:url(<?=$baseUrl?>/images/emocon4.gif) no-repeat left center; padding-left:15px;">您好，欢迎来商城！</span>
<?}?>
	</div>
</div>
<script language="javascript">
	function reloadHeaderInfo(){
		$.post("shortcut2.php",{exe:1},function(result){
			$("#header2nd .shortcut").html(result);
			$("a.logonUserOnly").attr("target","_self").attr("href","#").click(function(){LogonDialog($(this).attr("href2"));});
		});
	}
	setInterval("reloadHeaderInfo();", 50000);
</script>