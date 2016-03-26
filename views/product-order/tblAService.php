<table class=tbl_obj style="border-collapse: collapse; display:block; width:750px; float:left; font-size:12px; font-family:Times New Roman;" border=1>
    <THEAD>
    <tr class="menuBar">
        <td style='width:110px;'>申请号</td>
        <td style='width:270px;'>商品名称</td>
        <td style='width:80px;'>类型</td>
        <td style='width:60px;'>申请人</td>
        <td style='width:130px;'>申请时间</td>  
        <td style='width:100px;'>处理状态</td>
    </tr>
    </THEAD>
    <TBODY id="inRecord">
<?php
    /*$repairStatusStrArr2  = array('售后服务申请', '审核通过', '', '撤消');*/
    /*$repairStatusStrArr  = array('等待审核', '正在处理', '成功', '已撤消');*/

    $noErr = true;
    $i = 0;
    $totalCount = count($retArray);
    foreach($retArray as $row)
    {
        $productArr = $procRepair->GetProductArraFromMain($row['repairIndex']);
        /*$productIndex = $procProduct->changeProductIndex($productArr[0]['productIndex']);
        if($productIndex)*/
        { 
            
?>
    <tr class="offRecord" value = "<?=$i?>" id=trRecord style="height:22px;" align=center>
        <td><?=$row['orderTicketNumber']?></td>
        <td>
        <?php 
            for($j=0; $j<count($productArr); $j++){
                if($j>0) echo "<BR>";
        ?>
<?=$productArr[$j]['productName2']?> <?=$productArr[$j]['productType']?><?php }?></td>
        <td><?php switch($row['repairType']){case 1: echo "换货";break;case 2: echo "退货";break;}?></td>
        <td><?=$row['userID']?></td>
        <td><?=$row['requestDate']?></td>
        <td><?php if($row['processStatus']=="2"){switch($row['repairType']){case 1: echo "换货";break;case 2: echo "退货";break;}}?><?php echo Yii::$app->params['repairStatusStrArr2'][$row['processStatus']];?></td>
    </tr>
<?php             
            
            $globalRgnCode = $procRegionObj->GetRegionCodeArray($row['regionIndex']);
            $rgnCodeArr = explode(",", $globalRgnCode);
?>
        <tr style="background-color: #EEEEFF; display: none;" class="detailRecord <?=$i?>" value = "<?=$i?>" id="repairRecord<?=$row['repairIndex']?>">
            <td colspan=6>
                <div style="margin-top:5px; margin-bottom:8px;">
                    <span class="titleSpan">联 系 人:</span> 
                    <span class="contentSpan" style="width:200px;"><?=$row['contactName']?></span>
                    <span class="titleSpan">联系电话:</span> 
                    <span class="contentSpan" style="width:250px;"><?=$row['phoneNumber']?></span>
                    <span class="titleSpan">售后服务地点:</span> 
                    <span class="contentSpan"><?php switch($row['positionType']){case "0": echo "丹东市内";break; case "1": echo "凤城市内"; break; case "2": echo "东港市内"; break; case "3": echo "其他地区"; break;}?></span>
                    <span class="titleSpan">商品交付:</span> 
                    <span class="contentSpan"><?php switch($row['carrType']){ case "0": echo "商城上门取货"; break; case "1": echo "用户送货到店"; break; case "2": echo "用户发货到店"; break;}?></span>
<?php if($row['repairType'] == 1){?>
                    <span class="titleSpan">商品送还:</span> 
                    <span class="contentSpan"><?php switch($row['sendType']){ case "0": echo "送货上门"; break; case "1": echo "快递运输"; break; case "2": echo "店面自提"; break;}?></span>
<?php }?>
<?php if($row['carrType'] == 0){?>
                    <span class="titleSpan">取货地址:</span> 
                    <span class="contentSpan"><?=$row['getAddress']?></span>
                    <span class="titleSpan">取货时间:</span> 
                    <span class="contentSpan"><?=$row['getTime']?></span>
<?php }?>
<?php if($row['repairType'] == 1){?>
                    <span class="titleSpan">收货地址:</span> 
                    <span class="contentSpan"><?=$row['sendAddress']?></span>
<?php }?>
                    <span class="titleSpan">商品外观状况:</span> 
                    <span class="contentSpan" style="width:600px;"><?php switch($row['shapeType']){case 1: echo "完好";break;case 2: echo "轻微划痕";break;case 3: echo "明显破损";break;}?></span>
                    <span class="titleSpan">外包装状况:</span> 
                    <span class="contentSpan" style="width:600px;"><?php switch($row['packType']){case 1: echo "包装完整";break;case 2: echo "包装破损";break;case 3: echo "无包装";break;}?></span>
                    <span class="titleSpan">商品附件状况:</span> 
                    <span class="contentSpan" style="width:600px;"><?php switch($row['collateralCondition']){case 1: echo "齐全";break;case 2: echo "纸质附件丢失";break;case 3: echo "商品配件丢失";break;}?></span>
                    <span class="titleSpan">三包凭证:</span> 
                    <span class="contentSpan" style="width:600px;"><?php if($row['reportCheck']>0) echo "有"; else echo "没有";?></span>
                    <span class="titleSpan">发票:</span> 
                    <span class="contentSpan" style="width:600px;"><?php if($row['receiptCheck']>0) echo "有"; else echo "没有";?></span>
                    <span class="titleSpan">问题描述:</span> 
                    <span class="contentSpan" style="width:600px;"><?=$row['repairContent']?></span>
                    <span class="titleSpan">备注:</span> 
                    <span class="contentSpan" style="width:600px;"><?=$row['repairNote']?></span>
                    <div style="clear:both;"></div>
            <table style="border-collapse:collapse; margin:10px 0px 10px 0px;" cellspacing=0 cellpadding=0>
                <tr class="menuBar">
                    <td style="width:80px;">操作名称</td><td style="width:120px;">操作时间</td><td style="width:80px;">登陆IP</td><td style="width:80px;">操作人员</td><td style="width:300px;">备注</td>
                </tr>
<?php 
        $fldName=$repairStatusDateStrArr[0];
        $dateStr = $row["$fldName"];
        if(substr($dateStr,0,10)!="0000-00-00"){
?>                <tr style="background-color:white; height:20px; text-align:center;">
                    <td><?=Yii::$app->params['repairStatusStrArr2'][0]?></td><td><?=$dateStr?></td><td></td><td></td><td></td>
                </tr>
<?php }
    
        $logDataArr = $procRepair->GetHistoryDataForOrder($row['repairIndex']);
        foreach($logDataArr as $s_row)
        {
?>
                <tr style="background-color:white; height:20px; text-align:center;">
                <td><?=$s_row['historyTitle']?></td><td><?=$s_row['historyDate']?></td><td><?=$s_row['historyIP']?></td><td><?=$s_row['userName']?></td><td style="width:300px; text-align:left; text-indent:10px;"><?=$s_row['historyContent']?></td>
                </tr>
<?php 
        }
?>
            </table>
                    <span class="titleSpan" style="width:700px;">
                    <?php if(($row['processStatus']<2)){
?>备注 <input type=text id="historyContent<?=$row['repairIndex']?>" name="historyContent<?=$row['repairIndex']?>" style="width:400px; border: solid 1px #999999;">&nbsp;&nbsp;&nbsp;<a href="javascript:processRepair(<?=$row['repairIndex']?>,<?=$row['processStatus']+1?>);"><?php if($row['processStatus']=="1"){switch($row['repairType']){case 1: echo "换货";break;case 2: echo "退货";break;}}?><?=Yii::$app->params['repairStatusStrArr2'][$row['processStatus']+1]?></a>&nbsp;&nbsp;&nbsp;<a href="javascript:processRepair(<?=$row['repairIndex']?>,3);">撤销&nbsp;&nbsp;&nbsp;<?php }?>
                        <a href="javascript:void(0);" class="closeThis">关闭</a>
                    </span>
                    <div style="clear:both;"></div>
                </div>
            </td>
        </tr>
<?php 
                        }
                        $i++;
                    }
