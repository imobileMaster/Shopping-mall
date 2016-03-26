
<style type="text/css">
tr.offRecord{background-color: #FFFFFF; font-family:"Times New Roman", "宋体"; }
</style>
<?php
    use yii\helpers\Url;
$baseUrl = Yii::$app->request->baseUrl.'/../../assets';
    $p_permit = true;
//    CheckOrderPermit();
//    if($p_permit_send||$cancelsend_permit||$completesend_permit)
    {
        
        echo '<table class=tbl_obj style="border-collapse: collapse;font-size:12px; font-family:Times New Roman;" border=1>';
        echo '<tr><td class="DTTD">配送单编号</td><td class="DDTD">';
        if(substr($orderItem['sendDate'],0,10)!="0000-00-00") echo $orderItem['sendTicketNumber'];
        else echo substr($orderItem['orderTicketNumber'].date("md"), 2);
        echo '</td><td class="DTTD">订单编号</td><td class="DDTD">'.$orderItem['orderTicketNumber'].'</td></tr>';
        echo '<tr><td class="DTTD" style="width:112px;">客户名称</td><td class="DDTD">'.$orderItem['userName'].'</td><td class="DTTD" style="width:112px;">用户名</td><td class="DDTD">'.$orderItem['userID'].'</td></tr>';
        echo '<tr><td class="DTTD">订单金额</td><td class="DDTD">'.$orderItem['orderMoney'].'</td><td class="DTTD">付款状态</td><td class="DDTD">';
        if(substr($orderItem['payCompleteDate'],0,10)=='0000-00-00'){
            echo '<font color="#C60000">';
            if(substr($orderItem['payInitialDate'],0,10)=='0000-00-00') echo '等待付款'; else echo '付款中';
        }else
            echo '<font color="#0071C6">已付清';
        echo '</font>';
        echo '</td></tr>';
        echo '<tr><td class="DTTD">配送方式</td><td colspan=3 style="text-align:left; text-indent: 5px;">';
        echo $sendKindStr;
        echo '</td></tr>';
        echo '<tr><td class="DTTD">地     址</td><td colspan=3 style="text-align:left; text-indent: 5px;">'.$orderItem['recvAddress'].'</td></tr>';
        echo '<tr><td class="DTTD">备     注</td><td colspan=3 style="text-align:left; text-indent: 5px;">'.$orderItem['orderContent'].'</td></tr>';
        if(substr($orderItem['sendDate'],0,10)!="0000-00-00"){
            echo '<tr><td class="DTTD">操作人员</td><td class="DDTD">';
             if($userObj) echo $userObj['userName'];
             echo '</td><td class="DTTD">操作时间</td><td class="DDTD">'.$orderItem['sendDate'].'</td></tr>';
        }
        if(substr($orderItem['completeDate'],0,10)!="0000-00-00") echo '<tr><td class="DTTD">完成时间</td><td class="DDTD" colspan=3>'.$orderItem['completeDate'].'</td></tr>';
        echo '</table>';
        echo '<table class=tbl_obj2 style="cursor:default; border-collapse: collapse;font-size:12px; font-family:Times New Roman; border-top:0px;" border=1">';

        echo '<tr class="menuBar fore">';
        echo '<TD style="width:80px;">商品编号</TD>';
        echo '<TD style="width:304px;">商品名称</TD>';
        echo '<TD style="width:48px;">数量</TD>';
        echo '<TD style="width:49px;">单位</TD>';
        echo '<TD style="width:60px;">卖价</TD>';
        echo '</tr>';

        for($i=0; $i<count($orderDetailArr); $i++){
            $productObj = $procProduct->GetProductItem($orderDetailArr[$i]['productIndex']);
            $productPackIndex = $orderDetailArr[$i]['packNum'];
            $marketPrice = $productObj['marketPrice'];
            if($productPackIndex){
                $packNum = $procProduct->GetProductPackageNumber($orderDetailArr[$i]['productIndex'], $productPackIndex);
                $marketPrice = $productObj['marketPrice']+ $procProduct->GetProductPackageMarketPrice($orderDetailArr[$i]->productIndex, $productPackIndex);
            }

            echo '<tr class="offRecord" style="cursor:default; background-color:white; text-align: center;">';
            echo '<TD style="width:80px;">'.$orderDetailArr[$i]['productCode'].'</TD>';
            echo '<TD style="width:304px; text-align: left; text-indent:5px;" class="itemInfoTD2">';
            if($productPackIndex) echo '<img style="float: left; height:9px; width:9px;padding-left:5px; padding-top:10px;cursor:pointer;" src="$baseUrl/images/bag_open.gif" border="none" class="packToggle" value="0">';
            echo '<p>'.$orderDetailArr[$i]['productName2'].' '.$orderDetailArr[$i]['productType'];
            if($productPackIndex)  echo " (优惠套装".$packNum.")";
            echo '</p>';
            if($productPackIndex){
                $packProducArr = $procProduct->GetProductPackageProductArr($orderDetailArr[$i]['productIndex'], $productPackIndex);
                echo '<div style="clear:both;"></div><div style="margin-left:40px;display:none;" class="packChild">';
                for($kk=0; $kk<count($packProducArr); $kk++){
                    echo '<p> '.$packProducArr[$kk]['productName2'].' '.$packProducArr[$kk]['productType'].' <font color=red>￥'.$packProducArr[$kk]['productPriceNow'].'</font></p><div style="clear:both;"></div>';
                }
                echo '</div>';
            }
            echo '</TD>';
            echo '<TD style="width:48px;">'.$orderDetailArr[$i]['orderAmount'].'</TD>';
            echo '<TD style="width:49px;">';
            if($productPackIndex) echo '条'; else echo '个';
            echo '</TD>';
            echo '<TD style="width:60px;">'.$orderDetailArr[$i]['orderPrice'].'</TD>';
            echo '</tr>';
        }
        echo '</table>';
        if(substr($orderItem['recvDate'],0,10)=="0000-00-00"){
            echo '<div style="width:550px; text-align:center; margin-top:8px;">';
            if(substr($orderItem['sendDate'],0,10)=="0000-00-00"){
                if($p_permit) echo '<a href="javascript:void(0);" onclick="VBSCRIPT:printFunc tblData">打印</a>&nbsp;&nbsp;&nbsp;';
                echo '<a href="javascript:void(0);" class="btnSendOK">确定</a>';
                echo '<script language="javascript">$("a.btnSendOK").click(function(){ sendOkFunction();});</script>';
            } 
            else 
            {
                echo '<div>确认配送单号 <input type=text style="border : 1px solid; border-color : red;width:200px;" id=checkSendTicketNumber></div>';
                echo '<a href="javascript:void(0);" class="btnSendComplete">完成配送</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btnSendCancel">取消配送</a>';
                echo '<script language="javascript">$("a.btnSendCancel").click(function(){ sendCancelFunction($("#checkSendTicketNumber").val());});$("a.btnSendComplete").click(function(){ sendCompleteFunction($("#checkSendTicketNumber").val());});</script>';
            }
            echo '</div>';
        }
        echo '<script language="javascript">$(".packToggle").click(function(){$(this).attr("value",(1-$(this).attr("value")));if($(this).attr("value")==1){$(this).siblings(".packChild").css("display", "block");$(this).attr("src", "$baseUrl/images/bag_close.gif");} else {$(this).siblings(".packChild").css("display", "none");$(this).attr("src", "$baseUrl/images/bag_open.gif");}});</script>';
    }
?>
<script type="text/javascript">
$(this).ready(function() {
        
    $('#checkSendTicketNumber').focus();
});
</script>