<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Goodsclass;
use app\models\Product;
use app\models\GuestRepair;
use app\models\GuestReturn;
use app\models\RegionCode;
use app\models\UserGiftCard;
use app\models\ProductOrder;
use app\models\ProductOrderDetail;
use app\models\UserHistory;
use app\models\GlobalFunc;
use app\models\ShopInfo;
use app\models\UserDB2;
use app\models\ProductOrderMoney;
use app\models\IntroRelationship;
use app\models\NetAccount;

class ProductOrderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 * @return array action filters
	 */
    public $breadCrumbArr = array();
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'userLog',
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function filterUserLog($filterChain)
    {
        UserHistory::userLog($this, $filterChain);
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		return $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ProductOrder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productorder']))
		{
			$model->attributes=$_POST['Productorder'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->orderIndex));
		}

        return $this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Productorder']))
		{
			$model->attributes=$_POST['Productorder'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->orderIndex));
		}

        return $this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Productorder');
        return $this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ProductOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Productorder']))
			$model->attributes=$_GET['Productorder'];

        return $this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionOrderstatus()
	{
        $startDate2 = isset($_POST['startDate2']) ? $_POST['startDate2'] : Date("Y-m-d");
        $endDate2 = isset($_POST['endDate2']) ? $_POST['endDate2'] : Date("Y-m-d");
        $orderStatus = isset($_POST['orderStatus']) ? $_POST['orderStatus'] : -1;
        $orderTicketNumber = isset($_POST['orderTicketNumber']) ? $_POST['orderTicketNumber'] : "";
        $curPage = isset($_POST['curPage']) ? $_POST['curPage'] :1;
        
        $startDate = $startDate2;
		$endDate = $endDate2;
        
        $retArrayTemp = ProductOrder::GetProductOrderDays($startDate, $endDate, $orderStatus, $orderTicketNumber);

        $n = 10;
        $retCount = count($retArrayTemp); 
        $retArray = array_slice($retArrayTemp, ($curPage - 1) * $n, $n);
        return $this->renderPartial('productOrderStatus_table', [
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'orderStatus'=>$orderStatus,
            'orderTicketNumber'=>$orderTicketNumber,
            'n' => $n,
            'retCount' => $retCount,
            'retArray' => $retArray,
            'curPage' => $curPage,
        ]);
	}
    
	public function actionProductorderstatus()
	{
        $startDate = '2011-05-1'; //@@@ isset($_POST['startDate2']) ? $_POST['startDate2'] : Date("Y-m-d");
        $endDate = isset($_POST['endDate2']) ? $_POST['endDate2'] : Date("Y-m-d");
        $orderStatus = isset($_POST['orderStatus']) ? $_POST['orderStatus'] : -1;
        $curPage = isset($_POST['curPage']) ? $_POST['curPage'] : 1;
        $orderTicketNumber = isset($_POST['orderTicketNumber']) ? $_POST['orderTicketNumber'] : "";

        $relUrl = UserHistory::getUrlFormat($_SERVER['REQUEST_URI']);
        $r_permit = GlobalFunc::checkPermission($relUrl,'查看订单');

        $retArrayTemp = ProductOrder::GetProductOrderDays($startDate, $endDate, $orderStatus, $orderTicketNumber);

        $n = 10;
        $retCount = count($retArrayTemp);
        $retArray = array_slice($retArrayTemp, ($curPage - 1) * $n, $n);

        $cont_potable = $this->renderPartial('productOrderStatus_table',array(
            'retArray' => $retArray,
            'startDate2'=>$startDate,
            'endDate2'=>$endDate,
            'orderStatus'=>$orderStatus,
            'orderTicketNumber'=>$orderTicketNumber,
            'retCount' => $retCount,
            'n' => $n,
            'curPage' => $curPage,
        ));

        return $this->render('productOrderStatus_welcome',[
            'orderTicketNumber' => $orderTicketNumber,
            'startDate2'=>$startDate,
            'endDate2'=>$endDate,
            'orderStatus'=>$orderStatus,
            'r_permit' => $r_permit,
            'cont_potable' => $cont_potable,
        ]);
	}
	
	public function actionProductorderdetail()
	{
        $orderIndex = isset($_GET['orderIndex']) ? $_GET['orderIndex'] : 0;
        $orderStatus = isset($_GET['orderStatus']) ? $_GET['orderStatus'] : -1;

        $procProduct = new Product();
        $procOrder = new ProductOrder();
        $procOrderDetail = new ProductOrderDetail();

		$_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];

        $orderItem = $procOrder->GetOrderRecord($orderIndex);

        $startDate2 = isset($_POST['startDate2']) ? $_POST['startDate2'] : substr($orderItem['orderDate'],0,10);
        $endDate2 = isset($_POST['endDate2']) ? $_POST['endDate2'] : substr($orderItem['orderDate'],0,10);

        $procOrder->UpdateConfirmInfo($orderIndex, 1);
        $procOrder->UpdateConfirmInfo($orderIndex, 2);


        $kindTemp = $orderItem['payKind'];
        $sendSpeed = $orderItem['sendSpeed'];

        $strTitle2 = GlobalFunc::GetPayKindStr($kindTemp);
        $sendSpeedStr = GlobalFunc::GetSendKindStr($sendSpeed);

        $procShopInfo = new ShopInfo();
        $shopObj = $procShopInfo->GetItem($orderItem['shopIndex']);
        $orderDetailArr = $procOrderDetail->GetOrderDetailArray($orderIndex);

        $procGiftCard = new UserGiftCard();
        $speedPrice = $orderItem['sendMoney'];
        $cardPrice = $procGiftCard->GetCardPrice($orderItem['orderIndex']);
        $sumPrice = $orderItem['totalOrderMoney'];

        $checkPrintFault = true;
        $orderHistoryArr = $procOrder->GetHistoryDataForOrder($orderIndex);

        $relUrl = UserHistory::getUrlFormat($_SERVER['REQUEST_URI']);
        $r_permit = GlobalFunc::checkPermission($relUrl,'查看订单');

        $u_permit_order = GlobalFunc::checkPermission($relUrl,'修改订单');
        $u_permit_recvinfo = GlobalFunc::checkPermission($relUrl,'修改收货信息');
        $confirm_permit = GlobalFunc::checkPermission($relUrl,'确认订单');
        $d_permit = GlobalFunc::checkPermission($relUrl,'删除订单');
        $pay_permit = GlobalFunc::checkPermission($relUrl,'支付管理');
        $p_permit_send = GlobalFunc::checkPermission($relUrl,'打印配送单');
        $cancelsend_permit = GlobalFunc::checkPermission($relUrl,'取消配送');
        $completesend_permit = GlobalFunc::checkPermission($relUrl,'完成配送');
        $p_permit = GlobalFunc::checkPermission($relUrl,'打印订单');
        $ticket_permit = GlobalFunc::checkPermission($relUrl,'开发票');
        $friendCheck = $_MYSESS['friendCheck'];

        if($friendCheck)
        {
            $u_permit_order = false;
            $u_permit_recvinfo = false;
            $confirm_permit = false;
            $d_permit = false;
            $pay_permit = false;
            $p_permit_send = false;
            $cancelsend_permit = false;
            $completesend_permit = false;
            $p_permit = false;
            $ticket_permit = false;
        }

        //var_dump($pay_permit);

        return $this->render('tblStatusDetail', array (
            'procOrder' => $procOrder,
            'procProduct' => $procProduct,
            'procOrderDetail' => $procOrderDetail,
            'orderItem' => $orderItem,
            'strTitle2' => $strTitle2,
            'sendSpeedStr' => $sendSpeedStr,
            'shopObj' => $shopObj,
            'orderDetailArr' => $orderDetailArr,
            'speedPrice' => $speedPrice,
            'cardPrice' => $cardPrice,
            'sumPrice' => $sumPrice,
            'orderDetailArr' => $orderDetailArr,

            'checkPrintFault' => $checkPrintFault,
            'orderHistoryArr' => $orderHistoryArr,

            'startDate2' => $startDate2,
            'endDate2' => $endDate2,
            'orderIndex' => $orderIndex,
            'orderStatus' => $orderStatus,

            'r_permit' => $r_permit,

            'u_permit_order' => $u_permit_order,
            'u_permit_recvinfo' => $u_permit_recvinfo,
            'confirm_permit' => $confirm_permit,
            'd_permit' => $d_permit,
            'pay_permit' => $pay_permit,
            'p_permit_send' => $p_permit_send,
            'cancelsend_permit' => $cancelsend_permit,
            'completesend_permit' => $completesend_permit,
            'p_permit' => $p_permit,
            'ticket_permit' => $ticket_permit,
        ));
	}
	
	public function actionProductOrdertableEdit($orderIndex)
	{
		$procOrder = new ProductOrder();
		$orderItem = $procOrder->GetOrderRecord($orderIndex);
		$procOrderDetail = new ProductOrderDetail();
		$procRegionObj = new RegionCode();
		
		$globalRgnCode = $procRegionObj->GetRegionCodeArray($orderItem['regionIndex']);
		$rgnCodeArr = explode(",", $globalRgnCode);
		
		$regionCodeArray = $procRegionObj->GetChildClass(0);
		$orderDetailArr = $procOrderDetail->GetOrderDetailArray($orderIndex);
		$cartOrderList = "";
		
		if(count($orderDetailArr) > 0) {
			for($i = 0; $i < count($orderDetailArr); $i++)
			{
				$cartOrderList .= $orderDetailArr[$i]['productIndex'];
				if($orderDetailArr[$i]['orderPoint'] > 0) $cartOrderList .= "@EXE";
				else { if($orderDetailArr[$i]['packNum']> 0) $cartOrderList .= "@".$orderDetailArr[$i]['packNum'];}
				if($orderDetailArr[$i]['orderPoint'] > 0) $cartOrderList .= "@EXE";
				$cartOrderList .= "||".$orderDetailArr[$i]['orderAmount']."|||";
			}
		}
        
        $kindTemp = $orderItem['payKind'];
        $sendSpeed = $orderItem['sendSpeed'];
        
        $payKindStr = GlobalFunc::GetPayKindStr($kindTemp);
        $sendKindStr = GlobalFunc::GetSendKindStr($sendSpeed);
        
		$procShopInfo = new ShopInfo();
		$shopInfoArr = $procShopInfo->GetItemArray();
		
		$procIntroInfo = new IntroRelationship();
		$introTicketInfo = $procIntroInfo->GetItemForOrderNum(2,2);
		$introOrderInfo = $procIntroInfo->GetItemForOrderNum(1,2);
        
        $procAccount = new NetAccount();
        $accountObj = $procAccount->GetNetAccount($orderItem['guestIndex']);

		$relUrl = UserHistory::getUrlFormat($_SERVER['REQUEST_URI']);
        $u_permit_order = GlobalFunc::checkPermission($relUrl,'修改订单');
        $u_permit_recvinfo = GlobalFunc::checkPermission($relUrl,'修改收货信息');

        return $this->render('productorderstatus_table_edit', array(
		        'cartOrderList'=>$cartOrderList,
		    	'orderIndex'=>$orderIndex,
		    	'orderItem'=>$orderItem,
		    	'shopInfoArr'=>$shopInfoArr,
		    	'payKindStr'=>$payKindStr,
		    	'sendKindStr'=>$sendKindStr,
		    	'rgnCodeArr'=>$rgnCodeArr,
		    	'regionCodeArray' => $regionCodeArray,
		    	'introTicketInfo'=>$introTicketInfo,
		    	'introOrderInfo'=>$introOrderInfo,
                'u_permit_order' => $u_permit_order,
                'u_permit_recvinfo' => $u_permit_recvinfo,
                'procRegionObj' => $procRegionObj,
                'accountObj' => $accountObj,
			)	
		);		
	}
	public function actionBtnConfirm()
	{
		$orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
		$procProductOrder = new ProductOrder();
		$procProductOrder->ConfirmOrder($orderIndex);
	}
	
	public function actionEditsettingsave()
	{
		$originOrderIndex = isset($_POST['originOrderIndex']) ? $_POST['originOrderIndex'] : '';
		$recvAddress = isset($_POST['recvAddress']) ? $_POST['recvAddress'] : '';
		$recvPostBox = isset($_POST['recvPostBox']) ? $_POST['recvPostBox'] : '';
		$recvTelNumber = isset($_POST['recvTelNumber']) ? $_POST['recvTelNumber'] : '';
		$recvPhoneNumber = isset($_POST['recvPhoneNumber']) ? $_POST['recvPhoneNumber'] : '';
		$recvEmailAddress = isset($_POST['recvEmailAddress']) ? $_POST['recvEmailAddress'] : '';
		$recvName = isset($_POST['recvName']) ? $_POST['recvName'] : '';
		$regionIndex = isset($_POST['regionIndex']) ? $_POST['regionIndex'] : '';
		$payKind = isset($_POST['payKind']) ? $_POST['payKind'] : '';
		$recvStatus = isset($_POST['recvStatus']) ? $_POST['recvStatus'] : '';
		$cardRealID = isset($_POST['cardRealID']) ? $_POST['cardRealID'] : '';
		$cardRealMoney = isset($_POST['cardRealMoney']) ? $_POST['cardRealMoney'] : '';
		$shopIndex = isset($_POST['shopIndex']) ? $_POST['shopIndex'] : '';
		$invoiceExist = isset($_POST['invoiceExist']) ? $_POST['invoiceExist'] : '';
		$invoiceType = isset($_POST['invoiceType']) ? $_POST['invoiceType'] : '';
		$invoiceTarget = isset($_POST['invoiceTarget']) ? $_POST['invoiceTarget'] : '';
		$invoiceContent = isset($_POST['invoiceContent']) ? $_POST['invoiceContent'] : '';
		$reciptUnitName = isset($_POST['reciptUnitName']) ? $_POST['reciptUnitName'] : '';
		$reciptName = isset($_POST['reciptName']) ? $_POST['reciptName'] : '';
		$reciptAddress = isset($_POST['reciptAddress']) ? $_POST['reciptAddress'] : '';
		$reciptTelNumber = isset($_POST['reciptTelNumber']) ? $_POST['reciptTelNumber'] : '';
		$reciptBank = isset($_POST['reciptBank']) ? $_POST['reciptBank'] : '';
		$reciptAccount = isset($_POST['reciptAccount']) ? $_POST['reciptAccount'] : '';
		$cartOrder = isset($_POST['cartOrder']) ? $_POST['cartOrder'] : '';
		$orderContent = isset($_POST['orderContent']) ? $_POST['orderContent'] : '';
		$cardRealPWD = isset($_POST['cardRealPWD']) ? $_POST['cardRealPWD'] : '';
		$changeContent = isset($_POST['changeContent']) ? $_POST['changeContent'] : '';
		$netMoneyCheck = isset($_POST['netMoneyCheck']) ? $_POST['netMoneyCheck'] : '';
		
		$procProduct = new Product();
		$procRegionObj = new RegionCode();	
		$procProductOrder = new ProductOrder();
		$procOrderDetail = new ProductOrderDetail();

		$orderItem = $procProductOrder->GetOrderRecord($originOrderIndex);
		
		$readStatus = "0";
		if(isset($originOrderIndex)){
			if($originOrderIndex > 0){
				$orderItem = $procProductOrder->GetOrderRecord($originOrderIndex);
				$orderTicketNumber = $orderItem['orderTicketNumber'];
				$orderDate = $orderItem['orderDate'];
				$guestIndex = $orderItem['guestIndex'];
				$readStatus = $orderItem['readStatus'];
				$procOrderDetail->Delete_user($originOrderIndex, "");
				$procProductOrder->Delete_user($originOrderIndex);
			}
		}

		if($invoiceExist == 0)
		{
			$invoiceType = 0;
			$invoiceTarget = 0;
			$invoiceContent = 0;
			$reciptUnitName = "";
			$reciptName = "";
			$reciptAddress = "";
			$reciptTelNumber = "";
			$reciptBank = "";
			$reciptAccount = "";
		}
		if($invoiceType==1){
			$reciptName = "";
			$reciptAddress = "";
			$reciptTelNumber = "";
			$reciptBank = "";
			$reciptAccount = "";
			if($invoiceTarget==0) $reciptUnitName = "";
		}
		
		$totalMoney = 0;
		$sendMoney = 0;
		$cardUseMoney = 0;
		
		$reciptExistVal = $invoiceExist;
		$reciptTypeVal = $invoiceType;
		$recvType = $recvStatus;
		$orderProductCount = 0;
		
		$cartOrderItemArr = explode("|||", $cartOrder);
		if(count($cartOrderItemArr)>1){
			if(($recvStatus != "2")&&($regionIndex)){
				$procRegionItem = $procRegionObj->GetItem($regionIndex);
				$sendMoney = $procRegionItem['regionInfo'];
			}
			for($i=0; $i<count($cartOrderItemArr)-1; $i++){
				$productItemArr = explode("||", $cartOrderItemArr[$i]);
				$productInfoArr = explode("@",$productItemArr[0]);
				$orderProductCount += $productItemArr[1];
				$productIndex = $productInfoArr[0];
				if(count($productInfoArr)>1) $productPackIndex = $productInfoArr[1]; else $productPackIndex = 0;
				$productObj = $procProduct->GetProductItem($productIndex);
				
				$productPriceNow = round($productObj['productPriceNow']* ($productObj['discountRate'])/100, 2);
				if(($reciptExistVal==0)&&($productObj['chkTicket']== 0)) $productPriceNow = $productObj['productPriceNow']* (100 - $productObj['receiptGeneralRate']) /100;
				if(($reciptExistVal)&&($productObj['chkTicket']== 2)){
					if($reciptTypeVal == 1) $productPriceNow = $productObj['productPriceNow']* (100 + $productObj['receiptGeneralRate']) /100;
					else $productPriceNow = $productObj['productPriceNow']* (100 + $productObj['receiptVATRate']) /100;
				}
				if(isset($productInfoArr[1]) && ($productInfoArr[1] == "EXE")){
					$productPackIndex = 0;
					$productPriceNow = $productObj['pointLowPrice'];
				}
				if(($recvType != "2")&&($productPriceNow>0)) $sendMoney += $productObj['carriageCharge']* $productItemArr[1];
				
				$productPackagePrice = 0;
				if($productPackIndex){
					$packNum = $procProduct->GetProductPackageNumber($productIndex, $productPackIndex);
					$productPackagePrice = $procProduct->GetProductPackageReceiptPrice($productIndex, $productPackIndex, $reciptExistVal, $reciptTypeVal);
					if($recvType != "2") $sendMoney += $procProduct->GetProductPackageCarriageCharge($productIndex, $productPackIndex) * $productItemArr[1];
				} 
				$productPriceNow += $productPackagePrice;
				$totalMoney += $productPriceNow * $productItemArr[1];
			}
		}
		if($orderProductCount){
		    $procGiftCard = new UserGiftCard();			
		    
		    if($originOrderIndex == 0){
			    $orderTicketNumber = $procProductOrder->GenTicketNumber();
			    $guestIndex = Yii::$app->user->id;
		}
		
		if($cardRealMoney>0){
			$cardRealMoney = 0;
			$cardIDArr = explode("#", $cardRealID);
			for($i=1; $i<count($cardIDArr); $i++){
				$cardRealMoney += $procGiftCard->GetGiftCardRemain2($cardIDArr[$i], $guestIndex);
			}
		}
		if($totalMoney + $sendMoney >= $cardRealMoney) $cardUseMoney = $cardRealMoney;
		else $cardUseMoney = $totalMoney + $sendMoney;
		
		$netUseMoney = 0;
		if($netMoneyCheck > 0){
			$procAccount = new NetAccount();
			$netAccountObj = $procAccount->GetNetAccount($guestIndex);
			$remainNetMoney = $netAccountObj['netMoney'];
			if($totalMoney + $sendMoney - $cardUseMoney >= $remainNetMoney) $netUseMoney = $remainNetMoney;
			else $netUseMoney = $totalMoney + $sendMoney - $cardUseMoney;
		}
		
		$orderIndex = $procProductOrder->Register_user($guestIndex, $orderTicketNumber, $recvName, $regionIndex, $recvAddress, $recvPostBox, $recvPhoneNumber, $recvTelNumber, $recvEmailAddress, $recvStatus, 0, $payKind, 1+$recvStatus, $shopIndex, $orderContent, $invoiceType, $invoiceTarget, $invoiceContent, $reciptUnitName, $reciptName, $reciptAddress, $reciptTelNumber, $reciptBank, $reciptAccount, $totalMoney + $sendMoney - $cardUseMoney - $netUseMoney, $sendMoney, 0, $netUseMoney, $totalMoney + $sendMoney);
		
		if(isset($originOrderIndex)){
			if($originOrderIndex > 0){
				$procProductOrder->UpdateOrderIndex($originOrderIndex, $orderIndex);
				$orderIndex = $originOrderIndex;
				$procProductOrder->UpdateReadStatus($orderIndex, $readStatus, $changeContent, $orderDate);
			}
		}
		if($cardUseMoney > 0){
			for($i=1; $i<count($cardIDArr); $i++){
				if($cardUseMoney > 0){
					$cardRemainMoney = $procGiftCard->GetGiftCardRemain2($cardIDArr[$i], $guestIndex);
					if($cardUseMoney > $cardRemainMoney) $cardSubUseMoney = $cardRemainMoney; else $cardSubUseMoney = $cardUseMoney;
					$cardUseMoney = $cardUseMoney - $cardSubUseMoney;
					$procGiftCard->UpdateGiftCardUse2($orderIndex, $cardIDArr[$i], $guestIndex, $cardSubUseMoney);
				}
			}
		}
		if($netUseMoney > 0){
			$procAccount = new NetAccount();
			$procAccount->NetMoneyOutput($guestIndex, $netUseMoney, 0, "");
		}

		$cartOrderItemArr = explode("|||", $cartOrder);
		if(count($cartOrderItemArr)>1){
			for($i=0; $i<count($cartOrderItemArr)-1; $i++){
				$productItemArr = explode("||", $cartOrderItemArr[$i]);
				$productInfoArr = explode("@",$productItemArr[0]);
				$productIndex = $productInfoArr[0];
				if(count($productInfoArr)>1) 
					$productPackIndex = $productInfoArr[1]; 
				else 
					$productPackIndex = 0;
				$productObj = $procProduct->GetProductItem($productIndex);
				
				$productPriceNow = round($productObj['productPriceNow']* ($productObj['discountRate'])/100, 2);
				if(($reciptExistVal==0)&&($productObj['chkTicket']== 0)) $productPriceNow = $productObj['productPriceNow']* (100 - $productObj['receiptGeneralRate']) /100;
				if(($reciptExistVal)&&($productObj['chkTicket']== 2)){
					if($reciptTypeVal == 1) 
						$productPriceNow = $productObj['productPriceNow']* (100 + $productObj['receiptGeneralRate']) /100;
					else 
						$productPriceNow = $productObj['productPriceNow'] * (100 + $productObj['receiptVATRate']) /100;
				}
				
				$pointRec = 0;
				if(isset($productInfoArr[1]) && ($productInfoArr[1] == "EXE")){
					$productPackIndex = 0;
					$productPriceNow = $productObj['pointLowPrice'];
					$pointRec = $productObj['pointPrice'];
				}
				$productPackagePrice = 0;
				if($productPackIndex){
					$packNum = $procProduct->GetProductPackageNumber($productIndex, $productPackIndex);
					$productPackagePrice = $procProduct->GetProductPackageReceiptPrice($productIndex, $productPackIndex, $reciptExistVal, $reciptTypeVal);
				} 
				$productPriceNow += $productPackagePrice;
				if($productPackIndex == "") $productPackIndex = 0;
				if($productItemArr[1]) $procOrderDetail->Register_user($orderIndex, $productIndex, $productItemArr[1], $productPriceNow, $productPackIndex, $pointRec);
			}
		}
		echo $orderIndex;
		}
	}
	
    public function actionAfterService()
    {
        $orderYear = isset($_POST['orderYear']) ? $_POST['orderYear'] : date('Y');
        $orderMonth = isset($_POST['orderMonth']) ? $_POST['orderMonth'] : date('M');
        $repairType = isset($_POST['repairType']) ? $_POST['repairType'] : '';
        $processStatus = isset($_POST['processStatus']) ? $_POST['processStatus'] : '';
        $orderTicketNumber = isset($_POST['orderTicketNumber']) ? $_POST['orderTicketNumber'] : '';
        $curPage = isset($_POST['curPage']) ? $_POST['curPage'] : 1;

        $procRepair = new GuestRepair();
        $procProduct = new Product();
        $procRegionObj = new RegionCode();    
        $retArrayTemp = $procRepair->GetRepairArr($orderYear, $orderMonth, $repairType, $processStatus, $orderTicketNumber);
        $repairStatusDateStrArr = array('requestDate', 'processDate', 'completeDate', 'cancelDate');
        
        $n = 5;
        $retCount = 0; 

        $retArrayTempFilter = array();
        foreach($retArrayTemp as $row){
            $productArr = $procRepair->GetProductArraFromMain($row['repairIndex']);
            $productIndex = $procProduct->changeProductIndex($productArr[0]['productIndex']);
            if($productIndex){
                $retCount++;
                array_push($retArrayTempFilter, $row);    
            }
        }

        $retArray = array_slice($retArrayTempFilter, ($curPage - 1) * $n, $n);
        $cont_tblaservice = $this->renderPartial('tblAService', [
            'retArray'=>$retArray,
            'procRepair'=>$procRepair,
            'procProduct'=>$procProduct,
            'procRegionObj'=>$procRegionObj,
            'repairStatusDateStrArr'=>$repairStatusDateStrArr,
            'retCount' => $retCount,
            'n' => $n,
            'curPage' => $curPage,
        ], true);

        return $this->render('afterService' , [
            'cont_tblaservice'=>$cont_tblaservice,
        ]);
    }

    public function actionCancelAsk()
    {        
        $orderYear = isset($_POST['orderYear']) ? $_POST['orderYear'] : date('Y');
        $orderMonth = isset($_POST['orderMonth']) ? $_POST['orderMonth'] : date('M');
        $processStatus = isset($_POST['processStatus']) ? $_POST['processStatus'] : '';
        $orderTicketNumber = isset($_POST['orderTicketNumber']) ? $_POST['orderTicketNumber'] : '';

        $curPage = isset($_POST['curPage']) ? $_POST['curPage'] : 1;
        
        $procReturn = new GuestReturn();
        $procGiftCard = new UserGiftCard();
        $retArrayTemp = $procReturn->GetReturnArr($orderYear, $orderMonth, $processStatus, $orderTicketNumber);
        $returnStatusStrArr  = array('等待审核', '正在处理', '退款成功', '已撤消');
        
        $n =5;
        $retCount = count($retArrayTemp);
        $retArray = array_slice($retArrayTemp, ($curPage - 1) * $n, $n);
        
        return $this->render('cancelAsk' , array(
            'procReturn'=>$procReturn,
            'procGiftCard'=>$procGiftCard,
            'retArray'=>$retArray,
            'returnStatusStrArr'=>$returnStatusStrArr,            
            'n' => $n, 
            'retCount' => $retCount,
            'curPage' => $curPage,
            'mycon'=>$this,
        ));
    }
    
    public function actionPFuncModule25()
    {
        $orderYear = isset($_POST['orderYear']) ? $_POST['orderYear'] : '';
        $orderMonth = isset($_POST['orderMonth']) ? $_POST['orderMonth'] : '';
        $repairType = isset($_POST['repairType']) ? $_POST['repairType'] : '';
        $processStatus = isset($_POST['processStatus']) ? $_POST['processStatus'] : '';
        $orderTicketNumber = isset($_POST['orderTicketNumber']) ? $_POST['orderTicketNumber'] : '';

        $curPage = isset($_POST['curPage']) ? $_POST['curPage'] : 1;
        
        $procRepair = new GuestRepair();
        $procProduct = new Product();
        $procRegionObj = new RegionCode();    
        $retArrayTemp = $procRepair->GetRepairArr($orderYear, $orderMonth, $repairType, $processStatus, $orderTicketNumber);
        $repairStatusDateStrArr = array('requestDate', 'processDate', 'completeDate', 'cancelDate');
        
        $n = 5;
        $retCount = 0; 

        $retArrayTempFilter = array();
        foreach($retArrayTemp as $row){
            $productArr = $procRepair->GetProductArraFromMain($row['repairIndex']);
            $productIndex = $procProduct->changeProductIndex($productArr[0]['productIndex']);
            if($productIndex){
                $retCount++;
                array_push($retArrayTempFilter, $row);    
            }
        }
        $retArray = array_slice($retArrayTempFilter, ($curPage - 1) * $n, $n);

        return $this->renderPartial('tblAService', array(
            'retArray'=>$retArray,
            'procRepair'=>$procRepair,
            'procProduct'=>$procProduct,
            'procRegionObj'=>$procRegionObj,
            'repairStatusDateStrArr'=>$repairStatusDateStrArr,
            
            'n' => $n,
            'retCount' => $retCount,
            'curPage' => $curPage,
        ));
    }
    
    public function actionPFuncModule27()
    {
        $orderYear = isset($_POST['orderYear']) ? $_POST['orderYear'] : '';
        $orderMonth = isset($_POST['orderMonth']) ? $_POST['orderMonth'] : '';
        $processStatus = isset($_POST['processStatus']) ? $_POST['processStatus'] : '';
        $orderTicketNumber = isset($_POST['orderTicketNumber']) ? $_POST['orderTicketNumber'] : '';
        $curPage = isset($_POST['curPage']) ? $_POST['curPage'] : 1;

        $procReturn = new GuestReturn();
        $procGiftCard = new UserGiftCard();
        $retArrayTemp = $procReturn->GetReturnArr($orderYear, $orderMonth, $processStatus, $orderTicketNumber);
        $returnStatusStrArr  = array('等待审核', '正在处理', '退款成功', '已撤消');
        
        $n =5;
        $retCount = count($retArrayTemp);
        $retArray = array_slice($retArrayTemp, ($curPage - 1) * $n, $n);
        
        return $this->renderPartial('tblCancelAsk', [
            'procReturn'=>$procReturn,
            'procGiftCard'=>$procGiftCard,
            'retArray'=>$retArray,
            'returnStatusStrArr'=>$returnStatusStrArr,
            'n' => $n, 
            'retCount' => $retCount,
            'curPage' => $curPage,
            'mycon'=>$this,
        ]);
    }
	
	public function actionLoadorderdata()
	{
		$procProduct = new Product();
        $procRegionObj = new RegionCode();    
        $procAccount = new NetAccount();
        
        $cartOrder = isset($_GET['cartOrder']) ? $_GET['cartOrder'] : "";
        $recvType = isset($_GET['recvType']) ? $_GET['recvType'] : 0;
        $recvRegionIndex = isset($_GET['recvRegionIndex']) ? $_GET['recvRegionIndex'] : 0;
        $cardRealMoney = isset($_GET['cardRealMoney']) ? $_GET['cardRealMoney'] : 0;
        $netMoneyCheck = isset($_GET['netMoneyCheck']) ? $_GET['netMoneyCheck'] : "";
        $reciptExistVal = isset($_GET['reciptExistVal']) ? $_GET['reciptExistVal'] : "";
        $reciptTypeVal = isset($_GET['reciptTypeVal']) ? $_GET['reciptTypeVal'] : "";

        return $this->renderPartial('ProductOrderStatus_table_edit_footer', array(
            'procProduct'=>$procProduct,    
            'procRegionObj'=>$procRegionObj,
            'procAccount'=>$procAccount,
            'cartOrder'=>$cartOrder,
            'recvType'=>$recvType,
            'recvRegionIndex'=>$recvRegionIndex,
            'cardRealMoney'=>$cardRealMoney,
            'netMoneyCheck'=>$netMoneyCheck ,
            'reciptExistVal'=>$reciptExistVal,
            'reciptTypeVal'=>$reciptTypeVal,
        ));	
	}

	public function actionTicketbox($orderIndex)
    {
        $relUrl = UserHistory::getUrlFormat($_SERVER['REQUEST_URI']);
        $ticket_permit = GlobalFunc::checkPermission($relUrl,'开发票');
        
        $procOrder = new ProductOrder();
        $procUser = new UserDB2();
        $orderItem = $procOrder->GetOrderRecord($orderIndex);
        $userObj = $procUser->GetItem($orderItem['ticketUserIndex']);

        return $this->renderPartial('tblStatusDetail_ticketBox', array(
            'orderIndex' => $orderIndex,
            'orderItem' => $orderItem,    
            'procOrder' => $procOrder,
            'procUser' => $procUser,
            'userObj' => $userObj,
            'ticket_permit' => $ticket_permit,
        ));
    }
    
    public function actionConfirmbutton($orderIndex)
    {
        $procProductOrder = new ProductOrder();
        $procProductOrder->ConfirmOrder($orderIndex);
    }
    
    public function actionPaymentbutton()
    {
        $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
        $userID = isset($_POST['userID']) ? $_POST['userID'] : "";
        $procOrder = new ProductOrder();
        $procUser = new UserDB2();
        $orderIndex = $_POST['orderIndex'];
        $orderItem = $procOrder->GetOrderRecord($orderIndex);
       
        $procOrderMoney = new ProductOrderMoney();
        $orderMoneyArr = $procOrderMoney->GetPayRecords($orderIndex);
       
        $payKindStr = GlobalFunc::GetPayKindStr($orderItem['payKind']);
        
        $relUrl = UserHistory::getUrlFormat($_SERVER['REQUEST_URI']);
        $pay_permit = GlobalFunc::checkPermission($relUrl,'支付管理');

        return $this->renderPartial('detail_thick_payment', array (
            'userID' => $userID,
            'orderItem' => $orderItem,
            'orderMoneyArr' => $orderMoneyArr,
            'payKindStr' =>$payKindStr,
            'pay_permit' => $pay_permit,    
        ));
    }
    
    public function actionSendbutton()
    {
        $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
        
        $procProduct = new Product();
        $procOrder = new ProductOrder();
        $procOrderDetail = new ProductOrderDetail();
        $procUser = new UserDB2();
        $orderItem = $procOrder->GetOrderRecord($orderIndex);
        
        $sendKindStr = GlobalFunc::GetSendKindStr($orderItem['sendSpeed']);
        
        $userObj = $procUser->GetItem($orderItem['sendUserIndex']);                    

        $orderDetailArr = $procOrderDetail->GetOrderDetailArray($orderIndex);
        
        $relUrl = UserHistory::getUrlFormat($_SERVER['REQUEST_URI']);
        $r_permit = GlobalFunc::checkPermission($relUrl,'查看订单');
        
        $p_permit_send = GlobalFunc::checkPermission($relUrl,'打印配送单');        //1
        $cancelsend_permit = GlobalFunc::checkPermission($relUrl,'取消配送');        //1
        $completesend_permit = GlobalFunc::checkPermission($relUrl,'完成配送');         //1

        return $this->renderPartial('detail_thick_send', array(
            'procProduct' => $procProduct,
            'orderItem' => $orderItem,
            'sendKindStr' => $sendKindStr,
            'userObj' => $userObj,
            'orderDetailArr' => $orderDetailArr,
            
            'p_permit_send' => $p_permit_send,
            'cancelsend_permit' => $cancelsend_permit,
            'completesend_permit' => $completesend_permit,
        ));
    }
    
    public function actionCancelorder()
    {
        $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
        $cancelContent = isset($_POST['cancelContent']) ? $_POST['cancelContent'] : "";
        $agreeCheck = isset($_POST['agreeCheck']) ? $_POST['agreeCheck'] : ""; 
        $d_permit = isset($_POST['d_permit']) ? $_POST['d_permit'] : "";
        
        if($d_permit)
        {
            $procProductOrder = new ProductOrder();
            if($agreeCheck > 0)
                $cancelContent .= " (是经过用户同意)";
            else
                $cancelContent .= " (否经过用户同意)";
            $procProductOrder->Delete2($orderIndex, $cancelContent);
        } 
    }
    
    public function actionOutbutton()
    {
        $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
        $p_permit_send = isset($_POST['p_permit_send']) ? $_POST['p_permit_send'] : false;        
        
        if($p_permit_send)
        {
            $procProductOrder = new ProductOrder();
            $procProductOrder->ConfirmOut($orderIndex);
        } 
    }
    
    public function actionInputbutton()
    {
        $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
        $p_permit_send = isset($_POST['p_permit_send']) ? $_POST['p_permit_send'] : false;        
        
        if($p_permit_send)
        {
            $procProductOrder = new ProductOrder();
            $procProductOrder->ConfirmInput($orderIndex);
        } 
    }
    
    public function actionListsendinfo()
	{
	}
	
    public function actionSaveTicket()
    {
        
        $ticket_permit = isset($_POST['ticket_permit']) ? $_POST['ticket_permit'] : false;
        //CheckOrderPermit();
        //if($ticket_permit){
        //    logUserHistory(37, 10);
        if($ticket_permit) {
            $procProductOrder = new ProductOrder();
            
            $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
            $ticketMoney = isset($_POST['ticketMoney']) ? $_POST['ticketMoney'] : "";
            $ticketContent = isset($_POST['ticketContent']) ? $_POST['ticketContent'] : "";
            $ticketNumber = isset($_POST['ticketNumber']) ? $_POST['ticketNumber'] : "";
            $procProductOrder->GenOrderTicket($orderIndex, $ticketMoney, $ticketContent, $ticketNumber);
        } 
        //else logUserHistory(37, 10, false);
        
    }
    
    public function actionCancelTicket()
    {
        $ticket_permit = isset($_POST['ticket_permit']) ? $_POST['ticket_permit'] : false;
        
        //CheckOrderPermit();
        if($ticket_permit){
            //logUserHistory(37, 11);
            $procProductOrder = new ProductOrder();
            $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
            $procProductOrder->CancelOrderTicket($orderIndex);
        } 
        //else logUserHistory(37, 11, false);
    }
    
    public function actionSavePay()
    {
        $pay_permit = isset($_POST['pay_permit']) ? $_POST['pay_permit'] : false;
        
        //CheckOrderPermit();
        if($pay_permit){
            //logUserHistory(38, 1);
            $procOrderMoney = new ProductOrderMoney();
            
            $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
            $payKind = isset($_POST['payKind']) ? $_POST['payKind'] : "";
            $moneyNumber = isset($_POST['moneyNumber']) ? $_POST['moneyNumber'] : "";
            $moneyAmount = isset($_POST['moneyAmount']) ? $_POST['moneyAmount'] : "";
            $moneyInfo = isset($_POST['moneyInfo']) ? $_POST['moneyInfo'] : "";
            $procOrderMoney->RegisterOrderMoney($orderIndex, $payKind, $moneyNumber, $moneyAmount, $moneyInfo);
        }
        // else logUserHistory(38, 1, false);
    }
    
    public function actionDelPayRecord()
    {
        
        $pay_permit = isset($_POST['pay_permit']) ? $_POST['pay_permit'] : false;
        //CheckOrderPermit();
        if($pay_permit){
            //logUserHistory(38, 3);
            $procOrderMoney = new ProductOrderMoney();
            
            $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
            $moneyIndex = isset($_POST['moneyIndex']) ? $_POST['moneyIndex'] : "";
            
            $procOrderMoney->CancelOrderMoney($orderIndex, $moneyIndex);
        } 
        //else logUserHistory(38, 3, false);
    }
    
    public function actionSendOk()
    {
        $p_permit_send = isset($_POST['p_permit_send']) ? $_POST['p_permit_send'] : false;
        //CheckOrderPermit();
        if($p_permit_send){
            //logUserHistory(39, 9);
            $procOrder = new ProductOrder();
            $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
            $sendTicketNumber = isset($_POST['sendTicketNumber']) ? $_POST['sendTicketNumber'] : "";
            $procOrder->RegisterSend($orderIndex, $sendTicketNumber);
        }
        // else logUserHistory(39, 9, false);
    }
    
    public function actionSendCancel()
    {
        $cancelsend_permit = isset($_POST['cancelsend_permit']) ? $_POST['cancelsend_permit'] : false;
        //CheckOrderPermit();
        if($cancelsend_permit){
            //logUserHistory(39, 11);
            $procOrder = new ProductOrder();
            $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
            $procOrder->CancelSend($orderIndex);
        } 
        //else logUserHistory(39, 11, false);
    }
    
    public function actionSendComplete()
    {
        $completesend_permit = isset($_POST['completesend_permit']) ? $_POST['completesend_permit'] : false;
        //CheckOrderPermit();
        if($completesend_permit){
            //logUserHistory(39, 12);
            $procOrder = new ProductOrder();
            $orderIndex = isset($_POST['orderIndex']) ? $_POST['orderIndex'] : "";
            $procOrder->CompleteSend($orderIndex);
        }
        // else logUserHistory(39, 12, false);
    }
    
    public function actionLocationInfoEdit()
    {
        $procRegionObj = new RegionCode();    
                
        $regionIndex = isset($_POST['regionIndex']) ? $_POST['regionIndex'] : 0;
        $globalRgnCode = $procRegionObj->GetRegionCodeArray($regionIndex);
        $rgnCodeArr = explode(",", $globalRgnCode);
        $regionCodeArray = $procRegionObj->GetChildClass(0);
        //$rgnCodeArr = explode(",", $globalRgnCode);

        return $this->renderPartial('LocationInfoEdit', array(
            'procRegionObj' => $procRegionObj,
            'rgnCodeArr' => $rgnCodeArr,
            'regionCodeArray' => $regionCodeArray,
        ));
    }
    
    public function actionProvChange()
    {
        $parentIndex = isset($_POST['parentIndex']) ? $_POST['parentIndex'] : 0;
        $procRegionCode = new RegionCode();
        $regionCodeArray = $procRegionCode->GetChildClass($parentIndex);
        for($i = 0; $i < count($regionCodeArray); $i++)
            echo '<option value="'.$regionCodeArray[$i]['regionIndex'].'">'.$regionCodeArray[$i]['regionID'].'</option>';
    }
    
    public function actionProcessRepair()
    {
        
        $relUrl = UserHistory::model()->getUrlFormat($_SERVER['REQUEST_URI']);
        $i_permit = GlobalFunc::checkPermission($relUrl,'售后服务');
        $u_permit = GlobalFunc::checkPermission($relUrl,'售后服务');
        
        $repairIndex = isset($_POST['repairIndex']) ? $_POST['repairIndex'] : "";
        $processStatus = isset($_POST['processStatus'])? $_POST['processStatus'] : "";
        $historyContent = isset($_POST['historyContent'])? $_POST['historyContent'] : "";
        
        if($i_permit||$u_permit){
            $noErr = true;
            $procRepair = new GuestRepair();
            $repairObj = $procRepair->GetProductArraFromMain($repairIndex);
            $productIndex = $repairObj[0]['productIndex'];
            $procProduct = new Product();
            $productIndex = $procProduct->changeProductIndex($productIndex);                    
            if($productIndex) 
                $procRepair->UpdateProcess($repairIndex, $processStatus, $historyContent);
            else 
                $noErr = false;
        }
        //logUserHistory(27, 5, $noErr, " (".$repairStatusStrArr[$processStatus].")");
    }
    
    
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Productorder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProductOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Productorder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='productorder-form')
		{
			echo CActiveForm::validate($model);
			Yii::$app->end();
		}
	}
}
