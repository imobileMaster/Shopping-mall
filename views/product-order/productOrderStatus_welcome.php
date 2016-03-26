<?php
    $baseUrl = Yii::$app->request->baseUrl.'/../../assets';
    if($r_permit){
        //logUserHistory(36, 1);
?>
<!-- this is for a calendar-->
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<link rel="stylesheet" href="<?=$baseUrl?>/css/jquery.ui.all.css">

<script src="<?=$baseUrl?>/js/ui/jquery.ui.core.js"></script>
<script src="<?=$baseUrl?>/js/ui/jquery.ui.widget.js"></script>
<script src="<?=$baseUrl?>/js/ui/jquery.ui.datepicker.js"></script>
<!-- this is for a calendar-->

<STYLE type="text/css">
    .span-19 {width:100%; height:650px; overflow-y:auto; background-color:#BBBBBB}

    *{margin:0; padding:0;font-family:宋体;}
    TABLE.tbl_obj,TABLE.tbl_obj TD{border:solid 1px black;}
    SELECT, INPUT{font-family: Times New Roman; border: 0; font-size:14px;}
    .offRecord IMG{cursor:pointer;}
    div.productImageList{float:left; height:190px; width:160px;}
    div.titleProduct{padding:5px 0 3px 20px; margin-bottom:5px;background-color: #EEFFEE; color: #226622; width: 930px;}
    SELECT{margin:0 5px 3px 0;}
    DIV#menuObj{margin-top:5px; margin-bottom:5px;}
    SPAN.itemObj{float:left; height:18px; line-height:18px; width:80px; display:block; font-size:13px; border:solid 1px white; border-left:0px; text-align: center; background-color:#CCCCCC; cursor:pointer;}
    SPAN.itemObj.fore{border-left:solid 1px white;}
    SPAN.itemObj.overCls{background-color:#BBBBBB;}
    SPAN.itemObj.curr{color: mediumblue; background-color:#99CC99;}
    TR.currTR{background-color: #EEFFEE;}
</style>

<div style="height:550px; overflow-y:auto; margin:20px;">
    <form name="frmlist" id = "frmlist" method="GET" action='productorderdetail'>
        <input type=hidden id="startDate2" name="startDate2" value="<?=$startDate2?>">
        <input type=hidden id="endDate2" name="endDate2" value="<?=$endDate2?>">
        <input type=hidden id="orderIndex" name="orderIndex" value="">
		<input type=hidden id="orderStatus" name="orderStatus" value="<?=$orderStatus?>">
    </form>
    <input id="startDate" value="<?=$startDate2?>" style="text-align:center; width:80px;"> ~
    <input id="endDate" value="<?=$endDate2?>" style="text-align:center; width:80px;"> 订单号
    <input type=text id="orderTicketNumber" name="orderTicketNumber" size=8 value="" style="margin:0 5px 3px 0;" >

    <?php for($i=0; $i<10; $i++) echo "&nbsp;";?>
    <span style="font-weight:bold;font-size:16px;">商品订单</span>

    <div id="menuObj">
        <span class="itemObj fore" value="-1">所有</span>
		<span class="itemObj" value="0">新订单</span>
		<span class="itemObj" value="1">未付款</span>
		<span class="itemObj" value="2">未付清</span>
		<span class="itemObj" value="3">未送货</span>
		<span class="itemObj" value="4">未签收</span>
		<span class="itemObj" value="5">未开发票</span>
		<span class="itemObj" value="6">己发货</span>
		<span class="itemObj" value="7">己签收</span>
		<span class="itemObj" value="8">已付清</span>
		<span class="itemObj" value="9">己完了</span>
		<span class="itemObj" value="10">己取消</span>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!--<input type=button value="打印" style="width:60px; height:20px; font-size:16px; border:solid 1px black; cursor:pointer;" class="printCmd">-->

    <div style="clear:both;"></div>
    <div id = "tablelist">
    <?php echo $cont_potable;?>
    </div>
</div>

<script language="javascript">
    $(document).ready(function(){
        $("SPAN.itemObj").eq("<?=$orderStatus+1?>").addClass("curr");
        $( "#startDate" ).datepicker({
            showOn: "button",
            buttonImage: "<?=$baseUrl?>/images/cal.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            onSelect: function(){
                if($("#startDate").attr("value")>$("#endDate").attr("value"))
                    alert("清选择好日期。");
                $("#startDate2").attr("value", $("#startDate").val());
                $("#endDate2").attr("value", $("#endDate").val());
                reloadInputRecord(1);
            }
        });

        $( "#endDate" ).datepicker({
            showOn: "button",
            buttonImage: "<?=$baseUrl?>/images/cal.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            onSelect: function(){
                if($("#startDate").attr("value")>$("#endDate").attr("value")) alert("清选择好日期。");
                $("#startDate2").attr("value", $("#startDate").val());
                $("#endDate2").attr("value", $("#endDate").val());
                reloadInputRecord(1);
            }
        });
    });

    $("SPAN.itemObj").mouseover(function(){
        if(!($(this).hasClass("curr"))) $(this).addClass("overCls");
    }).mouseout(function(){
        if(!($(this).hasClass("curr"))) $(this).removeClass("overCls");
    }).click(function(){
        if(!($(this).hasClass("curr"))){
            $(this).siblings().removeClass("curr").removeClass("overCls");
            $(this).addClass("curr");
            $("#orderStatus").attr("value", $(this).attr("value"));
            reloadInputRecord(1);
        }
    });

    function reloadInputRecord(curPage)
    {
        $.ajax({
			type:"POST",
			url:'orderstatus',
			data:
			{
				startDate2:$("#startDate2").val(),
				endDate2:$("#endDate2").val(),
				orderStatus:$("#orderStatus").val(),
                orderTicketNumber:$("#orderTicketNumber").val(),
                curPage:curPage,
			},
			success: function (result) {
				$('#tablelist').html(result);
			},
			error:function (x,e) {
				alert("###The call to the server side failed. "+x.responseText);
			}
        });
    }
    window.loadEvent = function(){
        $("#startDate2").attr("value", $("#startDate").attr("value"));
        $("#endDate2").attr("value", $("#endDate").attr("value"));
        if($("#startDate").attr("value")>$("#endDate").attr("value")) alert("清选择好日期。");
        reloadInputRecord(1);
    }

    $("#orderTicketNumber").keydown(function(e)
    {
        if(e.keyCode == 13){
            reloadInputRecord(1);
        }
    });
</script>
<?php
    }
?>
