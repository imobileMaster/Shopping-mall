<?php
    $baseUrl = Yii::$app->request->baseUrl.'/../../assets';
?>

<script language="javascript" src="<?=$baseUrl?>/js/jquery-1.4.2.min.js"></script>
<script language="javascript" src="<?=$baseUrl?>/js/global.js"></script>
<LINK href="<?=$baseUrl?>/css/main.css" type=text/css rel=stylesheet>

<style>
    a{color: mediumblue; text-decoration:none; font-size:13px;}
    a:hover{color: red;}
    TABLE.tbl_obj,TABLE.tbl_obj TD{border:solid 1px black;}
    SELECT, INPUT{font-family: Times New Roman; border: 0; font-size:14px;}
    .offRecord IMG{cursor:pointer;}
    div.titleProduct{padding:5px 0 3px 20px; margin-bottom:5px;background-color: #EEFFEE; color: #226622; width: 930px;}
    SELECT{margin:0 5px 3px 0;}
    SPAN.titleSpan{display:block; float:left; font-weight:bold; color: #222233; width:100px; text-align:right;line-height:24px; height:24px; margin-right:10px;}
    SPAN.contentSpan{display:block; float: left; color: #333333; width:525px; line-height:24px; height:24px;}
</style>

<div class="mainPage">
<div style="width:980px;">
<font style="font-size:12px;">
<SELECT size=1 id=orderYear onchange="javascript: reloadInputRecord(1);" style="width:65px;">
<?php for($i = 2011; $i <= Date("Y"); $i++){?>
    <OPTION value="<?=$i?>"><?=$i?></OPTION>
<?php }?>
</SELECT> 年
<SELECT size=1 id=orderMonth onchange="javascript: reloadInputRecord(1);" style="width:65px;">
    <OPTION value="0">全体</OPTION>
<?php for($i = 1; $i <= 12; $i++){?>
    <OPTION value="<?=$i?>"><?=$i?></OPTION>
<?php }?>
</SELECT> 月
<SELECT size=1 id=processStatus onchange="javascript: reloadInputRecord(1);" style="width:95px;">
    <OPTION value="-1">所有</OPTION>
<?php for($i=0; $i<count(Yii::$app->params['returnStatusStrArr']); $i++){?>
    <OPTION value="<?=$i?>"><?=Yii::$app->params['returnStatusStrArr'][$i]?></OPTION>
<?php }?>
</SELECT>
申请号
<input type=text id="orderTicketNumber" name="orderTicketNumber" size=8 value="" style="margin:0 5px 3px 0;"></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight:bold;font-size:16px;">退款申请</span>
</div>
<div class = 'eachPage'>
    <?php
        echo $mycon->renderPartial('tblCancelAsk', array(
            'procReturn'=>$procReturn,
            'procGiftCard'=>$procGiftCard,
            'retArray'=>$retArray,
            'returnStatusStrArr'=>$returnStatusStrArr,
            'retCount' => $retCount,
            'n' => $n, 
            'curPage' => $curPage,
            'mycon'=>$mycon,
        ));
    ?>
</div>
<input type=hidden id="procReturnIndex" name="procReturnIndex" value="0">
</div>
<script language="javascript">

    orderYear.value = "<?=Date("Y")?>";
    orderMonth.value = "<?=Date("n")?>";
    processStatus.value = "-1";
    
    $(document).ready(function(){
        if(navigator.appName == "Microsoft Internet Explorer"){
            SelObjAdder("orderYear");
            SelObjAdder("orderMonth");
            SelObjAdder("processStatus");
        }
        $("#orderTicketNumber").keydown(function(e){
            if(e.keyCode == 13){
                reloadInputRecord(1);
            }
        });
    });
    
    function reloadInputRecord(curPage)
    {
        $.ajax({
            type: "POST",
            url: 'p-func-module27',
            data: {
                'orderYear':$("#orderYear").val(),
                'orderMonth':$("#orderMonth").val(),
                'processStatus':$("#processStatus").val(),
                'orderTicketNumber':$("#orderTicketNumber").val(),
                'curPage':curPage
            },
            success: function(result){
                //alert('jks');
                $(".eachPage").html(result);
            },
            error: function(x,e){
                alert('## Error ## -- '+x.responseText);
            }
        });
    }
    
    function processReturn(returnIndex, returnStatus, orderIndex)
    {
        alert('jks');
//        historyContent = $("#historyContent" + returnIndex).attr("value");
//        $("#procReturnIndex").attr("value", returnIndex);
//        $.post("../product/procFunctionModule.php", {caseNum:28,returnIndex:returnIndex, orderIndex:orderIndex, returnStatus:returnStatus, historyContent:historyContent}, function(data){
//            reloadInputRecord();
//        });
    }
</script>
