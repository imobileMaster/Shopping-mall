<table class=tbl_obj style="border-collapse: collapse; display:block; width:750px; float:left; font-size:12px; font-family:Times New Roman;" border=1>
    <THEAD>
    <tr class="menuBar">
        <td style='width:200px;'>退款方式</td>
        <td style='width:150px;'>退款金额</td>
        <td style='width:120px;'>涉及订单</td>
        <td style='width:130px;'>申请人</td>
        <td style='width:130px;'>申请时间</td>
        <td style='width:100px;'>处理状态</td>
    </tr>
    </THEAD>
    <TBODY id="inRecord">
<?php
    $returnStatusDateStrArr = array('requestDate', 'processDate', 'completeDate', 'cancelDate');
       
    foreach($retArray as $row)    
    {
        $cardPrice = $procGiftCard->GetCardPrice($row['orderIndex']);
?>
    <tr class="offRecord" id=trRecord style="height:22px;" align=center>
        <td><?php echo Yii::$app->params['returnKindStrArr'][$row['returnType']];?></td>
        <td><?=sprintf("%01.2f", $row['orderMoney']+$cardPrice)?></td>
        <td><?=$row['orderTicketNumber']?></td>
        <td><?=$row['requestName']?> <font color="#552200">(<?=$row['userID']?>)</font></td>
        <td><?=$row['requestDate']?></td>
        <td><?=Yii::$app->params['returnStatusStrArr'][$row['processStatus']]?></td>
    </tr>
    <tr style="background-color: #EEEEFF; display: none;" class="detailRecord" id="returnRecord<?=$row['returnIndex']?>">
        <td colspan=6>
            <div style="margin-top:5px; margin-bottom:8px;">
                <span class="titleSpan">联系电话:</span> 
                <span class="contentSpan"><?=$row['requestPhoneNumber']?></span>
                <span class="titleSpan">退款原因:</span> 
                <span class="contentSpan"><?=$row['requestContent']?></span>
            <table style="border-collapse:collapse; margin:10px 0px 10px 0px;" cellspacing=0 cellpadding=0>
                <tr class="menuBar">
                    <td style="width:80px;">操作名称</td><td style="width:120px;">操作时间</td><td style="width:80px;">登陆IP</td><td style="width:80px;">操作人员</td><td style="width:300px;">备注</td>
                </tr>
<?php 
        $fldName=Yii::$app->params['returnStatusDateStrArr'][0];
        $dateStr = $row[$fldName];
        if(substr($dateStr,0,10)!="0000-00-00"){
?>
        <tr style="background-color:white; height:20px; text-align:center;">
            <td><?=Yii::$app->params['returnStatusStrArr2'][0]?></td><td><?=$dateStr?></td><td></td><td></td><td></td>
        </tr>
<?php }
    
        $logDataArr = $procReturn->GetHistoryDataForOrder($row['returnIndex']);
        foreach($logDataArr as $s_row){
?>
            <tr style="background-color:white; height:20px; text-align:center;">
            <td><?=$s_row['historyTitle']?></td><td><?=$s_row['historyDate']?></td><td><?=$s_row['historyIP']?></td><td><?=$s_row['userName']?></td><td style="width:300px; text-align:left; text-indent:10px;"><?=$s_row['historyContent']?></td>
            </tr>
<?php 
        }
?>
            </table>
                <span class="titleSpan" style="width:700px;">
                    <?php if(($row['processStatus'] < 2)){?>
                    备注 <input type=text id="historyContent<?=$row['returnIndex']?>" name="historyContent<?=$row['returnIndex']?>" style="width:400px; border: solid 1px #999999;">&nbsp;&nbsp;&nbsp;<a href="javascript:processReturn(<?=$row['returnIndex']?>,<?=$row['processStatus']+1?>,'<?=$row['orderIndex']?>');"><?=Yii::$app->params['returnStatusStrArr2'][$row['processStatus']+1]?>&nbsp;&nbsp;&nbsp;<a href="javascript:processReturn(<?=$row['returnIndex']?>,3,'<?=$row['orderIndex']?>');">撤销&nbsp;&nbsp;&nbsp;<?php }?>
                    <a href="javascript:void(0);" class="closeThis">关闭</a>
                </span>
                <div style="clear:both;"></div>
            </div>
        </td>
    </tr>
<?php         
    }
?>

    </TBODY>
</table>

<?php
    //echo "<style> .navBar1{ margin-top: 50px; display:block;}</style>";
    $addStyle = true;
    echo $mycon->renderPartial('//global/pageButton1', array(
        'numResult' => $retCount,
        'n' => $n,
        'curPage' => $curPage,
        'addStyle'=> $addStyle,
    ));
?>
</div>

<script language="javascript">
    $(".closeThis").click(function(){
        $(this).parent().parent().parent().parent().hide();
    });
    $(".offRecord").click(function(){
        $("TR.detailRecord").hide();
        $(this).next().show();
    });
    
    $('.navBar1 a').click(function() {
        if($(this).attr('value') > 0)
            reloadInputRecord($(this).attr("value"));
    });
</script>
