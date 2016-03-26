<?php    
    use yii\helpers\Url;
    if($r_permit){
    $baseUrl = Yii::$app->request->baseUrl.'/../../assets';
?>
<LINK href="<?=$baseUrl?>/css/main.css" type=text/css rel=stylesheet>
<style>
    *{margin:0; padding:0;font-family:宋体;}
    body{margin:20px; width:95%;}
    /*.mainPage{margin:0px auto; width:980px;}*/
    a{color: mediumblue; text-decoration:none; font-size:13px;}
    a:hover{color: red;}
    h2{font-size:14px; font-weight:bold; display:block; width:930px; text-align:center; margin-bottom:4px; float:left;}
    TABLE.tbl_obj,TABLE.tbl_obj TD, TABLE.tbl_obj2,TABLE.tbl_obj2 TD{border:solid 1px black;}
    TABLE TR.fore TD{border-top:0px;}
    TABLE.tbl_obj TR{text-align:center; background-color: white; height:20px;}
    .DTTD{width:80px; background-color: #39A263; color: white; height:24px;}
    .DDTD{width:159px;}
    .DTTD2{width:160px; background-color: #39A263; color: white; height:24px;}
    .DDTD2{width:320px; text-align:left; text-indent:30px;}
    .itemInfoTD img {float: left;height: 50px;padding: 3px 5px 0px;}
    .itemInfoTD p {font-size: 12px;height: 46px;line-height: 46px;overflow: hidden;padding-top: 5px;text-align: left;}
    .itemInfoTD2 img {float: left;height: 26px;padding: 3px 5px 0px;}
    .itemInfoTD2 p {font-size: 12px;height: 22px;line-height: 22px;overflow: hidden;padding-top: 5px;text-align: left;}
    .summery .calcPriceText {font-size: 18px;font-weight: bold;}
    .summery .calcPrice {color: red;font-size: 20px;font-family: arial;font-weight: bold;}
    .summery {text-align: right;height: 40px;line-height: 40px;padding: 5px 30px 5px 0;font-size: 14px;}
    .mnuDiv a{padding-left: 20px; padding-right:20px;}
    
    .thickdiv{position:absolute;top:0;left:0;z-index:10000001;width:100%;height:100%;background:#000;border:0;filter:alpha(opacity=0);opacity:0;}
    .thickbox {background: url(<?=$baseUrl?>>/images/bg_shadow.gif) no-repeat -4px 0px;border-bottom-left-radius: 20px 20px;border-bottom-right-radius: 6px 6px;border-top-left-radius: 0px 0px;border-top-right-radius: 20px 20px;overflow: hidden;padding: 0px 4px 4px 0px;position: absolute;z-index: 10000002;}
    .thicktitle {background: #F3F3F3;border: solid #C4C4C4;border-bottom-left-radius: 0px 0px;border-bottom-right-radius: 0px 0px;border-top-width: 1px;border-right-width: 1px;border-bottom-width: 0px;border-left-width: 1px;border-top-left-radius: 4px 4px;border-top-right-radius: 4px 4px;color: #333;font-family: arial, 宋体;font-size: 14px;font-weight: bold;height: 27px;line-height: 27px;padding: 0px 10px;}
    .thickclose:link, .thickclose:visited {background: url(<?=$baseUrl?>>/images/bg_thickbox.gif) no-repeat 0px -18px;display: block;font-size: 0px;height: 15px;line-height: 100px;overflow: hidden;position: absolute;right: 12px;top: 7px;width: 15px;z-index: 100000;}
    .thickcon {background: white;border: 1px solid #C4C4C4;border-width: 1px;overflow: auto;padding: 10px;}
    #model-collect .con {color: #333;padding: 20px 0px 0px 60px;}
    #model-collect .failed {background-position: 0px -32px;height: 30px;left: 10px;top: 20px;width: 34px;}
    h5 {font-size: 12px;}
    #model-collect .con a {color: mediumblue;text-decoration: none;}
    #model-collect .con a:hover {color: red;text-decoration: underline;}
    
    SELECT, OPTION{font-size:12px;}
</style>
<body bgcolor="">
<div class="mainPage">

<form id="frmlist2" name="frmlist2" method=get style="display:none;">
    <input type=hidden id="startDate2" name="startDate2" value="<?=$startDate2?>">
    <input type=hidden id="endDate2" name="endDate2" value="<?=$endDate2?>">
    <input type=hidden id="orderStatus" name="orderStatus" value="<?=$orderStatus?>">
    <input type=hidden id="orderIndex" name="orderIndex" value="<?=$orderIndex?>">
</form>
<h2>订单信息（订单编号：<?=$orderItem['orderTicketNumber']?>）</h2>
<?php $orderTicketNumber = isset($_POST['orderTicketNumber']) ? $_POST['orderTicketNumber'] : "";?>     
<form id="frmlist" name="frmlist" method=get action="productorderstatus" style="display:none;">
    <input type=hidden id="startDate2" name="startDate2" value="<?=$startDate2?>">
    <input type=hidden id="endDate2" name="endDate2" value="<?=$endDate2?>">
    <input type=hidden id="orderStatus" name="orderStatus" value="<?=$orderStatus?>">
    <!--input type=hidden id="$orderTicketNumber" name="$orderTicketNumber" value=""-->
</form>  
<a href="javascript: frmlist.submit();" style="float:left;">返回</a>
<div style="clear:both; width:800px;"></div>
<table class=tbl_obj style="border-collapse: collapse;font-size:12px; font-family:Times New Roman;" border=1>
    <tr>
        <td class="DTTD">客户名称</td><td class="DDTD"><?=$orderItem['userName']?></td>
        <td class="DTTD">用户名</td><td class="DDTD"><?=$orderItem['userID']?></td>
        <td class="DTTD">加盟商</td><td class="DDTD"><?php if($orderItem['pseudoCheck']){?>丹东商城<?php }else{ echo $procOrder->GetPrimaryName($orderItem['orderIndex']);}?></td>
        <td class="DTTD">下单时间</td><td class="DDTD"><?=$orderItem['orderDate']?></td>
    </tr>
    <tr<?php if(substr($orderItem['orderCancelDate'],0,10) != "0000-00-00") echo " style='display:none;'";?>>
        <td class="DTTD">发票</td><td class="DDTD">
        <?php if($orderItem['invoiceType']== 0){?>不需
        <?php }else {if(substr($orderItem['ticketDate'],0,10)=='0000-00-00'){?>未开<?php }else{?>已开<?php }}?>
<?php  
if(($orderItem['invoiceType'])&&(!($orderItem['pseudoCheck']))&&$ticket_permit){?>&nbsp;&nbsp;&nbsp;<a class="btnTicket" href="javascript:void(0);">发票</a><?php }?>
        </td>
        <td class="DTTD">订单状态</td><td class="DDTD"><?php if(substr($orderItem['confirmDate'],0,10)=='0000-00-00'){?><font color="#C60000">等待确认<?php }else{?><font color="#0071C6">已确认<?php }?></font>
<?php if((substr($orderItem['payInitialDate'],0,10)=='0000-00-00')&&(substr($orderItem['sendDate'],0,10)=='0000-00-00')){?>
<?php if(!($orderItem['pseudoCheck'])){?>
<?php if($u_permit_order){?>&nbsp;<a href="javascript:void(0);" onclick="javascript:window.open('<?=Url::to(['product-ordertable-edit', 'orderIndex' => $orderIndex])?>');">修改</a><?php }?>
<?php }?>
<?php }?>
<?php if((substr($orderItem['confirmDate'],0,10)=='0000-00-00')&&($confirm_permit)){?>&nbsp;<a class="btnConfirm" href="javascript:void(0);">确认</a><?php }?>
<?php if((substr($orderItem['confirmDate'],0,10)=='0000-00-00')&&($d_permit)){?>&nbsp;<a class="btnDelete" href="javascript:void(0);">取消</a><?php }?>
        </td>
        <td class="DTTD">付款状态</td><td class="DDTD"><?php if(substr($orderItem['payCompleteDate'],0,10)=='0000-00-00'){?><font color="#C60000"><?php if(substr($orderItem['payInitialDate'],0,10)=='0000-00-00'){?>等待付款<?php }else{?>付款中<?php }}else{?><font color="#0071C6">已付清<?php }?></font>
<?php if($pay_permit && (substr($orderItem['confirmDate'],0,10)!='0000-00-00')){?>&nbsp;&nbsp;&nbsp;<a class="btnPayment" href="javascript:void(0);">支付</a><?php }?>
        </td>
        <td class="DTTD">物流状态</td><td class="DDTD"><?php if(substr($orderItem['recvDate'],0,10)=='0000-00-00'){?><font color="#C60000"><?php if(substr($orderItem['sendDate'],0,10)=='0000-00-00'){?><?php if(substr($orderItem['productOutDate'],0,10)=='0000-00-00'){?>等待出庫<?php }else{?>未配送<?php }?><?php }else{?>配送中<?php }}else{?><font color="#0071C6">配送完成<?php }?></font>
<?php if((!($orderItem['pseudoCheck']))&&((substr($orderItem['payCompleteDate'],0,10)!='0000-00-00')||((substr($orderItem['payCompleteDate'],0,10)=='0000-00-00')&&($orderItem['payKind']==4)))&&($p_permit_send||$cancelsend_permit||$completesend_permit)){?>
            &nbsp;&nbsp;&nbsp;
            <?php if(substr($orderItem['productOutDate'],0,10)=='0000-00-00'){?>
                <a class="btnOut" href="javascript:void(0);">出庫</a>
            <?php }else{?>
                <?php if(substr($orderItem['sendDate'],0,10)=='0000-00-00'){?>
                    <a class="btnInput" href="javascript:void(0);">出庫取消</a>&nbsp;&nbsp;/
                <?php }?><a class="btnSend" href="javascript:void(0);">配送</a>
            <?php }?>
<?php }?>
        </td>
    </tr>
</table>
<BR>
<table class=tbl_obj style="border-collapse: collapse;font-size:12px; font-family:Times New Roman;" border=1>
    <tr>
        <td class="DTTD2">收货人姓名</td><td class="DDTD2"><?=$orderItem['recvName']?></td>
        <td class="DTTD2">联系电话</td><td class="DDTD2"><?=$orderItem['recvTelNumber']?></td>
    </tr>
    <tr>
        <td class="DTTD2">收货人地址</td><td class="DDTD2"><?=$orderItem['recvAddress']?></td>
        <td class="DTTD2">邮编</td><td class="DDTD2"><?=$orderItem['recvPostBox']?></td>
    </tr>
    <tr>
        <td class="DTTD2">收货人邮箱</td><td class="DDTD2"><?=$orderItem['recvEmailAddress']?></td>
        <td class="DTTD2">收货人手机</td><td class="DDTD2"><?=$orderItem['recvPhoneNumber']?></td>
    </tr>
    <tr>
        <td class="DTTD2">付款方式</td><td class="DDTD2"><?=$strTitle2?></td>
        <td class="DTTD2">送货方式</td><td class="DDTD2"><?=$sendSpeedStr?><?php if($orderItem['sendSpeed']== 2){
            if($shopObj) echo " (".$shopObj['shopName'].")";}
        ?>
        </td>
    </tr>
    <tr>
        <td class="DTTD2">备注/留言</td><td class="DDTD2" colspan=3 style="width: 802px;"><?=$orderItem['orderContent']?></td>
    </tr>
</table>
<table class=tbl_obj2 style="border-collapse: collapse;font-size:12px; font-family:Times New Roman; border-top:0px;" border=1>
    <tr class="menuBar fore">
        <TD style="width:571px;">商品名称</TD>
        <TD style="width:70px;">数量</TD>
        <TD style="width:67px;">单位</TD>
        <TD style="width:70px;">现有库存</TD>
        <TD style="width:90px;">市场价</TD>
        <TD style="width:90px;">卖价</TD>
    </tr>
<?php
    for($i=0; $i<count($orderDetailArr); $i++){
        if($orderDetailArr[$i]['productIndex']){
            $productObj = $procProduct->GetProductItem($orderDetailArr[$i]['productIndex']);
            $productPackIndex = $orderDetailArr[$i]['packNum'];
            $marketPrice = $productObj['marketPrice'];
            if($productPackIndex){
                $packNum = $procProduct->GetProductPackageNumber($orderDetailArr[$i]['productIndex'], $productPackIndex);
                $marketPrice = $productObj['marketPrice']+ $procProduct->GetProductPackageMarketPrice($orderDetailArr[$i]['productIndex'], $productPackIndex);
            }
?>
    <tr class="offRecord" style="cursor: default; text-align: center;background-color:<?php if($productObj['remainAmount']>= $orderDetailArr[$i]['orderAmount']){?>#FFFFFF;<?php }else{?>#FFFFDD;<?php }?>">
        <TD style="width:571px; text-align: left; text-indent:5px;" class="itemInfoTD"><?php if($productPackIndex){?><img style="float: left; height:9px; width:9px;padding-left:5px; padding-top:21px;cursor:pointer;" src="<?=$baseUrl?>/images/bag_open.gif" border="none" class="packToggle" value="0"> <?php }?> <img src="<?=$baseUrl?>/images/productImages/<?=$orderDetailArr[$i]['productIndex']?>_1_50.jpg"> <p><?=$orderDetailArr[$i]['productName2']?> <?=$orderDetailArr[$i]['productType']?> <?php if($productPackIndex)  echo " (优惠套装".$packNum.")";?></p>
<?php if($productPackIndex){
    $packProducArr = $procProduct->GetProductPackageProductArr($orderDetailArr[$i]['productIndex'], $productPackIndex);
    echo '<div style="clear:both;"></div><div style="margin-left:40px;display:none;" class="packChild">';
    for($kk=0; $kk<count($packProducArr); $kk++){
?>
    <img src="<?=$baseUrl?>/images/productImages/<?=$packProducArr[$kk]['productIndex']?>_1_50.jpg"> <p> <?=$packProducArr[$kk]['productName2']?> <?=$packProducArr[$kk]['productType']?> <font color=red>￥<?=$packProducArr[$kk]['productPriceNow']?></font></p><div style="clear:both;"></div>
<?php 
    }
?></div>
<?php }?>
        </TD>
        <TD style="width:70px;"><?=$orderDetailArr[$i]['orderAmount']?></TD>
        <TD style="width:67px;"><?php if($productPackIndex){?>条<?php }else{?>个<?php }?></TD>
        <TD style="width:70px;"><?php if($productObj['remainAmount']>= $orderDetailArr[$i]['orderAmount']) echo "有"; else echo "<font style='color:red;'>没有</font>";?></TD>
        <TD style="width:90px;"><?=$marketPrice?></TD>
        <TD style="width:90px;"><?php if($orderDetailArr[$i]['orderPrice']== 0) {?>积分价 <?=$orderDetailArr[$i]['orderPoint']?><?php }else{?>￥<?=sprintf("%01.2f", $orderDetailArr[$i]['orderPrice'])?><?php }?></TD>
    </tr>
<?php 
        }else{
?>
    <tr class="offRecord" style="cursor: default;background-color:white; text-align: center;">
        <TD style="width:571px; text-align: left; text-indent:5px;" class="itemInfoTD"><img src="<?=$baseUrl?>/images/money<?=intval($orderDetailArr[$i]['orderPrice'])?>_50.jpg"> <p>礼品卡<?=$orderDetailArr[$i]['orderPrice']?>元</p></TD>
        <TD style="width:70px;"><?=$orderDetailArr[$i]['orderAmount']?></TD>
        <TD style="width:67px;">枚</TD>
        <TD style="width:70px;">有</TD>
        <TD style="width:90px;"><?=$orderDetailArr[$i]['orderPrice']?></TD>
        <TD style="width:90px;"><?=$orderDetailArr[$i]['orderPrice']?></TD>
    </tr>
<?php 
        }
    }
?>
    <TR class="offRecord" style="cursor: default;background-color:white; height:24px;text-align: right;">
        <TD colspan=6>
            <div class="summery">
                <span>商品总金额:￥<?=sprintf("%01.2f", $sumPrice-$speedPrice)?> + </span>
                <span>运费:￥<?=sprintf("%01.2f", $speedPrice)?> </span>
                <span><?php if($cardPrice>0){?>- 礼品卡支付金额:￥<?=sprintf("%01.2f", $cardPrice)?> <?php }?> <?php if($orderItem['netMoney']>0){?>- 网上账户支付金额:￥<?=sprintf("%01.2f", $orderItem['netMoney'])?> <?php }?>= </span>
                <span class="calcPriceText"> 订单支付金额: </span>
                <span class="calcPrice"> ￥<?=sprintf("%01.2f", $sumPrice-$cardPrice-$orderItem['netMoney'])?></span>
            </div>
        </TD>
    </TR>
</table>
<div style="height:2px;"></div>
<table class=tbl_obj2 style="cursor: default;border-collapse: collapse;font-size:12px; font-family:Times New Roman;" border=1>
    <tr class="menuBar">
        <TD style="width:90px;">操作名称</TD>
        <TD style="width:140px;">操作时间</TD>
        <TD style="width:100px;">登陆IP</TD>
        <TD style="width:100px;">操作人员</TD>
        <TD style="width:529px;">备注</TD>
    </tr>
    <TR class="offRecord" style="cursor: default;background-color:white; height:20px; text-align:center;">
        <TD>订单生成</TD>
        <TD><?=$orderItem['orderDate']?></TD>
        <TD></TD>
        <TD></TD>
        <TD></TD>
    </TR>
<?php
    for($i=0; $i<count($orderHistoryArr); $i++){
        if("取消订单" == $orderHistoryArr[$i]['historyTitle']) $checkPrintFault = false;
?>
    <TR class="offRecord" style="cursor: default;background-color:white; height:20px; text-align:center;">
        <TD><?=$orderHistoryArr[$i]['historyTitle']?></TD>
        <TD><?=$orderHistoryArr[$i]['historyDate']?></TD>
        <TD><?=$orderHistoryArr[$i]['historyIP']?></TD>
        <TD><?if($orderHistoryArr[$i]['userName']!= "") echo $orderHistoryArr[$i]['userName']; else echo $orderItem['userID'];?></TD>
        <TD style="text-align:left; text-indent: 5px;"><?=$orderHistoryArr[$i]['historyContent']?></TD>
    </TR>
<?php }?>
<?php if((substr($orderItem['orderCancelDate'],0,10) != "0000-00-00")&&($checkPrintFault)){?>
    <TR class="offRecord" style="cursor: default;background-color:white; height:20px; text-align:center;">
        <TD>取消订单</TD>
        <TD><?=$orderItem['orderCancelDate']?></TD>
        <TD></TD>
        <TD></TD>
        <TD></TD>
    </TR>
<?php }?>
</table>
</div>
</body>

<script language="javascript">
    function cancelFunction(){
        if(cancelReason.value == ""){
            alert("填写取消原因。");
            cancelReason.focus();
            return false;
        }
        agreeVal = 0;
        if(guestAgree.checked) agreeVal = 1;
        $.ajax({
            type:"POST",
            url:'cancelorder',
            data: {
                orderIndex : '<?=$orderIndex?>',
                cancelContent:cancelReason.value,
                agreeCheck:agreeVal,
                d_permit: '<?=$d_permit?>'
            },
            success: function (data){
                alert("取消成功!");
                frmlist.submit();
            },
            error:function (x,e) {
                alert("The call to the server side failed" + x.responseText);
            }
        });
    }

//$(document).ready(function() {
//    alert();
//    $(".packToggle").click(function(){
//        $(this).attr("value",(1-$(this).attr("value")));
//        if($(this).attr("value")==1){
//            $(this).siblings(".packChild").css("display", "block");
//            $(this).attr("src", "<?//=$baseUrl?>///images/bag_close.gif");
//        } else {
//            $(this).siblings(".packChild").css("display", "none");
//            $(this).attr("src", "<?//=$baseUrl?>///images/bag_open.gif");
//        }
//    });
//
    $("a.btnConfirm").click(function(){
        $.ajax({
            type:"POST",
            url:'<?=Url::to(['confirmbutton', 'orderIndex' => $orderIndex])?>',
            data: {
            },
            success:function data(){
                alert("确认成功!");
                frmlist2.submit();
            },
            error: function (x,e) {
                alert("The call to the server side failed." + x.responseText);
            }
        });
    });

    $("a.btnOut").click(function(){
        $.ajax({
            type:"POST",
            url:'outbutton',
            data: {
                'orderIndex':'<?=$orderIndex?>',
                'p_permit_send':'<?=$p_permit_send?>'
            },
            success:function(data) {
                alert("出庫成功!");
                frmlist2.submit();
            },
            error:function(x,e) {
                alert("The call sever side failed" + x.responseText);
            }

        });
    });

    $("a.btnInput").click(function(){
        $.ajax({
            type:"POST",
            url:'inputbutton',
            data: {
                'orderIndex':'<?=$orderIndex?>',
                'p_permit_send':'<?=$p_permit_send?>'
            },
            success:function(data) {
                alert("出庫取消成功!");
                frmlist2.submit();
            },
            error:function(x,e) {
                alert("The call sever side failed" + x.responseText);
            }
        });
    });

    $("a.btnTicket").click(function(){
        $.ajax({
            type:"POST",
            url:'<?=Url::to(['ticketbox', 'orderIndex'=>$orderIndex])?>',
            data: {},
            success: function (data){
                $(".thickbox").remove();
                $('body').append($('<div class="thickdiv" id="" style="display: block; "></div><div class="thickbox" id="" style="width: 382px; height: 550px; "><div class="thicktitle" id="" style="width:360"><span>发票</span></div><div class="thickcon" id="" style="width:360px;height:500px;"><div class="model-prompt" id="model-collect"><div class="con">'+data+'</div></div></div><a href="javascript:void(0);" onclick="javascript:$(this).parent().remove();$(\'.thickdiv\').remove();" class="thickclose" id="" style = "background-Image: url(<?=$baseUrl;?>/images/bg_thickbox.gif);">×</a></div>'));
                if(navigator.appName == "Microsoft Internet Explorer"){
                    $(".thickdiv").css("height", 20 + $("body").innerHeight());
                    $(".thickbox").css("left", screen.width/2 - 250);
                    $(".thickbox").css("top", document.documentElement.scrollTop + 50);
                } else {
                    $(".thickdiv").css("position", "fixed");
                    $(".thickbox").css("position", "fixed");
                    $(".thickbox").css("left", screen.width/2 - 250);
                    $(".thickbox").css("top", 100);
                }
            },
            error:function(x,e) {
                alert("###The call sever side failed" + x.responseText);
            }
        }) ;
    });

    $("a.btnDelete").click(function(){
        $(".thickbox").remove();
        $('body').append($('<div class="thickdiv" id="" style="display: block; "></div><div class="thickbox" id="" style="width: 482px; height: 250px;"><div class="thicktitle" id="" style="width:460"><span>取消订单</span></div><div class="thickcon" id="" style="width:460px;height:200px;"><div class="model-prompt" id="model-collect"><div class="con" style="font-size:14px;"><div>取消原因:<BR><textarea id="cancelReason" name="cancelReason" style="width:350px;height:100px;"></textarea></div><div style="padding-top:10px;"><input type=checkbox checked id="guestAgree" name="guestAgree"> 是否经过用户同意&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=button id="btnCancel" name="btnCancel" value="取消订单" onclick="javascript:cancelFunction();"></div></div></div></div><a href="javascript:void(0);" onclick="javascript:$(this).parent().remove();$(\'.thickdiv\').remove();" class="thickclose" style = "background-Image: url(<?=$baseUrl;?>/images/bg_thickbox.gif);" id="">×</a></div>'));
        if(navigator.appName == "Microsoft Internet Explorer"){
            $(".thickdiv").css("height", 20 + $("body").innerHeight());
            $(".thickbox").css("left", screen.width/2 - 250);
            $(".thickbox").css("top", document.documentElement.scrollTop + 150);
        } else {
            $(".thickdiv").css("position", "fixed");
            $(".thickbox").css("position", "fixed");
            $(".thickbox").css("left", screen.width/2 - 250);
            $(".thickbox").css("top", 200);
        }
    });

    $("a.btnPayment").click(function(){
        $.ajax({
            type:"POST",
            url:'paymentbutton',
            data: {
                'orderIndex' : '<?=$orderIndex?>',
                'userID' : '<?=$orderItem['userID']?>',
            },
            success : function (result) {
                $(".thickbox").remove();
                $('body').append($('<div class="thickdiv" id="" style="display: block; "></div><div class="thickbox" id="" style="width: 682px; height: 350px;"><div class="thicktitle" id="" style="width:660"><span>付款</span></div><div class="thickcon" id="" style="width:660px;height:300px;"><div class="model-prompt" id="model-collect"><div class="con">'+result+'</div></div></div><a href="javascript:void(0);" onclick="javascript:$(this).parent().remove();$(\'.thickdiv\').remove();" class="thickclose" style = "background-Image: url(<?=$baseUrl;?>/images/bg_thickbox.gif);" id="">×</a></div>'));
                if(navigator.appName == "Microsoft Internet Explorer"){
                    $(".thickdiv").css("height", 20 + $("body").innerHeight());
                    $(".thickbox").css("left", screen.width/2 - 450);
                    $(".thickbox").css("top", document.documentElement.scrollTop + 50);
                } else {
                    $(".thickdiv").css("position", "fixed");
                    $(".thickbox").css("position", "fixed");
                    $(".thickbox").css("left", screen.width/2 - 450);
                    $(".thickbox").css("top", 100);
                }
            },
            error:function(x,e) {
                alert("The call to the server side failed" + x.responseText);
            }
        });

    });

    $("a.btnSend").click(function(){
        $.ajax({
            type:"POST",
            url:'sendbutton',
            data: {
                'orderIndex' : '<?=$orderIndex?>',
            },
            success : function (data) {
                $(".thickbox").remove();
                $('body').append($('<div class="thickdiv" id="" style="display: block; "></div><div class="thickbox" id="" style="width: 682px; height: 550px;"><div class="thicktitle" id="" style="width:660"><span>配送</span></div><div class="thickcon" id="" style="width:660px;height:500px;"><div class="model-prompt" id="model-collect"><div class="con">'+data+'</div></div></div><a href="javascript:void(0);" onclick="javascript:$(this).parent().remove();$(\'.thickdiv\').remove();" class="thickclose" style = "background-Image: url(<?=$baseUrl;?>/images/bg_thickbox.gif);" id="">×</a></div>'));
                if(navigator.appName == "Microsoft Internet Explorer"){
                    $(".thickdiv").css("height", 20 + $("body").innerHeight());
                    $(".thickbox").css("left", screen.width/2 - 450);
                    $(".thickbox").css("top", document.documentElement.scrollTop + 50);
                } else {
                    $(".thickdiv").css("position", "fixed");
                    $(".thickbox").css("position", "fixed");
                    $(".thickbox").css("left", screen.width/2 - 450);
                    $(".thickbox").css("top", 100);
                }
            },
            error:function(x,e){
                alert("The call to the server side failed" + x.responseText);
            }
        });
    });

//});
//
<?php //if(($orderItem['invoiceType'])&&(substr($orderItem['ticketDate'],0,10)=='0000-00-00')&&(substr($orderItem['payCompleteDate'],0,10)!="0000-00-00")){?>
//    function saveTicketFunc(ticketMoney2, ticketContent2, ticketNumber2)
//    {
//
//        $.ajax({
//            type:"POST",
//            url:'save-ticket',
//            data: {
//                'orderIndex':'<?//=$orderIndex?>//',
//                ticketMoney:ticketMoney2,
//                ticketContent:ticketContent2,
//                ticketNumber:ticketNumber2,
//
//                ticket_permit:'<?//=$ticket_permit?>//'
//            },
//            success:function(data) {
//                alert("保存成功!");
//                frmlist2.submit();
//            },
//            error:function(x,e) {
//                alert("The call sever side failed" + x.responseText);
//            }
//
//        });
//    }
<?php //}?>
<?php //if(($orderItem['invoiceType'])&&(substr($orderItem['ticketDate'],0,10)!='0000-00-00')){?>
//    function cancelTicketFunc()
//    {
//
//        $.ajax({
//            type:"POST",
//            url:'cancel-ticket',
//            data: {
//                'orderIndex':'<?//=$orderIndex?>//',
//
//                ticket_permit:'<?//=$ticket_permit?>//'
//            },
//            success:function(data) {
//                alert("作废成功!");
//                frmlist2.submit();
//            },
//            error:function(x,e) {
//                alert("The call sever side failed" + x.responseText);
//            }
//
//        });
//    }
<?php //}?>
<?php //if(substr($orderItem['completeDate'],0,10)=='0000-00-00'){?>
<?php if(substr($orderItem['payCompleteDate'],0,10)=='0000-00-00'){?>
    function savePayFunc(payKind2, moneyNumber2, moneyAmount2, moneyInfo2, limitAmount2)
    {
        if(moneyNumber2 == ""){
            alert("请输入单据号码!");
            return false;
        }
        moneyAmount2 = parseFloat(moneyAmount2);
        if(isNaN(moneyAmount2)) moneyAmount2 = 0;
        if(moneyAmount2 > limitAmount2){
            alert("超额付款!");
            return false;
        }
        if(moneyAmount2 == 0){
            alert("请输入付款金额!");
            return false;
        }

        $.ajax({
            type:"POST",
            url:'save-pay',
            data: {
                'orderIndex':'<?=$orderIndex?>',
                payKind:payKind2,
                moneyNumber:moneyNumber2,
                moneyAmount:moneyAmount2,
                moneyInfo:moneyInfo2,
                pay_permit:'<?=$pay_permit?>'
            },
            success:function(data) {
                alert("保存成功!");
                frmlist2.submit();
            },
            error:function(x,e) {
                alert("###The call sever side failed" + x.responseText);
            }
        });
    }
    <?php }?>
    function delPayRecord(moneyIndex)
    {
        $.ajax({
            type:"POST",
            url:'del-pay-record',
            data: {
                'orderIndex':'<?=$orderIndex?>',
                moneyIndex:moneyIndex,
                pay_permit:'<?=$pay_permit?>'
            },
            success:function(data) {
                alert("删除成功!");
                frmlist2.submit();
            },
            error:function(x,e) {
                alert("The call sever side failed" + x.responseText);
            }

        });
    }
    <?php if(substr($orderItem['sendDate'],0,10)=="0000-00-00"){?>
    function sendOkFunction()
    {
        $.ajax({
            type:"POST",
            url:'send-ok',
            data: {
                'orderIndex':'<?=$orderIndex?>',
                sendTicketNumber:'<?=substr($orderItem['orderTicketNumber'].date("md"), 2)?>',
                p_permit_send:'<?=$p_permit_send?>'
            },
            success:function(data) {
                alert("操作成功!");
                frmlist2.submit();
            },
            error:function(x,e) {
                alert("The call sever side failed" + x.responseText);
            }
        });
    }
    <?php }else{?>
    function sendCancelFunction(checkSendTicketNumber)
    {
        if(checkSendTicketNumber != '<?=$orderItem['sendTicketNumber']?>'){
            alert('请确认配送单号!');
            return false;
        }

        $.ajax({
            type:"POST",
            url:'send-cancel',
            data: {
                'orderIndex':'<?=$orderIndex?>',
                cancelsend_permit:'<?=$cancelsend_permit?>'
            },
            success:function(data) {
                alert("操作成功!");
                frmlist2.submit();
            },
            error:function(x,e) {
                alert("The call sever side failed" + x.responseText);
            }

        });
    }

    function sendCompleteFunction(checkSendTicketNumber)
    {
        if(checkSendTicketNumber != '<?=substr($orderItem['orderTicketNumber'].date("md"), 2)?>'){
            alert('请确认配送单号!');
            return false;
        }

        $.ajax({
            type:"POST",
            url:'send-complete',
            data: {
                'orderIndex':'<?=$orderIndex?>',
                completesend_permit:'<?=$completesend_permit?>'
            },
            success:function(data) {
                alert("操作成功!");
                frmlist2.submit();
            },
            error:function(x,e) {
                alert("The call sever side failed" + x.responseText);
            }
        });
    }
    <?php }?>
<?php //}?>
//    parent.GetOrderInfo();
</script>
<?php if($p_permit&&(!($orderItem['pseudoCheck']))){?>
<?php
    echo '<table style="display:none;" id=tblData>';
    echo '<tr><td>配送单编号</td><td>№ ';
    if(substr($orderItem['sendDate'],0,10)!="0000-00-00") echo $orderItem['sendTicketNumber'];
    else echo substr($orderItem['orderTicketNumber'].date("md"), 2);
    echo '</td><td>订单编号</td><td>'.$orderItem['orderTicketNumber'].'</td></tr>';
    echo '<tr><td>客户名称</td><td>'.$orderItem['userName'].'</td><td>用户名</td><td>'.$orderItem['userID'].'</td></tr>';
    echo '<tr><td>订单金额</td><td>'.$orderItem['orderMoney'].'</td><td>付款状态</td><td>';
    if(substr($orderItem['payCompleteDate'],0,10)=='0000-00-00'){
        if(substr($orderItem['payInitialDate'],0,10)=='0000-00-00') echo '等待付款'; else echo '付款中';
    }else
        echo '已付清';
    echo '</td></tr>';
    echo '<tr><td>配送方式</td><td colspan=3>';
    echo $sendSpeedStr;// GetSendKindStr($orderItem['sendSpeed']);
    echo '</td></tr>';
    echo '<tr><td>地     址</td><td colspan=3>'.$orderItem['recvAddress'].'</td></tr>';
    echo '<tr><td>备     注</td><td colspan=3>'.$orderItem['orderContent'].'</td></tr>';
    echo '<tr>';
    echo '<TD>商品编号</TD>';
    echo '<TD>商品名称</TD>';
    echo '<TD>数量</TD>';
    echo '<TD>单位</TD>';
    echo '</tr>';

    for($i=0; $i<count($orderDetailArr); $i++){
        $productObj = $procProduct->GetProductItem($orderDetailArr[$i]['productIndex']);
        $productPackIndex = $orderDetailArr[$i]['packNum'];
        if($productPackIndex) $packNum = $procProduct->GetProductPackageNumber($orderDetailArr[$i]['productIndex'], $productPackIndex);

        echo '<tr>';
        echo '<TD>'.$orderDetailArr[$i]['productCode'].'</TD>';
        echo '<TD style="width:304px; text-align: left; text-indent:5px;" class="itemInfoTD2">';
        echo '<p>'.$orderDetailArr[$i]['productName2'].' '.$orderDetailArr[$i]['productType'];
        if($productPackIndex)  echo " (优惠套装".$packNum.")";
        echo '</p>';
        echo '</TD>';
        echo '<TD>'.$orderDetailArr[$i]['orderAmount'].'</TD>';
        echo '<TD>';
        if($productPackIndex) echo '条'; else echo '个';
        echo '</TD>';
        echo '</tr>';
    }
    echo '</table>';
?>
<script type="text/vbscript" src="print1.vbs"></script>

<SCRIPT FOR=document EVENT=onkeydown LANGUAGE="VBSCRIPT">
    if window.event.keyCode = 77 and window.event.ctrlKey then
        MsgBox(tblData)
        //printFunc(tblData)
    end if


</SCRIPT>
<script language="vbscript">
    titleStr = "配送单编"
    fileNameStr = "配送单编"
</script>
<?php 
        }
    }
?>