?>  
</TBODY>
</table>

<div style="float: none;">
<?php
    //echo "<style> .navBar1{ margin-top: 50px; display:block;}</style>";
    $addStyle = true;
//    $this->renderPartial('//global/pageButton1', array(
//        'numResult' => $retCount,
//        'n' => $n,
//        'curPage' => $curPage,
//        'addStyle'=> $addStyle,
//    ));
?>
</div>

<script language="javascript">
    $(document).ready(function () {
        $(".closeThis").click(function(){
            $(this).parent().parent().parent().parent().hide();
        });
        $(".offRecord").click(function(){
            
            $("TR.detailRecord").hide();
            $(this).next().show();
          /*  if($(this).next().attr("display") == null){
                //alert();
                //$("TR.detailRecord ." + index).attr("dispaly", "block");
              //  $("#inRecord .detailRecord").hide();
                $(this).next().slide();
                //$("TR .detailRecord ." + index).show();
            }else
            {
                alert();
                //$("TR.detailRecord").hide();
                $("#inRecord .detailRecord").hide();
            }    */
                
            
            /*if($("TR.detailRecord").attr("display", "none"))
            {
                //alert("hide");
                $("TR.detailRecord").hide();
                $(this).next().show();
            }
            else{
                alert("show");
                $("TR.detailRecord").show();
                $(this).next().hide();    
            }*/
        });
        $('.navBar1 a').click(function() {
            if($(this).attr('value') > 0)
                reloadInputRecord($(this).attr("value"));
        });    
        
    });
    
</script>
