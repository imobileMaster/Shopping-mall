<?php
    $baseUrl = Yii::$app->request->baseUrl.'/../../assets';
    //CheckOrderPermit();
    if($pay_permit)
    {
        echo '<table class=tbl_obj style="border-collapse: collapse;font-size:12px; font-family:Times New Roman;" border=1>';
        echo '<tr><td class="DTTD" style="width:112px;">客户名称</td><td class="DDTD">'.$orderItem['userName'].'</td><td class="DTTD" style="width:112px;">用户名</td><td class="DDTD">'.$orderItem['userID'].'</td></tr>';
        echo '<tr><td class="DTTD">订单编号</td><td class="DDTD">'.$orderItem['orderTicketNumber'].'</td><td class="DTTD">订单金额</td><td class="DDTD">'.$orderItem['orderMoney'].'</td></tr>';
        echo '<tr><td class="DTTD">付款状态</td><td class="DDTD">';
        if(substr($orderItem['payCompleteDate'],0,10)=='0000-00-00'){
            echo '<font color="#C60000">';
            if(substr($orderItem['payInitialDate'],0,10)=='0000-00-00') echo '等待付款'; else echo '付款中';
        }else
            echo '<font color="#0071C6">已付清';
        echo '</font>';
        echo '</td><td class="DTTD">总付款金额</td><td class="DDTD">'.$orderItem['recvMoney'].'</td></tr></table>';
        echo '<table class=tbl_obj2 style="cursor: default;  border-collapse: collapse;font-size:12px; font-family:Times New Roman; border-top:0px;" border=1>';
        echo '<tr class="menuBar fore"><TD style="width:80px;">付款类型</TD><TD style="width:90px;">单据号码</TD><TD style="width:60px;">付款金额</TD><TD style="width:';
        if(substr($orderItem['completeDate'],0,10)!='0000-00-00') echo '150'; else echo '109';
        echo 'px;">备注</TD><TD style="width:70px;">操作人员</TD><TD style="width:90px;">操作时间</TD>';
        if(substr($orderItem['completeDate'],0,10)=='0000-00-00') echo '<TD style="width:40px;">操作</TD>';
        echo '</tr>';
        if((substr($orderItem['completeDate'],0,10)=='0000-00-00')&&(substr($orderItem['payCompleteDate'],0,10)=='0000-00-00')&&($orderItem['payKind']>= 0)){
            echo '<tr class="offRecord" style="background-color:white; text-align: center;">';
            echo '<td><SELECT id="payKind" style="width:100%; border:0;">';
            for($i=1; $i<count(Yii::$app->params['payKindStrArr']); $i++)
            {
                echo '<OPTION value="'.$i.'"';
                if($orderItem['payKind']== $i) echo ' SELECTED';
                echo '>'.Yii::$app->params['payKindStrArr'][$i].'</OPTION>';
            }
            echo '</SELECT></td>';
            echo '<td><input type=text id="moneyNumber" style="width:96%;"></td><td><input type=text id="moneyAmount" style="width:94%;" limitAmount="'.($orderItem['orderMoney']-$orderItem['recvMoney']).'"></td><td><input type=text id="moneyInfo" style="width:96%;"></td><td></td><td></td><td class="btnSavePay"><img src="'.$baseUrl.'/images/save_on.gif"></td>';
            echo '</tr>';
        }
        
        for($i=0; $i<count($orderMoneyArr); $i++){
            echo '<tr class="offRecord" style="background-color:white; text-align: center; height:20px;">';
            echo '<td>';
            echo $payKindStr;
            echo '</td>';
            echo '<td>'.$orderMoneyArr[$i]['moneyNumber'].'</td><td>'.$orderMoneyArr[$i]['moneyAmount'].'</td><td>'.$orderMoneyArr[$i]['moneyInfo'].'</td><td>';
            if($orderMoneyArr[$i]['userName']!= "") echo $orderMoneyArr[$i]['userName']; else echo $userID;
            echo '</td><td>'.substr($orderMoneyArr[$i]['payDate'],0,10).'</td>';
            if(substr($orderItem['completeDate'],0,10)=='0000-00-00'){
                if($orderMoneyArr[$i]['payKind']>0) echo '<td onclick="javascript:delPayRecord('.$orderMoneyArr[$i]['moneyIndex'].');"><img src="'.$baseUrl.'/images/delete_on.gif"></td>';
                else echo '<td></td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        if(substr($orderItem['completeDate'],0,10)=='0000-00-00')
            echo '<script language="javascript">$("TD.btnSavePay").click(function(){savePayFunc($("#payKind").val(), $("#moneyNumber").val(),$("#moneyAmount").val(),$("#moneyInfo").val(), $("#moneyAmount").attr("limitAmount"))});</script>';
    }  
?>
