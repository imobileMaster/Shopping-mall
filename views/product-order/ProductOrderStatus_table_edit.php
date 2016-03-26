<?php
use yii\helpers\Url;
if($u_permit_order)
{
    $baseUrl = Yii::$app->request->baseUrl.'/../../assets';
?>
<!--<script language="javascript" src="--><?//=$baseUrl?><!--/js/jquery-1.4.2.min.js"></script>-->
<link type="text/css" rel="stylesheet" href="<?=$baseUrl?>/css/Account.css">

<STYLE>
    .btnArr{text-align:center; margin:10px;}
    .btnArr A{color: mediumblue; text-decoration:none; font-size:14px; padding-left:40px;}
    .btnArr A:hover{color:red; text-decoration: underline;}
    .tb1{width:750px;}
</STYLE>
<script type="text/javascript" src="<?=$baseUrl?>/js/jquery.validate.js"></script>
<script language="javascript" src="<?=$baseUrl?>/js/Account.js"></script>
<div class="wrap">
  <div class="centerSec">
	<div class="titlebar">填写核对订单信息</div>
	<div class="mc1">
		
        <div class="section" id="locationInfo">
        
	  	<div class="title">收货人信息
	  		<span class="trigEdit" style="display: inline; ">[<a class="edit" href="javascript:void(0);">修改</a>]</span><span class="trigView" style="display: none; ">[<a class="view" href="javascript:void(0);">关闭</a>]</span>
		</div>
        
	    <div class="rds" style="display: block; ">
		    <div class="item">
                <span class="labelText">收货人姓名: </span>
                <span class="content" id="name_list" name = "name_list"><?=$orderItem['recvName']?></span>
			</div>
<?php
//$globalRgnCode = $procRegionObj->GetRegionCodeArray($orderItem['regionIndex']);
//$rgnCodeArr = explode(",", $globalRgnCode);
?>
		    <div class="item">
                <span class="labelText">省    份: </span>
                <span class="content" regionIndex="<?=$orderItem['regionIndex']?>">
		    		<?php if(count($rgnCodeArr)>0){$procProv = $procRegionObj->GetItem($rgnCodeArr[0]); if($procProv) echo $procProv['regionID'];}?> 
		    		<?php if(count($rgnCodeArr)>1){$procCity = $procRegionObj->GetItem($rgnCodeArr[1]); echo $procCity['regionID'];}?> 
		    		<?php if(count($rgnCodeArr)>2){$procCounty = $procRegionObj->GetItem($rgnCodeArr[2]); echo $procCounty['regionID'];}?>
                </span>
            </div>
		    <div class="item">
                <span class="labelText">地    址: </span>
                <span class="content"><?=$orderItem['recvAddress']?></span>
            </div>
		    <div class="item">
                <span class="labelText">邮政编码: </span>
                <span class="content"><?=$orderItem['recvPostBox']?></span>
            </div>
		    <div class="item">
                <span class="labelText">固定电话: </span>
                <span class="content"><?=$orderItem['recvTelNumber']?></span>
            </div>
		    <div class="item">
                <span class="labelText">手机号码: </span>
                <span class="content"><?=$orderItem['recvPhoneNumber']?></span>
            </div>
		    <div class="item">
                <span class="labelText">电子信箱: </span>
                <span class="content"><?=$orderItem['recvEmailAddress']?></span>
            </div>
		</div>
        
		<div class = "eds" style = "display: none;">
        <form id = "tblRecvInfo" novalidate = "validate">
			<div class="item">
                <span class="labelText">收货人姓名: </span>
                <input type="text" class="inputCtrl  type1 required" id="consignee_name" name="consignee_name" value="">
            </div>
        </form>
		    <div class="item">
                <span class="labelText">省    份:</span>
					<select rel="select" class="comboCtrl" id="prov" name="prov">
                        <option value="-1" selected="">请选择</option>
<?php for($i=0; $i<count($regionCodeArray); $i++){?>
						<option value="<?=$regionCodeArray[$i]['regionIndex']?>"><?=$regionCodeArray[$i]['regionID']?></option>
<?php }?>
					</select>
					<select rel="select" class="comboCtrl" id="city" name="city">
						<option value="-1" selected="">请选择</option>
<?php if(count($rgnCodeArr)>0){	
	$regionCodeArray = $procRegionObj->GetChildClass($rgnCodeArr[0]);
	for($i=0; $i<count($regionCodeArray); $i++){?>
			<option value="<?=$regionCodeArray[$i]['regionIndex']?>" <?php if(count($rgnCodeArr)>1){if($rgnCodeArr[1]==$regionCodeArray[$i]['regionIndex']) echo "SELECTED";}?>><?=$regionCodeArray[$i]['regionID']?></option>
<?php }}?>
					</select>
					<select rel="select" class="comboCtrl" id="county" name="county">
						<option value="-1" selected="">请选择位置</option>
<?php if(count($rgnCodeArr)>1){	
	$regionCodeArray = $procRegionObj->GetChildClass($rgnCodeArr[1]);
	for($i=0; $i<count($regionCodeArray); $i++){?>
			<option value="<?=$regionCodeArray[$i]['regionIndex']?>" <?php if(count($rgnCodeArr)>2){if($rgnCodeArr[2]==$regionCodeArray[$i]['regionIndex']) echo "SELECTED";}?>><?=$regionCodeArray[$i]['regionID']?></option>
<?php }}?>
					</select>
		    </div>
            <form id = "tblRecvInfo1" novalidate = "validate">
		    <div class="item">
                <span class="labelText">地    址: </span>
                <input type="text" class="inputCtrl  type1 required" id="consignee_addr" name="consignee_addr" value="">
            </div>
		    <div class="item">
                <span class="labelText">邮政编码: </span>
                <input type="text" class="inputCtrl  type1" id="consignee_psCode" name="consignee_psCode" value="">
            </div>
		    <div class="item">
                <span class="labelText">固定电话: </span><input type="number" class="inputCtrl  type1 required" id="consignee_tel" name="consignee_tel" value="">
                <span class="omit"></span>
            </div>
		    <div class="item">
                <span class="labelText">手机号码: </span>
                <input type="number" class="inputCtrl  type1 required" id="consignee_handphoe" name="consignee_handphoe" value="">
            </div>
		    <div class="item">
                <span class="labelText">电子信箱: </span>
                <input type="text" class="inputCtrl  type1 required email" id="consignee_email" name="consignee_email" value="">
            </div>
		    <div class="btnSave" style="background-Image: url(<?=$baseUrl?>/images/btnSave1_n.gif); " id="btnSaveLocation"></div>
		    </form>
        </div>
        
	  </div>
<div style="display:none;" id="codeDiv" name="codeDiv"></div>

<input type=hidden id="netMoneyUse" name="netMoneyUse" value="0">
	  <div class="section" id="pay_transInfo">
	  	<div class="title">支付及配送方式
	  		<span class="trigEdit">[<a class="edit" href="javascript:void(0);">修改</a>]</span><span class="trigView" style="display: none; ">[<a class="view" href="javascript:void(0);">关闭</a>]</span>
		</div>
	    <div class="rds">
		    <div class="item"><span class="labelText">支付方式: </span><span class="content" value="<?=$orderItem['payKind']?>"><?php if($orderItem['payKind']== 5) echo "使用网上账户"; else echo $payKindStr;?></span></div>
		    <div class="item"><span class="labelText">配送方式:</span><span class="content" value="<?=$orderItem['sendSpeed']?>"><?php echo $sendKindStr?></span></div>
		    <div class="item"><span class="labelText">运    费: </span><span class="content"><?=$orderItem['sendMoney']?>元</span></div>
		</div>
		<div class="eds" style="display: none; ">
			<div class="subtitle"><img src="<?=$baseUrl;?>/images/calculator.gif">支付方式</div>
				<div class="item"><input type="radio" class="radioCtrl" id="accountRadio" name="accountRadio" jks="90"><span class="ctrlLabel" value=5> 使用网上账户</span></div>
				<div class="item" style="font-size:14px; color:#EE5555; margin-left:120px;display:none;" id="netAlarm">您的网上账户余额不足，请进行<a href="<?=Url::to(['shop/charge'])?>" style="color:#0071C6">充值</a>或选择其他支付方式。</div>
<?php for($i=0; $i<count(Yii::$app->params['payKindStrArr']); $i++){?>
				<div class="item"><input type="radio" class="radioCtrl" name="accountRadio" value="0"<?php if($i==0) ' checked';?>><span class="ctrlLabel" value="<?=$i?>"> <?=Yii::$app->params['payKindStrArr'][$i]?></span><?php if(Yii::$app->params['payKindStrArr'][$i]=="货到付款"){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#575A5A">仅限限丹东、凤城及东港市内送货上门地区</font><?php }?></div>
<?php }?>
			<div class="subtitle"><img src="<?=$baseUrl?>/images/cart_go.gif">配送方式</div>
				<table class="tb1" border="0" cellspacing="0">
					<tbody><tr>
						<th> 方 式 </th>
						<th> 货物在途时间</th>
						<th> 备 注 </th>
					</tr>
					<tr>
						<td class="transType"><input type="radio" name="transRadio" id="normalTrans" value="0" checked><span class="ctrlLabel" value="0"> <?php echo '送货上门';?></span></td>
						<td class="during">1-3天</td>
						<td class="comment">限丹东、凤城及东港市内</td>
					</tr>
					<tr>
						<td class="transType"><input type="radio" name="transRadio" id="expressTrans" value="1"><span class="ctrlLabel" value="1"> <?php echo '快递运输';?></span></td>
						<td class="during"><p> 1-7天 </p></td>
						<td class="comment">一般选用价格较低廉的快递公司，或邮局快包，中铁快运等。</td>
					</tr>
					<tr>
						<td class="transType"><input type="radio" name="transRadio" id="selfTrans" value="2"><span class="ctrlLabel" value="2"> <?php echo '店面自提';?></span></td>
						<td class="during"> </td>       
						<td class="comment">用户可到丹东商城任一店面提取商品。</td>
					</tr>
					<tr>
						<td colspan="4" class="shopArea" style="display: none; ">
							<table class="shop_list" border="0" cellspacing="0">
								<tbody><tr style="font-weight:bold;">
									<td class="shop_select">选择</td>
									<td class="shop_name">店 名</td>
									<td class="shop_addr">地 址</td>
									<td class="shop_contact_name">联系人名</td>
									<td class="shop_contact_phone">联系电话</td>
								</tr>
<?php
	foreach($shopInfoArr as $row){
?>
								<tr>
									<td class="shop_select"><input type="radio" id="subShop" name="subShop" value="<?=$row['shopIndex']?>"<?php if($row['shopIndex']==$orderItem['shopIndex']){?> checked><?php }?></td>
									<td class="shop_name"><?=$row['shopName']?></td>
									<td class="shop_addr"><?=$row['shopAddress']?></td>
									<td class="shop_contact_name"><?=$row['shopMember']?></td>
									<td class="shop_contact_phone"><?=$row['shopTelNumber']?></td>
								</tr>
<?php }?>
							</tbody></table>
						</td>
					</tr>
				</tbody></table>

			<div class="btnSave" id="btnSavePayTrans"></div>
		</div>
	  </div>
<div class="section" id="billInfo">
	  	<div class="title">发 票 信 息
	  		<span class="trigEdit">[<a class="edit" href="javascript:void(0);">修改</a>]</span><span class="trigView" style="display: none; ">[<a class="view" href="javascript:void(0);">关闭</a>]</span>
		</div>
	    <input type=hidden id="reciptExistVal" value="<?php if($orderItem['invoiceType']>0) echo "1"; else echo "0";?>">
	    <input type=hidden id="reciptTypeVal" value="<?php if($orderItem['invoiceType']>0) echo $orderItem['invoiceType']; else echo "1";?>">
	    <input type=hidden id="reciptUnitVal" value="<?=$orderItem['invoiceTarget']?>">
	    <input type=hidden id="reciptContentVal" value="<?=$orderItem['invoiceContent']?>">
	    
	    <input type=hidden id="reciptUnitNameVal" value="<?=$orderItem['reciptUnitName']?>">
	    <input type=hidden id="reciptNameVal" value="<?=$orderItem['reciptName']?>">
	    <input type=hidden id="reciptAddressVal" value="<?=$orderItem['reciptAddress']?>">
	    <input type=hidden id="reciptTelNumberVal" value="<?=$orderItem['reciptTelNumber']?>">
	    <input type=hidden id="reciptBankVal" value="<?=$orderItem['reciptBank']?>">
	    <input type=hidden id="reciptAccountVal" value="<?=$orderItem['reciptAccount']?>">
	    <div class="rds">
			<div class="item" <?php if($orderItem['invoiceType']>0) echo 'style="display:none;"';?>>
                <span class="content">不开</span>
            </div>
		    <div class="item" <?php if($orderItem['invoiceType']==0) echo 'style="display:none;"';?>>
                <span class="labelText">发票类型: </span>
                <span class="content">
                    <?php switch($orderItem['invoiceType']){
                        case 1: 
                            echo "普通发票";
                            break;
                        case 2: 
                            echo "增值税发票";
                            break;}?>
                </span>
            </div>
		    <div class="item" <?php if($orderItem['invoiceType']==0) echo 'style="display:none;"';?>>
                <span class="labelText">发票抬头:</span>
                <span class="content">
                    <?php switch($orderItem['invoiceTarget']){
                        case 0: 
                            echo "个人";
                            break;
                        case 1: 
                            echo "单位";
                            break;}
                    ?>
                </span>
            </div>
		    <div class="item" <?php if($orderItem['invoiceType']==0) echo 'style="display:none;"';?>>
                <span class="labelText">发票内容: </span>
                <span class="content">
                    <?php switch($orderItem['invoiceContent']){
                        case 0: 
                            echo "明细";
                            break;
                        case 1: 
                            echo "办公用品";
                            break;
                        case 2: 
                            echo "电脑配件";
                            break;
                        case 3: 
                            echo "耗材";
                            break;}
                    ?>
                </span>
            </div>
		</div>
		<div class="eds" style="display: none; ">
			<div class="item0">
				<span class="labelText">发票开/不开: </span>
				<input type="radio" class="radioCtrl2" name="receiptCheck" id="receiptCheckEnable" value="1"><span class="ctrlLabel2"> 开</span>
				<input type="radio" class="radioCtrl2" name="receiptCheck" id="receiptCheckDisable" checked value="0"><span class="ctrlLabel2"> 不开</span>
			</div>
		<div class="itemCol">
			<div class="item">
				<span class="labelText">发票类型: </span>
				<input type="radio" class="radioCtrl2" name="billTypeRadio" id="normalBill" checked><span class="ctrlLabel2"> 普通发票</span>
				<input type="radio" class="radioCtrl2" name="billTypeRadio" id="incrementBill"><span class="ctrlLabel2"> 增值税发票</span>
			</div>
			<div class="incBillSec" style="display:none;">
				<div class="item4">增值税发票专用发票资质填写(不能为空!):</div>
				<div class="item3">
					<span class="labelText3">单位名称: </span>
					<input type="text" id="invoice_Ivc_TitName" class="inputCtrl3" value="">
				</div>               
				<div class="item3">
					<span class="labelText3">纳税人识别号:</span>
					<input type="text" id="invoice_Ivc_NsrCode" class="inputCtrl3" value=""></div>
			    <div class="item3">
			    	<span class="labelText3">注册地址: </span>
			    	<input type="text" id="invoice_Ivc_Address" class="inputCtrl3" value="">
			    </div>
			    <div class="item3">
			    	<span class="labelText3">注册电话: </span>
			    	<input type="text" id="invoice_Ivc_Phone" class="inputCtrl3" value="">
			    </div>
			    <div class="item3">
			    	<span class="labelText3">开户银行: </span>
			    	<input type="text" id="invoice__Ivc_Bank" class="inputCtrl3" value="">
			    </div>
			    <div class="item3">
			    	<span class="labelText3">银行帐户: </span>
			    	<input type="text" id="invoice_Ivc_BankCode" class="inputCtrl3" value="">
			    </div>
			</div>

			<div class="billOwnerSec">
				<div class="item">
					<span class="labelText">发票抬头: </span>
					<input type="radio" class="radioCtrl2" name="billWhomRadio" id="person" checked="checked"><span class="ctrlLabel2">  个人</span>
					<input type="radio" class="radioCtrl2" name="billWhomRadio" id="organ"><span class="ctrlLabel2">  单位</span>
				</div>
				<div class="organSec" style="display:none;">
					<div class="item3">
						<span class="labelText3">单位名称: </span>
						<input type="text" id="invoice_Unit_TitName" class="inputCtrl3" value="">
						<span style="color:#c00;padding-left:10px;">单位名称不能为空！: </span>
					</div>
					<div class="item3"><span style="color:#999;padding-left:100px;">温馨提示：您填写的所有内容都将被系统自动打印到发票上，所以请千万别填写和发票抬头无关的信息。 </span></div>
				</div>
			</div>

			<div class="item" id="usageSec">
				<span class="labelText">发票内容: </span>
				<input type="radio" class="radioCtrl2" name="billUseRadio" id="bill_detail" checked="checked"><span class="ctrlLabel2"> 明细</span>
				<input type="radio" class="radioCtrl2" name="billUseRadio" id="bill_officeSupp"><span class="ctrlLabel2"> 办公用品</span>
				<input type="radio" class="radioCtrl2" name="billUseRadio" id="bill_computer"><span class="ctrlLabel2"> 电脑配件</span>
				<input type="radio" class="radioCtrl2" name="billUseRadio" id="bill_consumption"><span class="ctrlLabel2"> 耗材</span>
			</div>
		</div>
			<p class="item5">声明：<?=$introTicketInfo['introInfo']?></p>
			<div class="btnSave"></div>
		</div>
	  </div>

<div class="section" id="opinionInfo">
	  	<div class="title">订 单 备 注
			<span class="trigEdit">[<a class="edit" href="javascript:void(0);">修改</a>]</span><span class="trigView" style="display: none; ">[<a class="view" href="javascript:void(0);">关闭</a>]</span>
		</div>
	    <div class="rds">
		    <div class="item"<?php if(strlen($orderItem['orderContent'])>0){?> style="display:none;"<?php }?>><span class="labelText">暂无备注 </span></div>
	        <p class="content"><?=$orderItem['orderContent']?></p>
		</div>
		<div class="eds" style="display: none; ">
		    <div class="item" style="height:50px;padding-right:10px;"><span class="note" style=" font-size:13px; line-height:22px;">声明：<?=$introOrderInfo['introInfo']?></span></div>
			<div class="item" style="height:90px;"><span class="labelText">备注</span><TEXTAREA class="inputCtrl  type3" id="othercomment" style="width:600px; height:70px;"><?=$orderItem['orderContent']?></TEXTAREA></div>
			<div class="btnSave"></div>
		</div>
	  </div>

<div class="title">商 品 清 单</div>
	<div id="orderDetailSum">
	</div>
<?php if(substr($orderItem['payInitialDate'],0,10) == "0000-00-00"){?>
	  <div class="title">订单修改备注</div>
	<input type=text id="changeContentVal" name="changeContentVal" style="width:880px;">
	<P class="btnArr">
		<a class="btnSaveSubmit" href="javascript:void(0);">保存</a>
		<a class="btnConfirm" href="javascript:void(0);">确认</a>
	</P>
<?php }?>
    </div>
  </div>
</div>

<script type="text/javascript">
    var proIDs = new Array();
    var proCounts = new Array();

    function checkSumCount()
    {
        checkSum = 0;
        for(i = 0; i < $("#orderDetailSum INPUT").length; i++)
            checkSum += 1*$("#orderDetailSum INPUT").eq(i).attr("value");
        return (checkSum == 0);
    }
//    function checkOverflow()
//    {
//        for(i=0; i<$("#orderDetailSum INPUT").length; i++)
//            if(($("#orderDetailSum INPUT").eq(i).attr("limitAmount")=="0")&&($("#orderDetailSum INPUT").eq(i).attr("schedule")=="0"))
//            {
//                alert("此商品("+$("#orderDetailSum INPUT").eq(i).attr("productName2")+")暂时无货，您可以与客服联系为您进货，或者选购其他商品。");
//                return true;
//            }
//        for(i=0; i<$("#orderDetailSum INPUT").length; i++)
//            if(($("#orderDetailSum INPUT").eq(i).attr("value") > $("#orderDetailSum INPUT").eq(i).attr("limitAmount"))&&($("#orderDetailSum INPUT").eq(i).attr("schedule")=="0"))
//            {
//                alert("购买数量很多。请再输入购买数量。");
//                return true;
//            }
//        return false;
//    }
//
    $(document).ready(function(){

//        $("#tblRecvInfo").validate();
//        $("#tblRecvInfo1").validate();
//first table part
        $("#locationInfo .edit").click(function(){
            $("#locationInfo .eds #consignee_name").attr("value",  $("#locationInfo .rds .content").eq(0).html());
            $("#locationInfo .eds #consignee_addr").attr("value",  $("#locationInfo .rds .content").eq(2).html());
            $("#locationInfo .eds #consignee_psCode").attr("value",$("#locationInfo .rds .content").eq(3).html());
            $("#locationInfo .eds #consignee_tel").attr("value",$("#locationInfo .rds .content").eq(4).html());
            $("#locationInfo .eds #consignee_handphoe").attr("value",$("#locationInfo .rds .content").eq(5).html());
            $("#locationInfo .eds #consignee_email").attr("value",$("#locationInfo .rds .content").eq(6).html());

            $.ajax({
                type:"POST",
                url:'location-info-edit',
                data: {
                    regionIndex:$("#locationInfo .rds .content").eq(1).attr("regionIndex")
                },
                success:function(data){
                    $("#codeDiv").html(data);
                },
                error:function(x,e) {
                    alert("###The call to the server side failed" + x.responseText);
                }
            });
        });

        $("#btnSaveLocation").click(function(){
            regionIndex = 0;
            strAddress = "";
            if($("#locationInfo .eds #prov").attr("value") > 0){
                strAddress = $("#locationInfo .eds #prov OPTION").eq($("#locationInfo .eds #prov").attr("value")).text();
                regionIndex = $("#locationInfo .eds #prov").attr("value");
            }
            if($("#locationInfo .eds #city").attr("value")>0){
                strAddress += " " + $("#locationInfo .eds #city OPTION").eq($("#locationInfo .eds #city").attr("value")).text();
                regionIndex = $("#locationInfo .eds #city").attr("value");
            }
            if($("#locationInfo .eds #county").attr("value")>0){
                strAddress += " " + $("#locationInfo .eds #county OPTION").eq($("#locationInfo .eds #county").attr("value")).text();
                regionIndex = $("#locationInfo .eds #county").attr("value");
            }

            $("#locationInfo .rds .content").eq(1).html(strAddress);
            $("#locationInfo .rds .content").eq(1).attr("regionIndex", regionIndex);
            $("#locationInfo .rds .content").eq(0).html($("#locationInfo .eds #consignee_name").val());
            $("#locationInfo .rds .content").eq(2).html($("#locationInfo .eds #consignee_addr").attr("value"));
            $("#locationInfo .rds .content").eq(3).html($("#locationInfo .eds #consignee_psCode").attr("value"));
            $("#locationInfo .rds .content").eq(4).html($("#locationInfo .eds #consignee_tel").attr("value"));
            $("#locationInfo .rds .content").eq(5).html($("#locationInfo .eds #consignee_handphoe").attr("value"));
            $("#locationInfo .rds .content").eq(6).html($("#locationInfo .eds #consignee_email").attr("value"));

            //$("#locationInfo .rds #name_list OPTION").eq($("#locationInfo .rds #name_list").attr("value")).text($("#locationInfo .eds #consignee_name").attr("value"));
        });

        $("#prov").change(function(){
            if($(this).attr("value") != -1){
                $.ajax({
                    type:"POST",
                    url:'prov-change',
                    data: {
                        parentIndex:$(this).val()
                    },
                    success:function(data){
                        $("#city").html('<option value="-1">请选择市/区</option>'+data);
                    },
                    error:function(x,e) {
                        alert("The call to the server side failed" + x.responseText);
                    }
                });
                $("#county").html('<option value="-1">请选择位置</option>');
            }
        });

        $("#city").change(function(){
            if($(this).attr("value") != -1){
                $.ajax({
                    type:"POST",
                    url:'prov-change',
                    data: {
                        parentIndex:$(this).val()
                    },
                    success:function(data){
                        $("#county").html('<option value="-1">请选择位置</option>'+data);
                    },
                    error:function(x,e) {
                        alert("The call to the server side failed" + x.responseText);
                    }
                });
            }
        });

////second table part
        $("#pay_transInfo .edit").click(function(){
            if($("#pay_transInfo .rds .content").eq(0).attr("value") > 4)
                $(".eds INPUT.radioCtrl").eq(0).attr("checked", true);
            else
                $(".eds INPUT.radioCtrl").eq($("#pay_transInfo .rds .content").eq(0).attr("value")*1+1).attr("checked", true);
            $(".transType INPUT").eq($("#pay_transInfo .rds .content").eq(1).attr("value")).attr("checked", true);
            if($('#selfTrans').attr("checked"))	$('.shopArea').show();
        });

        $("#btnSavePayTrans").click(function(){
            $("#pay_transInfo .rds .content").eq(0).html($(".eds INPUT.radioCtrl:checked").parent().children(".ctrlLabel").text());
            $("#pay_transInfo .rds .content").eq(0).attr("value",$(".eds INPUT.radioCtrl:checked").parent().children(".ctrlLabel").attr("value"));
            $("#pay_transInfo .rds .content").eq(1).html($(".transType INPUT:checked").parent().children(".ctrlLabel").text());
            $("#pay_transInfo .rds .content").eq(1).attr("value",$(".transType INPUT:checked").parent().children(".ctrlLabel").attr("value"));
            if($("#pay_transInfo .rds .content").eq(0).attr("value") > 4) $("#netMoneyUse").attr("value", "1"); else  $("#netMoneyUse").attr("value", "0");
        });

        //Deliver JS //
        $(".transType INPUT").click(function(){
            //alert();
            if($('#selfTrans').attr("checked"))
                $('.shopArea').show();
            else{
                if($("#pay_transInfo .eds INPUT.radioCtrl").eq(1).attr("checked"))
                {
                    $('#selfTrans').attr("checked", true);
                    return false;
                }
                else
                    $('.shopArea').hide();
            }
        });

        $("#pay_transInfo .eds INPUT.radioCtrl").click(function(){
            if($("#pay_transInfo .eds INPUT.radioCtrl").eq(2).attr("checked")){
                alert('jks');
                $('#selfTrans').attr("checked", true);
                $('#selfTrans').click();
            } else {
                $('#selfTrans').attr("checked", false);
                //$('#selfTrans').click();
                $('.shopArea').hide();
                $('#normalTrans').attr("checked",true);
            }
            alert($("#pay_transInfo .eds INPUT.radioCtrl").eq(1).checked);
            if($("#pay_transInfo .eds INPUT.radioCtrl").eq(0).attr("checked")) {
                if (overflowNet()) $("#netAlarm").show();
            } else
                $("#netAlarm").hide();
        });

//third table part

        $("#receiptCheckEnable").click(function(){
            $(".eds .itemCol").css("display", "block");
        });

        $("#receiptCheckDisable").click(function(){
            $(".eds .itemCol").css("display", "none");
        });

        $("#billInfo .edit").click(function(){
            if($("#reciptExistVal").attr("value") == 1){
                $(".eds .itemCol").css("display", "block");
                $("#receiptCheckEnable").attr("checked", true);
            } else {
                $(".eds .itemCol").css("display", "none");
                $("#receiptCheckDisable").attr("checked", true)
            }

            if($("#reciptTypeVal").attr("value")=="1"){
                $("#normalBill").attr("checked", true);
                $('#normalBill').click();
            }
            else{
                $("#incrementBill").attr("checked", true);
                $('#incrementBill').click();
            }
            if($("#reciptUnitVal").attr("value")=="1"){
                $("#organ").attr("checked", true);
                $("#organ").click();
            }
            else{
                $("#person").attr("checked", true);
                $("#person").click();
            }

            switch($("#reciptContentVal").attr("value")){
                case "0":
                    $("#bill_detail").attr("checked", true);
                    break;
                case "1":
                    $("#bill_officeSupp").attr("checked", true);
                    break;
                case "2":
                    $("#bill_computer").attr("checked", true);
                    break;
                case "3":
                    $("#bill_consumption").attr("checked", true);
                    break;
            }

            $("#invoice_Unit_TitName").attr("value",$("#reciptUnitNameVal").attr("value"));
            $("#invoice_Ivc_TitName").attr("value",$("#reciptUnitNameVal").attr("value"));
            $("#invoice_Ivc_NsrCode").attr("value",$("#reciptNameVal").attr("value"));
            $("#invoice_Ivc_Address").attr("value",$("#reciptAddressVal").attr("value"));
            $("#invoice_Ivc_Phone").attr("value",$("#reciptTelNumberVal").attr("value"));
            $("#invoice__Ivc_Bank").attr("value",$("#reciptBankVal").attr("value"));
            $("#invoice_Ivc_BankCode").attr("value",$("#reciptAccountVal").attr("value"));
        });

        $("#billInfo .btnSave").click(function(){
            if($("#receiptCheckEnable").attr("checked")){
                $("#billInfo .rds .item").css("display", "block");
                $("#billInfo .rds .item").eq(0).css("display", "none");
                $("#reciptExistVal").attr("value", 1);
            } else {
                $("#billInfo .rds .item").css("display", "none");
                $("#billInfo .rds .item").eq(0).css("display", "block");
                $("#reciptExistVal").attr("value", 0);
            }
            if($("#normalBill").attr("checked"))
                $("#reciptTypeVal").attr("value", 1);
            if($("#incrementBill").attr("checked")){
                $("#reciptTypeVal").attr("value", 2);
            }
            if($("#organ").attr("checked")) $("#reciptUnitVal").attr("value", 1); else $("#reciptUnitVal").attr("value", 0);
            if($("#bill_detail").attr("checked")) $("#reciptContentVal").attr("value", 0);
            if($("#bill_officeSupp").attr("checked")) $("#reciptContentVal").attr("value", 1);
            if($("#bill_computer").attr("checked")) $("#reciptContentVal").attr("value", 2);
            if($("#bill_consumption").attr("checked")) $("#reciptContentVal").attr("value", 3);

            $("#invoice_Ivc_TitName").html($("#reciptUnitNameVal").attr("value"));
            if($("#reciptTypeVal").attr("value") == 2) $("#invoice_Unit_TitName").attr("value", $("#invoice_Ivc_TitName").attr("value"));
            if(($("#reciptTypeVal").attr("value") == 1)&&($("#reciptUnitVal").attr("value") == 1)) $("#invoice_Ivc_TitName").attr("value", $("#invoice_Unit_TitName").attr("value"));
            $("#reciptUnitNameVal").attr("value",$("#invoice_Unit_TitName").attr("value"));
            $("#reciptNameVal").attr("value",$("#invoice_Ivc_NsrCode").attr("value"));
            $("#reciptAddressVal").attr("value",$("#invoice_Ivc_Address").attr("value"));
            $("#reciptTelNumberVal").attr("value",$("#invoice_Ivc_Phone").attr("value"));
            $("#reciptBankVal").attr("value",$("#invoice__Ivc_Bank").attr("value"));
            $("#reciptAccountVal").attr("value",$("#invoice_Ivc_BankCode").attr("value"));

            if($("#reciptTypeVal").attr("value")=="1") $("#billInfo .rds .content").eq(1).html("普通发票");
            else $("#billInfo .rds .content").eq(1).html("增值税发票");
            if($("#reciptUnitVal").attr("value")=="1") $("#billInfo .rds .content").eq(2).html("单位");
            else $("#billInfo .rds .content").eq(2).html("个人");

            switch($("#reciptContentVal").attr("value")){
                case "0":
                    $("#billInfo .rds .content").eq(3).html("明细");
                    break;
                case "1":
                    $("#billInfo .rds .content").eq(3).html("办公用品");
                    break;
                case "2":
                    $("#billInfo .rds .content").eq(3).html("电脑配件");
                    break;
                case "3":
                    $("#billInfo .rds .content").eq(3).html("耗材");
                    break;
            }

        });

        $(".btnSave").click(function(){
            loadOrderData();
        });

        $("#opinionInfo .btnSave").click(function(){
            $("#opinionInfo .rds .content").html($("#opinionInfo .eds #othercomment").val());
            if($("#opinionInfo .eds #othercomment").attr("value") == "")
                $("#opinionInfo .rds .item").show();
            else
                $("#opinionInfo .rds .item").hide();
        });
        $("#opinionInfo .edit").click(function(){
            $("#opinionInfo .eds #othercomment").attr("value",$("#opinionInfo .rds .content").html());
        });

        /*$(".btnSave").click(function(){
         loadOrderData();
         }); */

        $(".btnConfirm").click(function(){
            $.ajax({
                type:"POST",
                url:'btn-confirm',
                data: {
                    orderIndex : '<?=$orderIndex?>'
                },
                success:function(data){
                    //window.opener.reloadInputRecord();
                    alert("确认成功!");
                    window.close();
                }
            });
        });
        $('.btnSave').mousedown(function(){$(this).css('background-image', 'url(<?=$baseUrl;?>/images/btnsave1_c.gif)');});
        $('.btnSave').mouseup(function(){$(this).css('background-image', 'url(<?=$baseUrl;?>/images/btnsave1_n.gif)');});

        $(".btnSaveSubmit").click(function(){
            if(checkSumCount()){
                alert("购买数量很少。请正确输入购买数量。");
                return false;
            }
            if(checkOverflow()){
                alert("购买数量很多。请再输入购买数量。");
                return false;
            }
            cartOrder = readCookie("cartOrderA");
            if(cartOrder)
            {
                recvAddress = $("#locationInfo .rds .content").eq(2).html();
                recvPostBox = $("#locationInfo .rds .content").eq(3).html();
                recvTelNumber = $("#locationInfo .rds .content").eq(4).html();
                recvPhoneNumber = $("#locationInfo .rds .content").eq(5).html();
                recvEmailAddress = $("#locationInfo .rds .content").eq(6).html();
                recvName = $("#locationInfo .rds .content").eq(0).html();
                regionIndex = $("#locationInfo .rds .content").eq(1).attr("regionIndex");
                if((recvAddress == "")||(recvPostBox == "")||((recvPhoneNumber == "")&&(recvTelNumber == ""))||(recvName == "")){
                    alert("请输入收货人信息");
                    return false;
                }
                else
                {
                    payKind = $("#pay_transInfo .rds .content").eq(0).attr("value");
                    recvStatus = $("#pay_transInfo .rds .content").eq(1).attr("value");
                    cardRealID2 = "";
                    cardRealPWD2 = "";
                    cardRealMoney2 = 0;
                    shopIndex = $(".shop_select INPUT:checked").attr("value");
                    if($("#reciptExistVal").attr("value") == 1)
                        invoiceExist = 1;
                    else invoiceExist = 0;
                    if($("#reciptTypeVal").attr("value")=="1") invoiceType = 1; else invoiceType = 2;
                    if($("#reciptUnitVal").attr("value")=="1") invoiceTarget = 1; else invoiceTarget = 0;
                    invoiceContent = $("#reciptContentVal").attr("value");
                    reciptUnitName = $("#reciptUnitNameVal").attr("value");
                    reciptName = $("#reciptNameVal").attr("value");
                    reciptAddress = $("#reciptAddressVal").attr("value");
                    reciptTelNumber = $("#reciptTelNumberVal").attr("value");
                    reciptBank = $("#reciptBankVal").attr("value");
                    reciptAccount = $("#reciptAccountVal").attr("value");
                    orderContent = $("#opinionInfo .rds .content").html();
                    changeContent = $("#changeContentVal").attr("value");

                    $.ajax({
                        type:"POST",
                        url:'editsettingsave',
                        data: {
                            originOrderIndex:'<?=$orderIndex?>',
                            recvAddress:recvAddress,
                            recvPostBox:recvPostBox,
                            recvTelNumber:recvTelNumber,
                            recvPhoneNumber:recvPhoneNumber,
                            recvEmailAddress:recvEmailAddress,
                            recvName:recvName,
                            regionIndex:regionIndex,
                            payKind:payKind,
                            recvStatus:recvStatus,
                            cardRealID:cardRealID2,
                            cardRealMoney:cardRealMoney2,
                            shopIndex:shopIndex,
                            invoiceExist:invoiceExist,
                            invoiceType:invoiceType,
                            invoiceTarget:invoiceTarget,
                            invoiceContent:invoiceContent,
                            reciptUnitName:reciptUnitName,
                            reciptName:reciptName,
                            reciptAddress:reciptAddress,
                            reciptTelNumber:reciptTelNumber,
                            reciptBank:reciptBank,
                            reciptAccount:reciptAccount,
                            cartOrder:cartOrder,
                            orderContent:orderContent,
                            cardRealPWD:cardRealPWD2,
                            changeContent:changeContent,
                            netMoneyCheck:$("#netMoneyUse").attr("value"),
                        },
                        success:function(data) {
                            proIDs = new Array();
                            proCounts = new Array();
                            writecartOrder();
                            window.opener.frmlist2.submit();
                            alert("保存成功!");
                            window.close();
                        },
                        error: function(x,e) {
                            alert("The Server side failed" + x.responseText);
                        }
                    });
                }
            }
        });

        createCookie("cartOrderA","<?=$cartOrderList?>");
        isCoo();
    }); // ready()

    function isCoo(){
        var coo = readCookie("cartOrderA");
        if(coo){
            var cootemp = coo.split("|||");
            for(var i = 0; i < cootemp.length - 1; i++)
            {
                tmp = cootemp[i].split("||");
                proIDs.push(tmp[0]);
                proCounts.push(tmp[1]);
            }
        }
        loadOrderData();
    }

    function addToCart(checkid,reqCount){
        existPos = -1;
        for(i = 0; i < proIDs.length; i++)
            if(proIDs[i] == checkid)
                existPos = i;
        if(existPos == -1){
            proIDs.push(checkid);
            proCounts.push(reqCount);
        }else{
            proCounts[existPos] = parseInt(proCounts[existPos]) + reqCount;
        }
        writecartOrder();
        loadOrderData();
    }

    function removeFromCart(checkid,reqCount){
        existPos = -1;
        for(i = 0; i < proIDs.length; i++)
            if(proIDs[i] == checkid)
                existPos = i;
        proCounts[existPos] = parseInt(proCounts[existPos]) - reqCount;
        if(proCounts[existPos] < 0)
            proCounts[existPos] = 0;
        /*	if(proCounts[existPos] == 0){
         proIDs.splice(existPos,1);
         proCounts.splice(existPos,1);
         }*/
        writecartOrder();
        loadOrderData();
    }

    function removeCartOrder(checkid){
        existPos = -1;
        for(i = 0; i < proIDs.length; i++)
            if(proIDs[i] == checkid)
                existPos = i;
        if(existPos >= 0)
        {
            proIDs.splice(existPos,1);
            proCounts.splice(existPos,1);
        }
        writecartOrder();
        loadOrderData();
    }

    function clearCart(){
        proIDs = new Array();
        proCounts = new Array();
        writecartOrder();
        loadOrderData();
    }

    function writecartOrder(){
        cartOrderList = "";
        for(i = 0; i < proIDs.length; i++)
            cartOrderList +=  proIDs[i] + "||" + proCounts[i] + "|||";
        createCookie("cartOrderA",cartOrderList);
    }

    function createCookie(name, value, days, Tdom){
        var Tdom=(Tdom) ? Tdom : "/";
        if(days){
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            var expires = "; expires=" + date.toGMTString();
        }else{
            var expires="";
        }
        document.cookie = name + "=" + value + expires + "; path=" + Tdom;
    }

    function readCookie(name){
        var nameEQ=name+"=";
        var ca=document.cookie.split(';');
        for(var i = 0; i < ca.length; i++){
            var c = ca[i];
            while(c.charAt(0)==' ')
                c = c.substring(1,c.length);
            if(c.indexOf(nameEQ)==0)
                return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function loadOrderData()
    {
        cartOrder = readCookie("cartOrderA");
        $.ajax({
            type:"GET",
            url:'loadorderdata',
            data:
            {
                recvRegionIndex:$("#locationInfo .rds .content").eq(1).attr("regionIndex"),
                reciptExistVal:$("#reciptExistVal").attr("value"),
                reciptTypeVal:$("#reciptTypeVal").attr("value"),
                recvType:$("#pay_transInfo .rds .content").eq(1).attr("value"),
                cardRealMoney:0,
                cartOrder:cartOrder,
                netMoneyCheck:$("#netMoneyUse").attr("value")
            },
            success: function(data) {
                $("#orderDetailSum").html(data);
            },
            error:function(x, e) {
                alert("###The call to the server side failed. "+x.responseText);
            }
        });
    }

    function overflowNet()
    {
        if($("#pay_transInfo .eds INPUT.radioCtrl").eq(0).attr("checked")){
            totalPriceVal = parseFloat($(".totalPrice").html());
            if(isNaN(totalPriceVal))
                totalPriceVal = 0;
            netMoneyVal = parseFloat("<?=$accountObj['netMoney']?>");
            if(isNaN(netMoneyVal))
                netMoneyVal = 0;
            if(netMoneyVal < totalPriceVal)
                return true;
            else return false;
        }
        else
            return false;
    }

    function ToggleToVisit()
    {
        $(".eds INPUT.radioCtrl").eq(1).attr("checked", true);
        $("#pay_transInfo .rds .content").eq(0).html($(".eds INPUT.radioCtrl:checked").parent().children(".ctrlLabel").text());
        $("#pay_transInfo .rds .content").eq(0).attr("value",$(".eds INPUT.radioCtrl:checked").parent().children(".ctrlLabel").attr("value"));
        $(".transType INPUT").eq(2).attr("checked", true);
        $("#pay_transInfo .rds .content").eq(1).html($(".transType INPUT:checked").parent().children(".ctrlLabel").text());
        $("#pay_transInfo .rds .content").eq(1).attr("value",$(".transType INPUT:checked").parent().children(".ctrlLabel").attr("value"));
    }

    </script>
<?php
    }
?>


