<style type="text/css">
tr.offRecord{background-color: #FFFFFF; font-family:"Times New Roman", "宋体"; }
</style>
<?php
            if($ticket_permit){
                echo '<table class=tbl_obj style="border-collapse: collapse;font-size:12px; font-family:Times New Roman;" border=1>';
                echo '<tr><td class="DTTD">客户名称</td><td class="DDTD">'.$orderItem['userName'].'</td></tr>';
                echo '<tr><td class="DTTD">用户名</td><td class="DDTD">'.$orderItem['userID'].'</td></tr>';
                echo '<tr><td class="DTTD">订单编号</td><td class="DDTD">'.$orderItem['orderTicketNumber'].'</td></tr>';
                echo '<tr><td class="DTTD">订单金额</td><td class="DDTD">'.$orderItem['orderMoney'].'</td></tr>';
                echo '<tr><td class="DTTD">已付款</td><td class="DDTD">';
                if(substr($orderItem['payCompleteDate'],0,10)=='0000-00-00'){
                    echo '<font color="#C60000">';
                    if(substr($orderItem['payInitialDate'],0,10)=='0000-00-00') echo '等待付款'; else echo '付款中';
                }else
                    echo '<font color="#0071C6">已付清';
                echo '</font>';
                echo '</td></tr>';
                echo '<tr><td class="DTTD">发票类型</td><td class="DDTD">';
                if($orderItem['invoiceType']== 1) echo '普通发票';
                if($orderItem['invoiceType']== 2) echo '增值税发票';
                echo '</td></tr>';
                if($orderItem['invoiceType']== 2){
                    echo '<tr><td class="DTTD">单位名称</td><td class="DDTD">'.$orderItem['reciptUnitName'].'</td></tr>';
                    echo '<tr><td class="DTTD">纳税人识别号</td><td class="DDTD">'.$orderItem['reciptName'].'</td></tr>';
                    echo '<tr><td class="DTTD">注册地址</td><td class="DDTD">'.$orderItem['reciptAddress'].'</td></tr>';
                    echo '<tr><td class="DTTD">注册电话</td><td class="DDTD">'.$orderItem['reciptTelNumber'].'</td></tr>';
                    echo '<tr><td class="DTTD">开户银行</td><td class="DDTD">'.$orderItem['reciptBank'].'</td></tr>';
                    echo '<tr><td class="DTTD">银行帐户</td><td class="DDTD">'.$orderItem['reciptAccount'].'</td></tr>';
                }
                if($orderItem['invoiceType']== 1){
                    echo '<tr><td class="DTTD">发票抬头</td><td class="DDTD">';
                    if($orderItem['invoiceTarget']== 0) echo '个人';
                    if($orderItem['invoiceTarget']== 1) echo '单位('.$orderItem['reciptUnitName'].')';
                    echo '</td></tr>';
                    echo '<tr><td class="DTTD">发票内容</td><td class="DDTD">';
                    switch($orderItem['invoiceContent']){
                        case 0: echo '明细'; break;
                        case 1: echo '办公用品'; break;
                        case 2: echo '电脑配件'; break;
                        case 3: echo '耗材'; break;
                    }
                    echo '</td></tr>';
                }
                echo '<tr><td class="DTTD">发票金额</td><td class="DDTD" style="text-align:center;">';
                if(substr($orderItem['ticketDate'],0,10)!="0000-00-00"){
                    echo $orderItem['ticketMoney'];
                } else {
                    if(substr($orderItem['payCompleteDate'],0,10)!="0000-00-00")
                        echo '<INPUT TYPE=TEXT id="ticketMoney" name="ticketMoney" style="width:95%;" value="'.$orderItem['orderMoney'].'">';
                }
                echo '</td></tr>';
                echo '<tr><td class="DTTD">备注</td><td class="DDTD" style="text-align:center;">';
                if(substr($orderItem['ticketDate'],0,10)!="0000-00-00"){
                    echo $orderItem['ticketContent'];
                } else {
                    if(substr($orderItem['payCompleteDate'],0,10)!="0000-00-00")
                        echo '<INPUT TYPE=TEXT id="ticketContent" name="ticketContent" style="width:95%;">';
                }
                echo '</td></tr>';
                echo '<tr><td class="DTTD">发票号码</td><td class="DDTD" style="text-align:center;">';
                if(substr($orderItem['ticketDate'],0,10)!="0000-00-00"){
                    echo $orderItem['ticketNumber'];
                } else {
                    if(substr($orderItem['payCompleteDate'],0,10)!="0000-00-00")
                        echo '<INPUT TYPE=TEXT id="ticketNumber" name="ticketNumber" style="width:95%;" value="'.$orderItem['orderTicketNumber'].'">';
                }
                echo '</td></tr>';
                echo '<tr><td class="DTTD">开票人员</td><td class="DDTD">';
                if(substr($orderItem['ticketDate'],0,10)!="0000-00-00"){  if($userObj) echo($userObj->userName);}
                echo '</td></tr>';
                echo '<tr><td class="DTTD">开票时间</td><td class="DDTD">';
                if(substr($orderItem['ticketDate'],0,10)!="0000-00-00") echo $orderItem['ticketDate'];
                echo '</td></tr>';
                echo '</table><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                if(substr($orderItem['ticketDate'],0,10)!="0000-00-00"){
                    if(substr($orderItem['completeDate'],0,10)=="0000-00-00")
                        echo '<a href="javascript:void(0);" class="btnCancelTicket">作废发票</a>';
                } else {
                    if(substr($orderItem['payCompleteDate'],0,10)!="0000-00-00")
                        echo '<a href="javascript:void(0);" class="btnSaveTicket">保存</a>';
                }
                
                if(($orderItem['invoiceType'])&&(substr($orderItem['ticketDate'],0,10)=='0000-00-00'))
                    echo '<script language="javascript">$("a.btnSaveTicket").click(function(){saveTicketFunc($("#ticketMoney").attr("value"), $("#ticketContent").attr("value"),$("#ticketNumber").attr("value"))});</script>';
                if(($orderItem['invoiceType'])&&(substr($orderItem['ticketDate'],0,10)!='0000-00-00'))
                    echo '<script language="javascript">$("a.btnCancelTicket").click(function(){cancelTicketFunc();});</script>';
            }
?>
