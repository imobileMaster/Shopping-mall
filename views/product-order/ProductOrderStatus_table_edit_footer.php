<?php
    $baseUrl = Yii::$app->request->baseUrl.'/../../assets';
?>
    <table class="tb2" border="0" cellspacing="0">
        <thead>
        <tr>
            <th>商品编码</th>
            <th> 商 品 名 称 </th>
            <th> 商 城 价 </th>
            <th class="itemAmountTD">商品数量</th>
        </tr>
        </thead>
    <tbody>
<?php
    $totalMoney = 0;
    $sendMoney = 0;
    $cardUseMoney = 0;
    $pointRec = 0;
    
    
    $cartOrderItemArr = explode("|||", $cartOrder);
    if(count($cartOrderItemArr) > 1){
        if(($recvType != "2")&&($recvRegionIndex)){
            $procRegionItem = $procRegionObj->GetItem($recvRegionIndex);
            $sendMoney = $procRegionItem['regionInfo'];
        }
        for($i=0; $i<count($cartOrderItemArr)-1; $i++){
            $productItemArr = explode("||", $cartOrderItemArr[$i]);
            $productInfoArr = explode("@",$productItemArr[0]);
            $productIndex = $productInfoArr[0];
            
            if(count($productInfoArr)>1) 
                $productPackIndex = $productInfoArr[1]; 
            else 
                $productPackIndex = 0;
                
            $productObj = $procProduct->GetProductItem($productIndex);
            
            $productPriceNow = round($productObj['productPriceNow'] * ($productObj['discountRate'])/100, 2);
            if(($reciptExistVal==0)&&($productObj['chkTicket']== 0)) $productPriceNow = $productObj['productPriceNow']* (100 - $productObj['receiptGeneralRate']) /100;
            if(($reciptExistVal)&&($productObj['chkTicket'] == 2)){
                if($reciptTypeVal == 1) $productPriceNow = $productObj['productPriceNow']* (100 + $productObj['receiptGeneralRate']) /100;
                else $productPriceNow = $productObj['productPriceNow'] * (100 + $productObj['receiptVATRate']) /100;
            }
            if(isset($productInfoArr[1]) && ($productInfoArr[1]== "EXE")){
                $productPriceNow = $productObj['pointLowPrice'];
                $productPackIndex = 0;
            }
            if(($recvType != "2")&&($productPriceNow>0)) 
                $sendMoney += $productObj['carriageCharge'] * $productItemArr[1];
            
            $productPackagePrice = 0;
            if($productPackIndex){
                $packNum = $procProduct->GetProductPackageNumber($productIndex, $productPackIndex);
                $productPackagePrice = $procProduct->GetProductPackageReceiptPrice($productIndex, $productPackIndex, $reciptExistVal, $reciptTypeVal);
                if($recvType != "2") 
                    $sendMoney += $procProduct->GetProductPackageCarriageCharge($productIndex, $productPackIndex) * $productItemArr[1];
            } 
            $productPriceNow += $productPackagePrice;
            
?>
            <tr>
                <td class="itemCodeTD"><?=$productObj['productCode']?><BR><?php if(isset($productInfoArr[1]) && ($productInfoArr[1]== "EXE")){ echo "<BR>(积分商品)";$pointRec += $productObj['pointPrice']*$productItemArr[1];}?></td>
                <td class="itemInfoTD">
                    <?php if($productPackIndex){?><img style="height:9px; width:9px;padding-top:21px;cursor:pointer;" src="<?=$baseUrl?>/images/bag_open.gif" border="none" class="packToggle" value="0"><?php }?><img src="<?=$baseUrl?>/images/productImages/<?=$productObj['productIndex']?>_1_50.jpg"><p> <?=$productObj['productName2']?> <?=$productObj['productType']?><?php if($productPackIndex) echo " (优惠套装".$packNum.")";?></p>
<?php if($productPackIndex){
    $packProducArr = $procProduct->GetProductPackageProductArr($productIndex, $productPackIndex);
    echo '<div style="clear:both;"></div><div style="margin-left:40px;display:none;" class="packChild">';
    for($kk=0; $kk<count($packProducArr); $kk++){
?>
    <img src="<?=$baseUrl?>/images/productImages/<?=$packProducArr[$kk]['productIndex']?>_1_50.jpg"> <p> <a target="_blank" href="productDetail.php?productIndex=<?=$packProducArr[$kk]['productIndex']?>" onclick="this.blur();"><?=$packProducArr[$kk]['productName2']?> <?=$packProducArr[$kk]['productType']?></a> <font color=red>￥<?=$packProducArr[$kk]['productPriceNow']?></font></p><div style="clear:both;"></div>
<?php
    }
?></div>
<?php }?>
                </td>
                <td class="itemPriceTD">
                            <?php if(isset($productInfoArr[1]) && ($productInfoArr[1]== "EXE")){
                                 echo "<span style='font-size:13px;font-weight:bold;color:#333333;font-family:Arial;'>积分价 <font color=red>".$productObj['pointPrice']."</font></span>";
                                if($productObj['pointLowPrice']>0) echo "<BR><span style='font-size:13px;font-weight:bold;color:#333333;font-family:Arial;'>货币价 <font color=red>￥".(0+$productObj['pointLowPrice'])."</font></span>";
                            } else {?>
                            <p>￥<?=sprintf("%01.2f", $productPriceNow)?></p><?php }?>
                </td>
                <td class="itemAmountTD">
                    <a href="javascript:void(0)"><img src="<?=$baseUrl?>/images/MinusMark_r.JPG" onclick="removeFromCart('<?=$productItemArr[0]?>',1)"></a>
                    <input type="text" id="amount" value="<?=$productItemArr[1]?>" maxlength=3 onchange="javascript:checkValid('<?=$productItemArr[1]?>','<?=$productItemArr[0]?>',this);" limitAmount="<?=$productObj['remainAmount']-$productObj['requestAmount']?>" schedule="<?=$productObj['schedule']?>" productName2="<?=$productObj['productName2']?>">
                    <a href="javascript:void(0)"><img src="<?=$baseUrl?>/images/PlusMark_r.JPG" onclick="addToCart('<?=$productItemArr[0]?>',1)"></a>
                </td>
            </tr>
<?php            $totalMoney += $productPriceNow * $productItemArr[1];
        
    }
    
    if($totalMoney + $sendMoney >= $cardRealMoney) $cardUseMoney = $cardRealMoney;
    else $cardUseMoney = $totalMoney + $sendMoney;
    $netUseMoney = 0;
    if($netMoneyCheck > 0){
        
        $netAccountObj = $procAccount->GetNetAccount('');  // $GUESTSESS['guestIndex']
        $remainNetMoney = $netAccountObj['netMoney'];
        if($totalMoney + $sendMoney - $cardUseMoney >= $remainNetMoney) $netUseMoney = $remainNetMoney;
        else $netUseMoney = $totalMoney + $sendMoney - $cardUseMoney;
    }
?>
        </tbody>
    </table>
<script language="javascript">
    $("#pay_transInfo .rds .content").eq(2).html("<?=sprintf("%01.2f", $sendMoney)?>元");
</script>
    <div class="title">结 算 信 息</div>
    <p class="summery"><span class="result">商品金额：<?=sprintf("%01.2f", $totalMoney)?>元 + 运费:<?=sprintf("%01.2f", $sendMoney)?>元 - 礼品卡：<?=sprintf("%01.2f", $cardUseMoney)?>元 - 网上账户：<?=sprintf("%01.2f", $netUseMoney)?>元<?php if($pointRec>0){?> - 积分：<?=(0+$pointRec)?><?php }?> </span><span class="commentText">应付总额：<span class="totalPrice"> <?=sprintf("%01.2f", $totalMoney+$sendMoney-$cardUseMoney-$netUseMoney)?> </span>元</span></p>
<script language="javascript">
    $(".pointRec").attr("value", "<?=(0+$pointRec)?>");
<?php
    if($totalMoney == 0){
?>
    ToggleToVisit();
<?php
    }
?>
    $(".packToggle").click(function(){
        $(this).attr("value",(1-$(this).attr("value")));
        if($(this).attr("value")==1){
            $(this).siblings(".packChild").css("display", "block");
            $(this).attr("src", "<?=$baseUrl?>/images/bag_close.gif");
        } else {
            $(this).siblings(".packChild").css("display", "none");
            $(this).attr("src", "<?=$baseUrl?>/images/bag_open.gif");
        }
    });
    
    function checkValid(originValue, procIndex, chkElement)
    {
        numStr = parseInt(chkElement.value);
        if((isNaN(numStr))||(numStr == 0))
        { 
            alert("请正确输入购买数量。");
            chkElement.value = "1";
            chkElement.focus();
            return false;
        } else {
            if(numStr < 1) numStr = 1;
            chkElement.value = numStr;
            if(originValue > numStr) removeFromCart(procIndex, (originValue - numStr));
            if(originValue < numStr) addToCart(procIndex, (numStr - originValue));
            return true;
        }
    }
    
    function checkSumCount()
    {
        checkSum = 0;
        for(i=0; i<$("#orderDetailSum INPUT").length; i++)
            checkSum += 1*$("#orderDetailSum INPUT").eq(i).attr("value");
        return (checkSum == 0);
    }
    function checkOverflow()
    {
        for(i=0; i<$("#orderDetailSum INPUT").length; i++)
            if(($("#orderDetailSum INPUT").eq(i).attr("limitAmount")=="0")&&($("#orderDetailSum INPUT").eq(i).attr("schedule")=="0"))
            {
                alert("此商品("+$("#orderDetailSum INPUT").eq(i).attr("productName2")+")暂时无货，您可以与客服联系为您进货，或者选购其他商品。");
                return true;
            }
        for(i=0; i<$("#orderDetailSum INPUT").length; i++)
            if(($("#orderDetailSum INPUT").eq(i).attr("value") > $("#orderDetailSum INPUT").eq(i).attr("limitAmount"))&&($("#orderDetailSum INPUT").eq(i).attr("schedule")=="0"))
            {
                alert("购买数量很多。请再输入购买数量。");
                return true;
            }
        return false;
    }
</script>
<?php
    }
?>