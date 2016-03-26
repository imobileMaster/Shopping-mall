<?php
    $baseUrl = Yii::$app->request->baseUrl.'/../../assets';
//    echo $baseUrl;
?>
<script language="javascript" src="<?=$baseUrl?>/js/jquery-1.4.2.min.js"></script>
<script language="javascript" src="<?=$baseUrl?>/js/global.js"></script>
<LINK href="<?=$baseUrl?>/css/main.css" type=text/css rel=stylesheet>
<style>
    a{color: mediumblue; text-decoration:none; font-size:13px;}
    a:hover{color: red;}
    TABLE.tbl_obj TD{border:solid 1px black;}
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
<SELECT size=1 id=repairType onchange="javascript: reloadInputRecord(1);" style="width:65px;">
    <OPTION value="-1">所有</OPTION>
    <OPTION value="1">换货</OPTION>
    <OPTION value="2">退货</OPTION>
</SELECT>
<SELECT size=1 id=processStatus onchange="javascript: reloadInputRecord(1);" style="width:120px;">
    <OPTION value="-1">所有</OPTION>
<?php for($i=0; $i<count(Yii::$app->params['repairStatusStrArr']); $i++){?>
    <OPTION value="<?=$i?>"><?=Yii::$app->params['repairStatusStrArr'][$i]?></OPTION>
<?php }?>
</SELECT>
申请号
<input type=text id="orderTicketNumber" name="orderTicketNumber" size=8 value="" style="margin:0 5px 3px 0;"></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="font-weight:bold;font-size:16px;">售后服务</span>
</div>
<div class="eachPage">
    <?php echo $cont_tblaservice;?>
</div>
<input type=hidden id="procRepairIndex" name="procRepairIndex" value="0">
</div>

<script language="javascript">
    orderYear.value = "<?=Date("Y")?>";
    orderMonth.value = "<?=Date("n")?>";
    repairType.value = -1;
    processStatus.value = -1;

    $(document).ready(function(){
        if(navigator.appName == "Microsoft Internet Explorer"){
            SelObjAdder("orderYear");
            SelObjAdder("orderMonth");
            SelObjAdder("repairType");
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
            url: 'p-func-module25',
            data: {
                'orderYear':$("#orderYear").val(),
                'orderMonth':$("#orderMonth").val(),
                'repairType':$("#repairType").val(),
                'processStatus':$("#processStatus").val(),
                'orderTicketNumber':$("#orderTicketNumber").val(),
                'curPage':curPage
            },
            success: function(result){
                $(".eachPage").html(result);
            },
            error: function(x,e){
                alert(x.responseText);
            }
        });
    }

    function processRepair(repairIndex, processStatus)
    {
        historyContent = $("#historyContent" + repairIndex).attr("value");
        $("#procRepairIndex").attr("value", repairIndex);

        $.ajax({
            type: "POST",
            url: 'process-repair',
            data: {
                repairIndex:repairIndex,
                processStatus:processStatus,
                historyContent:historyContent
            },
            success: function(result){
                reloadInputRecord(1);
            },
            error: function(x,e){
                alert(x.responseText);
            }
        });
    }
</script>
