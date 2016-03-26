<?
	include_once("global1.php");
	if(isset($GUESTSESS)&&($GUESTSESS['guestIndex']>0)){
		include_once("user/classGuest.php");
		$procUserInfo = new CUserInfo();
		$procUserInfo->UpdateMyOnline();
	}
?>
		<a href="../help/helpCenter.php" style="background:url(../images/emocon2.gif) no-repeat left center; padding-left:18px;">客户帮助</a><span> | </span>
		<a href="../guest/giftCard.php" style="background:url(../images/emocon3.gif) no-repeat left center; padding-left:18px;">礼品卡</a><span> | </span>		
		<a class="logonUserOnly" href2="../guest/guestMenu.php?linkURL=guestContent0.php">我的商城</a><span> | </span>
		<a class="logonUserOnly" href2="../guest/guestMenu.php?linkURL=guestContent3.php">我的订单</a>
<?if(!isset($GUESTSESS)||($GUESTSESS['guestIndex']==0)){?>
		<span>&nbsp;</span>
		<span>&nbsp;</span>	
		<a href="../user/guestRegister.php" id="blue">[ 免费注册 ]</a>
		<span class="comment">新用户？</span>
		<a href="../user/guestLogon.php" id="blue">[请登录]</a>
		<span class="comment" style="background:url(../images/emocon4.gif) no-repeat left center; padding-left:15px;">您好，欢迎来商城！</span>
<?}else{?>
		<span>&nbsp;</span>
<!--		<a href="../guest/guestMenu.php?linkURL=guestContent2.php">修改密码</a><span>&nbsp;</span>-->
		<a href="../user/guestLogoff.php">[ 退出 ]</a>
		<span class="comment" style="background:url(../images/emocon4.gif) no-repeat left center; padding-left:15px;">您好，<?=$GUESTSESS['userID']?>！欢迎您来到商城！</span>
<?}?>