<?php
    use app\models\GlobalFunc;
?>
<table style="border-collapse: collapse;" cellspacing="0" cellpadding="0" border="1" id="tblData" name="tblData" class="tbl_obj">
    <THEAD>
    <tr class="menuBar">
        <td style='width:120px;'>订单编号</td>
        <td style='width:100px;'>加盟商</td>
        <td style='width:100px;'>客户名称</td>
        <td style='width:100px;'>用户名</td>
        <td style='width:80px;'>下单时间</td>
        <td style='width:80px;'>订单金额</td>
        <td style='width:80px;'>实收金额</td>
        <td style='width:50px;'>发票</td>
        <td style='width:90px;'>付款方式</td>
        <td style='width:80px;'>订单状态</td>
        <td style='width:80px;'>付款</td>
        <td style='width:80px;'>物流状态</td>
        <td style='width:80px;'>完成</td>
    </tr>
    </THEAD>
    <TBODY id="inRecord">
        <?php
        foreach ($retArray as $row) {
            $strTitle= "收货人姓名:  ".$row['recvName'];
            if($row['recvAddress']!="") $strTitle.= "\n地 址:  ".$row['recvAddress'];
            if($row['recvPostBox']!="") $strTitle.= "\n邮政编码:  ".$row['recvPostBox'];
            if($row['recvPhoneNumber']!="") $strTitle.= "\n手机号码:  ".$row['recvPhoneNumber'];
            if($row['recvTelNumber']!="") $strTitle.= "\n固定电话:  ".$row['recvTelNumber'];
            if($row['recvEmailAddress']!="") $strTitle.= "\n电子信箱:  ".$row['recvEmailAddress'];
            $strTitle.= "\n支付方式:  ";

            $strTitle2 = GlobalFunc::GetPayKindStr($row['payKind']);
            $strTitle.= $strTitle2;
        ?>

        <tr class="offRecord" id=trRecord value="<?=$row['orderIndex']?>" style="height:22px;" align=center title="<?=$strTitle?>" pseudoCheck="<?=$row['pseudoCheck']?>">
            <td><?=$row['orderTicketNumber']?></td>
            <td><?php if($row['pseudoCheck']){?>丹东商城<?php }else{ echo "商城";/*$procProductOrder->GetPrimaryName($row['orderIndex']);*/}?></td>
            <td><?=$row['userName']?></td>
            <td><?=$row['userID']?></td>
            <td><?=substr($row['orderDate'],0,10)?></td>
            <td><?=$row['orderMoney']?></td>
            <td><?=$row['recvMoney']?></td>
            <td><?php if($row['invoiceType']== 0){?>不需<?php } else {if(substr($row['ticketDate'],0,10)=='0000-00-00'){?>未开<?php }else{?>已开<?php }}?></td>
            <td><?=$strTitle2?></td>
            <td><?php if(substr($row['orderCancelDate'],0,10)!='0000-00-00'){?><font color="#00B252">已取消<?php }else{?><?php if(substr($row['confirmDate'],0,10)=='0000-00-00'){?><font color="#C60000">等待确认<?php }else{?><font color="#0071C6">已确认<?php }?><?php }?></font></td>
            <td><?php if(substr($row['orderCancelDate'],0,10)=='0000-00-00'){?><?php if(substr($row['payCompleteDate'],0,10)=='0000-00-00'){?><font color="#C60000"><?php if(substr($row['payInitialDate'],0,10)=='0000-00-00'){?>未付款<?php }else{?>付款中<?php }}else{?><font color="#0071C6">已付清<?php }?></font><?php }?></td>
            <td><?php if(substr($row['orderCancelDate'],0,10)=='0000-00-00'){?><?php if(substr($row['recvDate'],0,10)=='0000-00-00'){?><font color="#C60000"><?php if(substr($row['sendDate'],0,10)=='0000-00-00'){if(substr($row['productOutDate'],0,10)=='0000-00-00'){?>等待出庫<?php }else{?>未配送<?php }}else{?>配送中<?php }}else{?><font color="#0071C6">配送完成<?php }?></font><?php }?></td>
            <td><?php if(substr($row['orderCancelDate'],0,10)=='0000-00-00'){?><?php if(substr($row['completeDate'],0,10)=='0000-00-00'){?><font color="#C60000">未完成<?php }else{?><font color="#00B252">完成<?php }?></font><?php }?></td>
        </tr>
        <?php } ?>
    </TBODY>
</table>
<?php
    $addStyle = true;
//    echo $mycon->renderPartial('//global/pageButton1', array(
//        'numResult' => $retCount,
//        'n' => $n,
//        'curPage' => $curPage,
//        'addStyle'=> $addStyle,
//    ));

?>
<script type="text/javascript">
    $("TR.offRecord").mouseover(function(){$(this).addClass("currTR")}).mouseout(function(){$(this).removeClass("currTR")}).click(function(){
        $("#orderIndex").attr("value", $(this).attr("value"));
        $("#frmlist").submit();
    });
    $('.navBar1 a').click(function() {
        if($(this).attr('value') > 0)
            reloadInputRecord($(this).attr("value"));
    });
</script>