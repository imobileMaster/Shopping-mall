<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_productorder".
 *
 * The followings are the available columns in table 'tbl_productorder':
 * @property string $orderIndex
 * @property integer $guestIndex
 * @property string $orderDate
 * @property string $orderTicketNumber
 * @property string $recvName
 * @property string $regionIndex
 * @property string $recvAddress
 * @property string $recvPostBox
 * @property string $recvPhoneNumber
 * @property string $recvTelNumber
 * @property string $recvEmailAddress
 * @property integer $sendSpeed
 * @property integer $recvPlace
 * @property integer $payKind
 * @property integer $recvStatus
 * @property integer $shopIndex
 * @property string $orderCancelDate
 * @property string $orderCancelUserIndex
 * @property string $confirmDate
 * @property string $payInitialDate
 * @property string $payCompleteDate
 * @property string $productOutDate
 * @property string $sendDate
 * @property string $recvDate
 * @property string $ticketDate
 * @property string $completeDate
 * @property integer $orderStatus
 * @property string $orderContent
 * @property string $readUserIndex
 * @property integer $invoiceType
 * @property integer $invoiceTarget
 * @property integer $invoiceContent
 * @property string $reciptUnitName
 * @property string $reciptName
 * @property string $reciptAddress
 * @property string $reciptTelNumber
 * @property string $reciptBank
 * @property string $reciptAccount
 * @property string $totalOrderMoney
 * @property string $orderMoney
 * @property string $sendMoney
 * @property string $recvMoney
 * @property string $netMoney
 * @property string $useCardMoney
 * @property integer $returnStatus
 * @property string $readStatus
 * @property string $confirmStatus
 * @property integer $pseudoCheck
 * @property string $changeDate
 * @property string $changeUserIndex
 * @property string $changeUserIP
 * @property string $changeContent
 * @property string $confirmUserIndex
 * @property string $confirmUserIP
 * @property string $paymentUserIndex
 * @property string $paymentUserIP
 * @property string $paymentContent
 * @property string $sendUserIndex
 * @property string $sendUserIP
 * @property string $recvUserIndex
 * @property string $recvUserIP
 * @property string $ticketNumber
 * @property string $ticketMoney
 * @property string $ticketUserIndex
 * @property string $ticketUserIP
 * @property string $ticketContent
 * @property string $sendTicketNumber
 * @property string $sendReqDate
 */
class ProductOrder extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_productorder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderContent, readUserIndex, readStatus, confirmStatus', 'required'),
			array('guestIndex, sendSpeed, recvPlace, payKind, recvStatus, shopIndex, orderStatus, invoiceType, invoiceTarget, invoiceContent, returnStatus, pseudoCheck', 'numerical', 'integerOnly'=>true),
			array('orderTicketNumber, recvName, recvAddress, recvPostBox, recvPhoneNumber, recvTelNumber, recvEmailAddress, reciptUnitName, reciptAddress, reciptTelNumber, reciptBank, reciptAccount, changeUserIP, confirmUserIP, paymentUserIP, paymentContent, sendUserIP, recvUserIP, ticketNumber, ticketUserIP, sendTicketNumber', 'length', 'max'=>200),
			array('regionIndex, orderCancelUserIndex, changeUserIndex, confirmUserIndex, paymentUserIndex, sendUserIndex, recvUserIndex, ticketMoney, ticketUserIndex', 'length', 'max'=>20),
			array('reciptName', 'length', 'max'=>100),
			array('totalOrderMoney, orderMoney, sendMoney, recvMoney, netMoney', 'length', 'max'=>13),
			array('useCardMoney', 'length', 'max'=>10),
			array('changeContent, ticketContent', 'length', 'max'=>255),
			array('orderDate, orderCancelDate, confirmDate, payInitialDate, payCompleteDate, productOutDate, sendDate, recvDate, ticketDate, completeDate, changeDate, sendReqDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderIndex, guestIndex, orderDate, orderTicketNumber, recvName, regionIndex, recvAddress, recvPostBox, recvPhoneNumber, recvTelNumber, recvEmailAddress, sendSpeed, recvPlace, payKind, recvStatus, shopIndex, orderCancelDate, orderCancelUserIndex, confirmDate, payInitialDate, payCompleteDate, productOutDate, sendDate, recvDate, ticketDate, completeDate, orderStatus, orderContent, readUserIndex, invoiceType, invoiceTarget, invoiceContent, reciptUnitName, reciptName, reciptAddress, reciptTelNumber, reciptBank, reciptAccount, totalOrderMoney, orderMoney, sendMoney, recvMoney, netMoney, useCardMoney, returnStatus, readStatus, confirmStatus, pseudoCheck, changeDate, changeUserIndex, changeUserIP, changeContent, confirmUserIndex, confirmUserIP, paymentUserIndex, paymentUserIP, paymentContent, sendUserIndex, sendUserIP, recvUserIndex, recvUserIP, ticketNumber, ticketMoney, ticketUserIndex, ticketUserIP, ticketContent, sendTicketNumber, sendReqDate', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			"userinfo"=>array(self::BELONGS_TO,'Userinfo', 'guestIndex'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'orderIndex' => 'Order Index',
			'guestIndex' => 'Guest Index',
			'orderDate' => 'Order Date',
			'orderTicketNumber' => 'Order Ticket Number',
			'recvName' => 'Recv Name',
			'regionIndex' => 'Region Index',
			'recvAddress' => 'Recv Address',
			'recvPostBox' => 'Recv Post Box',
			'recvPhoneNumber' => 'Recv Phone Number',
			'recvTelNumber' => 'Recv Tel Number',
			'recvEmailAddress' => 'Recv Email Address',
			'sendSpeed' => 'Send Speed',
			'recvPlace' => 'Recv Place',
			'payKind' => 'Pay Kind',
			'recvStatus' => 'Recv Status',
			'shopIndex' => 'Shop Index',
			'orderCancelDate' => 'Order Cancel Date',
			'orderCancelUserIndex' => 'Order Cancel User Index',
			'confirmDate' => 'Confirm Date',
			'payInitialDate' => 'Pay Initial Date',
			'payCompleteDate' => 'Pay Complete Date',
			'productOutDate' => 'Product Out Date',
			'sendDate' => 'Send Date',
			'recvDate' => 'Recv Date',
			'ticketDate' => 'Ticket Date',
			'completeDate' => 'Complete Date',
			'orderStatus' => 'Order Status',
			'orderContent' => 'Order Content',
			'readUserIndex' => 'Read User Index',
			'invoiceType' => 'Invoice Type',
			'invoiceTarget' => 'Invoice Target',
			'invoiceContent' => 'Invoice Content',
			'reciptUnitName' => 'Recipt Unit Name',
			'reciptName' => 'Recipt Name',
			'reciptAddress' => 'Recipt Address',
			'reciptTelNumber' => 'Recipt Tel Number',
			'reciptBank' => 'Recipt Bank',
			'reciptAccount' => 'Recipt Account',
			'totalOrderMoney' => 'Total Order Money',
			'orderMoney' => 'Order Money',
			'sendMoney' => 'Send Money',
			'recvMoney' => 'Recv Money',
			'netMoney' => 'Net Money',
			'useCardMoney' => 'Use Card Money',
			'returnStatus' => 'Return Status',
			'readStatus' => 'Read Status',
			'confirmStatus' => 'Confirm Status',
			'pseudoCheck' => 'Pseudo Check',
			'changeDate' => 'Change Date',
			'changeUserIndex' => 'Change User Index',
			'changeUserIP' => 'Change User Ip',
			'changeContent' => 'Change Content',
			'confirmUserIndex' => 'Confirm User Index',
			'confirmUserIP' => 'Confirm User Ip',
			'paymentUserIndex' => 'Payment User Index',
			'paymentUserIP' => 'Payment User Ip',
			'paymentContent' => 'Payment Content',
			'sendUserIndex' => 'Send User Index',
			'sendUserIP' => 'Send User Ip',
			'recvUserIndex' => 'Recv User Index',
			'recvUserIP' => 'Recv User Ip',
			'ticketNumber' => 'Ticket Number',
			'ticketMoney' => 'Ticket Money',
			'ticketUserIndex' => 'Ticket User Index',
			'ticketUserIP' => 'Ticket User Ip',
			'ticketContent' => 'Ticket Content',
			'sendTicketNumber' => 'Send Ticket Number',
			'sendReqDate' => 'Send Req Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('orderIndex',$this->orderIndex,true);
		$criteria->compare('guestIndex',$this->guestIndex);
		$criteria->compare('orderDate',$this->orderDate,true);
		$criteria->compare('orderTicketNumber',$this->orderTicketNumber,true);
		$criteria->compare('recvName',$this->recvName,true);
		$criteria->compare('regionIndex',$this->regionIndex,true);
		$criteria->compare('recvAddress',$this->recvAddress,true);
		$criteria->compare('recvPostBox',$this->recvPostBox,true);
		$criteria->compare('recvPhoneNumber',$this->recvPhoneNumber,true);
		$criteria->compare('recvTelNumber',$this->recvTelNumber,true);
		$criteria->compare('recvEmailAddress',$this->recvEmailAddress,true);
		$criteria->compare('sendSpeed',$this->sendSpeed);
		$criteria->compare('recvPlace',$this->recvPlace);
		$criteria->compare('payKind',$this->payKind);
		$criteria->compare('recvStatus',$this->recvStatus);
		$criteria->compare('shopIndex',$this->shopIndex);
		$criteria->compare('orderCancelDate',$this->orderCancelDate,true);
		$criteria->compare('orderCancelUserIndex',$this->orderCancelUserIndex,true);
		$criteria->compare('confirmDate',$this->confirmDate,true);
		$criteria->compare('payInitialDate',$this->payInitialDate,true);
		$criteria->compare('payCompleteDate',$this->payCompleteDate,true);
		$criteria->compare('productOutDate',$this->productOutDate,true);
		$criteria->compare('sendDate',$this->sendDate,true);
		$criteria->compare('recvDate',$this->recvDate,true);
		$criteria->compare('ticketDate',$this->ticketDate,true);
		$criteria->compare('completeDate',$this->completeDate,true);
		$criteria->compare('orderStatus',$this->orderStatus);
		$criteria->compare('orderContent',$this->orderContent,true);
		$criteria->compare('readUserIndex',$this->readUserIndex,true);
		$criteria->compare('invoiceType',$this->invoiceType);
		$criteria->compare('invoiceTarget',$this->invoiceTarget);
		$criteria->compare('invoiceContent',$this->invoiceContent);
		$criteria->compare('reciptUnitName',$this->reciptUnitName,true);
		$criteria->compare('reciptName',$this->reciptName,true);
		$criteria->compare('reciptAddress',$this->reciptAddress,true);
		$criteria->compare('reciptTelNumber',$this->reciptTelNumber,true);
		$criteria->compare('reciptBank',$this->reciptBank,true);
		$criteria->compare('reciptAccount',$this->reciptAccount,true);
		$criteria->compare('totalOrderMoney',$this->totalOrderMoney,true);
		$criteria->compare('orderMoney',$this->orderMoney,true);
		$criteria->compare('sendMoney',$this->sendMoney,true);
		$criteria->compare('recvMoney',$this->recvMoney,true);
		$criteria->compare('netMoney',$this->netMoney,true);
		$criteria->compare('useCardMoney',$this->useCardMoney,true);
		$criteria->compare('returnStatus',$this->returnStatus);
		$criteria->compare('readStatus',$this->readStatus,true);
		$criteria->compare('confirmStatus',$this->confirmStatus,true);
		$criteria->compare('pseudoCheck',$this->pseudoCheck);
		$criteria->compare('changeDate',$this->changeDate,true);
		$criteria->compare('changeUserIndex',$this->changeUserIndex,true);
		$criteria->compare('changeUserIP',$this->changeUserIP,true);
		$criteria->compare('changeContent',$this->changeContent,true);          
		$criteria->compare('confirmUserIndex',$this->confirmUserIndex,true);
		$criteria->compare('confirmUserIP',$this->confirmUserIP,true);
		$criteria->compare('paymentUserIndex',$this->paymentUserIndex,true);
		$criteria->compare('paymentUserIP',$this->paymentUserIP,true);
		$criteria->compare('paymentContent',$this->paymentContent,true);
		$criteria->compare('sendUserIndex',$this->sendUserIndex,true);
		$criteria->compare('sendUserIP',$this->sendUserIP,true);
		$criteria->compare('recvUserIndex',$this->recvUserIndex,true);
		$criteria->compare('recvUserIP',$this->recvUserIP,true);
		$criteria->compare('ticketNumber',$this->ticketNumber,true);
		$criteria->compare('ticketMoney',$this->ticketMoney,true);
		$criteria->compare('ticketUserIndex',$this->ticketUserIndex,true);
		$criteria->compare('ticketUserIP',$this->ticketUserIP,true);
		$criteria->compare('ticketContent',$this->ticketContent,true);
		$criteria->compare('sendTicketNumber',$this->sendTicketNumber,true);
		$criteria->compare('sendReqDate',$this->sendReqDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productorder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
       
	public static function GetProductOrderDays($startDate, $endDate, $orderStatus=-1, $orderTicketNumber="")
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
    	$MYSESS['masterCategoryStr'] = $_MYSESS['masterCategoryStr'];
    	$MYSESS['friendCheck'] = $_MYSESS['friendCheck'];
    	$MYSESS['unionIndex'] = $_MYSESS['unionIndex'];
    	
    	$MYSQL['_productOrder'] = 'tbl_productorder';
    	$MYSQL['_userInfo'] = 'tbl_userinfo'; 
    	$MYSQL['_productOrderDetail'] = 'tbl_productorderdetail'; 
    	$MYSQL['_product'] = 'tbl_product';
    	
    	$strsql = sprintf("update %s set confirmDate=NOW() where orderMoney = recvMoney and confirmDate='0000-00-00'", $MYSQL['_productOrder']);
        Yii::$app->db->createCommand($strsql)->execute();
        
        $strAdd = " ";
        if($MYSESS['friendCheck']) 
            $strAdd .= " and masterIndex='".$MYSESS['unionIndex']."'";
        
        $sql_query = sprintf("select distinct a.*, b.userID, b.userName from %s a inner join %s b on a.guestIndex=b.guestIndex inner join %s c on a.orderIndex = c.orderIndex left join %s d on c.productIndex=d.productIndex where TO_DAYS(orderDate)>=TO_DAYS('$startDate') and TO_DAYS(orderDate)<=TO_DAYS('$endDate') $strAdd", $MYSQL['_productOrder'], $MYSQL['_userInfo'], $MYSQL['_productOrderDetail'], $MYSQL['_product']);
        $strCondition = "";
 
        if($orderStatus >= 0){
            switch($orderStatus)
            {
                case "0":
                    $strCondition = " and orderCancelDate='0000-00-00' and confirmDate = '0000-00-00'";
                    break;
                case "1":
                    $strCondition = " and orderCancelDate='0000-00-00' and payInitialDate = '0000-00-00' and confirmDate <> '0000-00-00'";
                    break;
                case "2":
                    $strCondition = " and orderCancelDate='0000-00-00' and payCompleteDate = '0000-00-00' and confirmDate <> '0000-00-00'";
                    break;
                case "3":
                    $strCondition = " and orderCancelDate='0000-00-00' and sendDate = '0000-00-00' and (((payKind < 4 or payKind = 5) and payCompleteDate <> '0000-00-00') or payKind = 4)";
                    break;
                case "4":
                    $strCondition = " and orderCancelDate='0000-00-00' and recvDate = '0000-00-00' and sendDate <> '0000-00-00'";
                    break;
                case "5":
                    $strCondition = " and orderCancelDate='0000-00-00' and ticketDate = '0000-00-00' and invoiceType>0 and payCompleteDate <> '0000-00-00'";
                    break;
                case "6":
                    $strCondition = " and orderCancelDate='0000-00-00' and sendDate <> '0000-00-00'";
                    break;
                case "7":
                    $strCondition = " and orderCancelDate='0000-00-00' and recvDate <> '0000-00-00'";
                    break;
                case "8":
                    $strCondition = " and orderCancelDate='0000-00-00' and payCompleteDate <> '0000-00-00'";
                    break;
                case "9":
                    $strCondition = " and orderCancelDate='0000-00-00' and completeDate <> '0000-00-00'";
                    break;
                case "10":
                    $strCondition = " and orderCancelDate <> '0000-00-00'";
                    break;
            }
            $sql_query .= $strCondition;
        }
         
        if($orderTicketNumber != "") 
            $sql_query .= " and orderTicketNumber LIKE '%".$orderTicketNumber."%'";
        $sql_query .= " order by a.orderDate desc";
         
        return Yii::$app->db->createCommand($sql_query)->queryAll();
    }
    
 	public function ConfirmOrder($orderIndex)
    {
//    	$_MYSESS = Yii::$app->session->get('MYSESS');
    	$MYSESS['userIndex'] = 1; //@@@ $_MYSESS['userIndex'];
    	
    	$sql_query = sprintf("update %s set confirmDate=NOW(), confirmStatus = concat(confirmStatus, '@%s@') where not(instr(confirmStatus, '@%s@')) and orderIndex='$orderIndex'", 'tbl_productorder', $MYSESS['userIndex'], $MYSESS['userIndex']);
    	Yii::$app->db->createCommand($sql_query)->execute();
    	
    	$this->RegisterHistoryData($orderIndex, "订单确认", "");
    	return true;
    }
    
    public function GenTicketNumber()
    {
        return date("Ymdws").substr((1000000 + $this->GetMaxIndexFromTable('tbl_productorder', "orderIndex", true)),-5);
    }
	
	public function Register_user($guestIndex, $orderTicketNumber, $recvName, $regionIndex, $recvAddress, $recvPostBox, $recvPhoneNumber, $recvTelNumber, $recvEmailAddress, $sendSpeed, $recvPlace, $payKind, $recvStatus, $shopIndex, $orderContent, $invoiceType, $invoiceTarget, $invoiceContent, $reciptUnitName, $reciptName, $reciptAddress, $reciptTelNumber, $reciptBank, $reciptAccount, $orderMoney, $sendMoney, $pseudoCheck=0, $netUseMoney=0, $totalOrderMoney=0)
    {
        if($orderMoney > 0)
        	$sql_query = sprintf("INSERT INTO %s (guestIndex, orderDate, orderTicketNumber, recvName, regionIndex, recvAddress, recvPostBox, recvPhoneNumber, recvTelNumber, recvEmailAddress, sendSpeed, recvPlace, payKind, recvStatus, shopIndex, orderStatus, orderContent, readUserIndex, invoiceType, invoiceTarget, invoiceContent, reciptUnitName, reciptName, reciptAddress, reciptTelNumber, reciptBank, reciptAccount, orderMoney, sendMoney, returnStatus, readStatus, confirmStatus, pseudoCheck, netMoney, totalOrderMoney) VALUES ('$guestIndex', NOW(), '$orderTicketNumber', '$recvName', '$regionIndex', '$recvAddress', '$recvPostBox', '$recvPhoneNumber', '$recvTelNumber', '$recvEmailAddress', '$sendSpeed', '$recvPlace', '$payKind', '$recvStatus', '$shopIndex', '0', '$orderContent', '', '$invoiceType', '$invoiceTarget', '$invoiceContent', '$reciptUnitName', '$reciptName', '$reciptAddress', '$reciptTelNumber', '$reciptBank', '$reciptAccount', '$orderMoney', '$sendMoney', '0', '0', '0', '$pseudoCheck', '$netUseMoney', '$totalOrderMoney')", 'tbl_productorder');
        else
            $sql_query = sprintf("INSERT INTO %s (guestIndex, orderDate, orderTicketNumber, recvName, regionIndex, recvAddress, recvPostBox, recvPhoneNumber, recvTelNumber, recvEmailAddress, sendSpeed, recvPlace, payKind, recvStatus, shopIndex, orderStatus, orderContent, readUserIndex, invoiceType, invoiceTarget, invoiceContent, reciptUnitName, reciptName, reciptAddress, reciptTelNumber, reciptBank, reciptAccount, orderMoney, sendMoney, returnStatus, readStatus, confirmStatus, pseudoCheck, netMoney, payInitialDate, payCompleteDate, totalOrderMoney) VALUES ('$guestIndex', NOW(), '$orderTicketNumber', '$recvName', '$regionIndex', '$recvAddress', '$recvPostBox', '$recvPhoneNumber', '$recvTelNumber', '$recvEmailAddress', '$sendSpeed', '$recvPlace', '$payKind', '$recvStatus', '$shopIndex', '0', '$orderContent', '', '$invoiceType', '$invoiceTarget', '$invoiceContent', '$reciptUnitName', '$reciptName', '$reciptAddress', '$reciptTelNumber', '$reciptBank', '$reciptAccount', '$orderMoney', '$sendMoney', '0', '0', '0', '$pseudoCheck', '$netUseMoney', NOW(), NOW(), '$totalOrderMoney')", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        return $this->GetMaxIndexFromTable('tbl_productorder', "orderIndex");
    }
    
	public function UpdateOrderIndex($orderIndex, $srcOrderIndex)
	{
		$strsql = sprintf("UPDATE %s set orderIndex='$orderIndex' where orderIndex='$srcOrderIndex'", 'tbl_productorder');
		return Yii::$app->db->createCommand($strsql)->execute();
	}
	
	public function UpdateReadStatus($orderIndex, $readStatus, $changeContent, $orderDate)
    {
    	$sql_query = sprintf("update %s set readStatus = '$readStatus', orderDate='$orderDate' where orderIndex = '$orderIndex'", 'tbl_productorder');
		Yii::$app->db->createCommand($sql_query)->execute();
    	$this->RegisterHistoryData($orderIndex, "订单修改", $changeContent);
        return true;
    }
    
    public function RegisterHistoryData($orderIndex, $historyTitle, $historyContent)
    {
//		$_MYSESS = Yii::$app->session->get('MYSESS');
    	$MYSESS['userIndex'] = 1; //@@@ $_MYSESS['userIndex'];
    	
    	$sql_query = sprintf("INSERT INTO tbl_productorderhistory (orderIndex, historyDate, historyTitle, historyContent, historyIP, userIndex) values('$orderIndex', NOW(), '$historyTitle', '$historyContent', '%s', '%s')", $_SERVER["REMOTE_ADDR"], $MYSESS['userIndex']);
		Yii::$app->db->createCommand($sql_query)->execute();
    }
    
    public function Delete_user($orderIndex)
    {
        $this->CancelNetMoney($orderIndex);
        $sql_query = sprintf("delete from %s where orderIndex='$orderIndex' and payInitialDate='0000-00-00' and sendDate='0000-00-00'", 'tbl_productorder');
		Yii::$app->db->createCommand($sql_query)->execute();
        $this->CancelGiftUse($orderIndex);
        return true;
    }
    
    public function CancelNetMoney($orderIndex)
    {
    	$strsql = sprintf("select guestIndex, netMoney from %s where orderIndex='$orderIndex'",'tbl_productorder');
    	$result = Yii::$app->db->createCommand($strsql)->queryAll();
    	
    	$netMoney = 0;
    	if(count($result))
    		$netMoney = $result[0]['netMoney'];
    	if($netMoney > 0){
    		$strsql2 = sprintf("INSERT INTO tbl_netaccountinput (guestIndex, inputMoney, inputDate, inputType, inputNote) values ('%s', '$netMoney', NOW(), '0', '')", $result[0]['guestIndex']);
			Yii::$app->db->createCommand($strsql2)->execute();
			$strsql2 = sprintf("UPDATE tbl_netaccount set netMoney = netMoney + $netMoney where guestIndex='%s'", $result[0]['guestIndex']);
			Yii::$app->db->createCommand($strsql2)->execute();
    	}
    }
    
    public function CancelGiftUse($orderIndex)
    {
    	$sql_query = sprintf("select * from %s where orderIndex='$orderIndex'", 'tbl_productorderdetailstatus');
    	$result = Yii::$app->db->createCommand($sql_query)->queryAll();
    	foreach ($result as $row)
    	{
	        $sql_query = sprintf("UPDATE %s set remainMoney = remainMoney + %d WHERE cardID='%s'", "tbl_usergiftcard", $row['coinAmount'], $row['coinIndex']);
			Yii::$app->db->createCommand($sql_query)->execute();
    	}
        $sql_query = sprintf("DELETE FROM %s where orderIndex='$orderIndex'", 'tbl_productorderdetailstatus');
		Yii::$app->db->createCommand($sql_query)->execute();
        $sql_query = sprintf("UPDATE %s set useCardMoney = '0' where orderIndex='$orderIndex'",'tbl_productorder');
		Yii::$app->db->createCommand($sql_query)->execute();
    }
    
    
    public function GetHistoryDataForOrder($orderIndex)
    {
        $strsql = sprintf("select a.*, b.userName from tbl_productorderhistory a left join %s b on a.userIndex = b.userIndex where orderIndex='$orderIndex' order by historyDate", "tbl_userdb2");
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }
    
    public function GetOrderRecord($orderIndex)
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];
        $sql_query = sprintf("update %s set readUserIndex = concat(readUserIndex, '@%s@') where orderIndex = '$orderIndex' and not(instr(readUserIndex, '@%s@'))", 'tbl_productorder', $MYSESS['userIndex'], $MYSESS['userIndex']);
        Yii::$app->db->createCommand($sql_query)->execute();
        $sql_query = sprintf("select a.*, b.userID, b.userName from %s a inner join %s b on a.guestIndex=b.guestIndex where orderIndex = '$orderIndex'", 'tbl_productorder', 'tbl_userinfo');
        $result = Yii::$app->db->createCommand($sql_query)->queryAll();
        if(count($result))
            return $result[0];
        return false;
        
    }
    
    public function UpdateConfirmInfo($orderIndex, $caseNum = 1)
    {
        $_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];
        $MYSQL['_productOrder'] = 'tbl_productorder';
        if($caseNum == 1) 
            $strsql = sprintf("Update %s set readStatus = concat(readStatus, '@%s@') where not(instr(readStatus, '@%s@')) and confirmDate='0000-00-00' and orderIndex='$orderIndex'", $MYSQL['_productOrder'], $MYSESS['userIndex'], $MYSESS['userIndex']);
        else
            $strsql = sprintf("Update %s set confirmStatus = concat(confirmStatus, '@%s@') where not(instr(confirmStatus, '@%s@')) and confirmDate<>'0000-00-00' and orderIndex='$orderIndex'", $MYSQL['_productOrder'], $MYSESS['userIndex'], $MYSESS['userIndex']);
        Yii::$app->db->createCommand($strsql)->execute();
    }
    
    public function GetPrimaryName($orderIndex)
    {
        $strsql = sprintf("select unionName from %s a inner join %s b on a.orderIndex = b.orderIndex inner join %s c on a.productIndex = c.productIndex inner join %s d on c.masterIndex = d.userIndex inner join %s e on d.unionIndex = e.unionIndex where a.orderIndex = '$orderIndex' order by orderPrice*orderAmount desc", 'tbl_productorderdetail', 'tbl_productorder', 'tbl_product', 'tbl_userdb2', 'tbl_userunion');
        $ret = Yii::$app->db->createCommand($strsql)->queryScalar();
        if($ret = "") $ret = "丹东商城"; 
        return $ret;
    }
    
    public function Delete2($orderIndex, $historyContent="")
    {    
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];
        $this->CancelNetMoney($orderIndex);
        $sql_query = sprintf("Update %s set orderCancelDate=NOW(), orderCancelUserIndex='%s' where orderIndex='$orderIndex'", 'tbl_productorder', $MYSESS['userIndex']);
        Yii::$app->db->createCommand($sql_query)->execute();
        $sql_query = sprintf("select a.*, guestIndex from %s a inner join %s b on a.orderIndex=b.orderIndex where a.orderIndex = '$orderIndex'", 'tbl_productorderdetail', 'tbl_productorder');
        $result = Yii::$app->db->createCommand($sql_query)->queryAll();
        foreach ($result as $row) {
           $sql_query = sprintf("update %s set requestAmount = requestAmount - '%s' where productIndex = '%s'", 'tbl_product', $row['orderAmount'], $row['productIndex']);
           Yii::$app->db->createCommand($sql_query)->execute();
           $sql_query = sprintf("update %s set pointAmount = pointAmount + '%s' where guestIndex = '%s'", 'tbl_userinfo', $row['orderAmount']*$row['orderPoint'], $row['guestIndex']);
           Yii::$app->db->createCommand($sql_query)->execute();
        }
        $this->RegisterHistoryData($orderIndex, "订单取消", $historyContent);
        $this->CancelGiftUse($orderIndex);
        return true;
    }
    
    public function GetOrderTotalInfo($guestIndex)
    {
        $strsql ="select SUM(IF(completeDate<>'0000-00-00',1,0)) orderCn, SUM(IF(payCompleteDate='0000-00-00',1,0)) orderNoPayCn, SUM(IF((sendDate<>'0000-00-00' and recvDate='0000-00-00'),1,0)) orderWaitRecvCn, SUM(IF(completeDate<>'0000-00-00',orderMoney,0)) orderMoneySum, SUM(IF(completeDate<>'0000-00-00' and year(completeDate)=year(CURRENT_DATE),orderMoney,0)) orderMoneyYearSum from tbl_productorder where guestIndex='$guestIndex' and orderCancelDate='0000-00-00'";
        return Yii::$app->db->createCommand($strsql)->queryOne();
    }
    
    function GenGiftCard($guestIndex, $orderPrice, $orderDetailIndex)
    {
        $cardID = $this->GenCardID();
        $cardPWD = $this->GenCardPWD();
        $strsql = "INSERT INTO tbl_usergiftcard (guestIndex, cardMoney, remainMoney, cardID, cardPWD, startDate, endDate, orderDetailIndex) values('$guestIndex', '$orderPrice', '$orderPrice', '$cardID', '$cardPWD', CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 6 MONTH), '$orderDetailIndex')";
        Yii::$app->db->createCommand($strsql)->execute();
        return $this->GetMaxIndexFromTable("tbl_usergiftcard", "giftRecordIndex");
    }
    
    function GenCardID()
    {
        $preTicket = rand(1,9);
        $preTicket1 = rand(1,29);
        $preTicket2 = rand(1,37);
        $cardID = $preTicket.date("B");
        $cardID .= substr(date("d"),-1);
        $cardID .= substr((100+date("H")*$preTicket1),-2);
        $cardID .= substr(date("m"),-1);
        $cardID .= substr((100+date("i")*$preTicket2),-2);
        $cardID .= substr((1000+$this->GetMaxIndexFromTable("tbl_usergiftcard", "giftRecordIndex", true)),-3);
        
        $strsql = "select count(*) cn from tbl_usergiftcard where cardID='$cardID'";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row)
            if($row["cn"] > 0) 
                return $this->GenCardPWD();
            else 
                return '$cardPWD';
        return false;
    }
    
    function GetOrderTicketHistory($startDate, $endDate)
    {    
        $strsql = "select a.*, b.userName from tbl_productorder a inner join tbl_userdb2 b on a.ticketUserIndex = b.userIndex where TO_DAYS(ticketDate)>=TO_DAYS('$startDate') and TO_DAYS(ticketDate)<=TO_DAYS('$endDate') order by ticketDate desc";
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }
    
    function GenCardPWD()
    {
        $preTicket = rand(1,9);
        $preTicket1 = rand(1,59);
        $preTicket2 = rand(1,97);
        $cardPWD = $preTicket;
        $cardPWD .= substr((1000+date("B")*$preTicket),-3);
        $cardPWD .= substr((100+date("d")*$preTicket1),-1);
        $cardPWD .= substr((100+date("H")*$preTicket1),-2);
        $cardPWD .= substr((100+date("m")*$preTicket),-1);
        $cardPWD .= substr((100+date("i")*$preTicket2),-2);
        $cardPWD .= substr(((date("s")*103+date("i")*11+date("H")*1)+$this->GetMaxIndexFromTable("tbl_usergiftcard", "giftRecordIndex", true)),-3);
        
        $strsql = "select count(*) cn from tbl_usergiftcard where cardPWD='$cardPWD'";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row)
            if($row["cn"] > 0) 
                return $this->GenCardPWD();
            else 
                return $cardPWD;
        return false;
    }
    
    public function GetMaxIndexFromTable($tblName, $fldName, $chkNext = false){
        $maxIndex = 0;
        $sql_query = sprintf("select max($fldName) nowIndex from $tblName");
        $row = Yii::$app->db->createCommand($sql_query)->queryScalar();
        if(isset($row)) $maxIndex = $row;
        if($chkNext) $maxIndex++;
        return $maxIndex;
    }
    
    public function ConfirmOut($orderIndex)
    {
        $sql_query = sprintf("update %s set productOutDate=NOW() where orderIndex='$orderIndex'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "商品出庫", "");
        $this->updateProductAmount($orderIndex);
        return true;
    }
    
    public function updateProductAmount($orderIndex)
    {
        $procOrderDetail = new ProductOrderDetail();
        $orderDetailArr = $procOrderDetail->GetOrderDetailArray($orderIndex);
        for($i=0; $i<count($orderDetailArr); $i++)
        {
            $sql_query = sprintf("update %s set requestAmount = requestAmount - '%s', remainAmount = remainAmount - '%s', sellAmount = sellAmount + '%s' where productIndex = '%s'", 'tbl_product', $orderDetailArr[$i]['orderAmount'], $orderDetailArr[$i]['orderAmount'], $orderDetailArr[$i]['orderAmount'], $orderDetailArr[$i]['productIndex']);
            Yii::$app->db->createCommand($sql_query)->execute();
            $sql_query = sprintf("insert into %s (productIndex, outputDate, outputAmount, orderDetailIndex) values ('%s', CURRENT_DATE, '%s', '%s')", 'tbl_productoutput', $orderDetailArr[$i]['productIndex'], $orderDetailArr[$i]['orderAmount'], $orderDetailArr[$i]['orderDetailIndex']);
            Yii::$app->db->createCommand($sql_query)->execute();
        }
        return true;
    }
    
    public function ConfirmInput($orderIndex)
    {
        $sql_query = sprintf("update %s set productOutDate='0000-00-00' where orderIndex='$orderIndex'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "商品出庫取消", "");
        $this->updateProductAmount2($orderIndex);
        return true;
    }
    
    public function updateProductAmount2($orderIndex)
    {
		//@@@ $_MYSESS = Yii::$app->session->get('MYSESS');
        $procOrderDetail = new ProductOrderDetail();
        $orderDetailArr = $procOrderDetail->GetOrderDetailArray($orderIndex);
        for($i=0; $i<count($orderDetailArr); $i++)
        {
            $sql_query = sprintf("update %s set requestAmount = requestAmount + '%s', remainAmount = remainAmount + '%s', sellAmount = sellAmount - '%s' where productIndex = '%s'", 'tbl_product', $orderDetailArr[$i]['orderAmount'], $orderDetailArr[$i]['orderAmount'], $orderDetailArr[$i]['orderAmount'], $orderDetailArr[$i]['productIndex']);
            Yii::$app->db->createCommand($sql_query)->execute();
            $sql_query = sprintf("insert into %s (productIndex, inputDate, inputAmount, inputCase) values ('%s', CURRENT_DATE, '%s', '2')", 'tbl_productinput', $orderDetailArr[$i]['productIndex'], $orderDetailArr[$i]['orderAmount']);
            Yii::$app->db->createCommand($sql_query)->execute();
        }
        return true;
    }
    
    public function GenOrderTicket($orderIndex, $ticketMoney, $ticketContent, $ticketNumber)
    {
        $MYSESS['userIndex'] = 1; //@@@ $_MYSESS['userIndex'];
        $sql_query = sprintf("update %s set ticketDate=NOW(), ticketNumber='$ticketNumber', ticketMoney='$ticketMoney', ticketUserIndex='%s', ticketContent='$ticketContent' where orderIndex='$orderIndex' and ticketDate='0000-00-00'", 'tbl_productorder', $MYSESS['userIndex']);
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "开发票", $ticketContent);
        return true;
    }
    
    public function CancelOrderTicket($orderIndex)
    {
        $sql_query = sprintf("update %s set ticketDate='0000-00-00', ticketNumber='', ticketMoney='0', ticketContent='' where orderIndex='$orderIndex' and ticketDate<>'0000-00-00' and completeDate='0000-00-00'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "作废发票", "");
        return true;
    }
    
    public function CheckCompleteOrder($orderIndex)
    {
        
        $sql_query = sprintf("update %s set completeDate=NOW() where orderIndex='$orderIndex' and payCompleteDate<>'0000-00-00' and recvDate<>'0000-00-00'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        $sql_query = sprintf("select completeDate from %s where orderIndex='$orderIndex'", 'tbl_productorder');
        $result = Yii::$app->db->createCommand($sql_query)->queryAll();
        if(count($result)){
            $completeDate = $result[0]['completeDate'];
            if(substr($completeDate,0,10) != "0000-00-00") $this->RegisterHistoryData($orderIndex, "订单完成", "");
        }
        return true;
    }
    
    public function RegisterSend($orderIndex, $sendTicketNumber)
    {
        $sql_query = sprintf("update %s set sendDate=NOW(), sendTicketNumber='$sendTicketNumber' where orderIndex='$orderIndex' and sendDate='0000-00-00'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "配送", "");
        return true;
    }
    
    public function CancelSend($orderIndex)
    {
        $sql_query = sprintf("update %s set sendDate='0000-00-00' where orderIndex='$orderIndex' and sendDate<>'0000-00-00' and completeDate='0000-00-00'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "取消配送", "");
        return true;
    }
    
    public function CompleteSend($orderIndex)
    {
        
        $orderObj = $this->GetOrderRecord($orderIndex);
        $guestIndex = $orderObj['guestIndex'];
        $pseudoCheck = $orderObj['pseudoCheck'];
        
        $sql_query = sprintf("update %s set recvDate=NOW() where orderIndex='$orderIndex' and sendDate<>'0000-00-00' and recvDate='0000-00-00'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "完成配送", "");
        $this->CheckCompleteOrder($orderIndex);
        
        $procGuest = new UserInfo();
        $procGuest->CheckUserDegree($guestIndex);
        $this->updatePointAmount($orderIndex);
        
        return true;
    }
    
    public function updatePointAmount($orderIndex)
    {
        
        $orderObj = $this->GetOrderRecord($orderIndex);
        $guestIndex = $orderObj['guestIndex'];
        $strsql = sprintf("select SUM(orderAmount * pointNum) pointAmount from %s a inner join %s b on a.productIndex = b.productIndex where orderIndex='$orderIndex'", 'tbl_productorderdetail', 'tbl_product');
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        $pointAmount = 0;
        if(count($result)) $pointAmount = $result[0]['pointAmount'];
        $this->IncreasePointAmount($guestIndex, $pointAmount);
        return true;
    }
    
    public function IncreasePointAmount($guestIndex, $pointAmount)
    {
        $strsql = sprintf("update %s set pointAmount = pointAmount + '$pointAmount' where guestIndex='$guestIndex'", 'tbl_userinfo');
        Yii::$app->db->createCommand($strsql)->execute();
        return true;
    }
    
	public function GetOrderAlert($caseNum = 1)
    {
		$strAdd = "";
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS['masterCategoryStr'] = $_MYSESS['masterCategoryStr'];
        $MYSESS['friendCheck'] = $_MYSESS['friendCheck'];
        $MYSESS['unionIndex'] = $_MYSESS['unionIndex'];

		if($_MYSESS['friendCheck']) 
			$strAdd = " and c.masterIndex='".$_MYSESS['unionIndex']."'";
		$strAdd .= " and c.classIdx in (".$_MYSESS['masterCategoryStr'].")";
			
    	switch($caseNum) 
    	{
    		case 1:
	    		$strsql = sprintf("select a.* from %s a inner join %s b on a.orderIndex=b.orderIndex left join %s c on b.productIndex = c.productIndex where not(instr(readStatus, '@%s@')) and confirmDate='0000-00-00' $strAdd", 'tbl_productorder', 'tbl_productorderdetail', 'tbl_product', $_MYSESS['userIndex']);
    			break;
    		case 2:
	    		$strsql = sprintf("select a.* from %s a inner join %s b on a.orderIndex=b.orderIndex left join %s c on b.productIndex = c.productIndex where not(instr(confirmStatus, '@%s@')) and confirmDate<>'0000-00-00' $strAdd", 'tbl_productorder', 'tbl_productorderdetail', 'tbl_product', $_MYSESS['userIndex']);
    			break;
    		case 3:
	    		$strsql = sprintf("select a.articleIndex from %s a inner join %s c on a.buyProductIndex = c.productIndex where (not(instr(readStatus, '@%s@')) or readStatus is null) and articleStatus=0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW() $strAdd", 'tbl_guestopinion', 'tbl_product', $_MYSESS['userIndex']);
    			break;
    		case 4:
	    		$strsql = sprintf("select a.articleIndex from %s a inner join %s c on a.productIndex = c.productIndex where (not(instr(readStatus, '@%s@')) or readStatus is null) and articleStatus=0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW() $strAdd", 'tbl_guestconsult', 'tbl_product', $_MYSESS['userIndex']);
    			break;
    		case 5:
	    		$strsql = sprintf("select a.repairIndex from %s a inner join %s b on a.repairIndex=b.repairIndex inner join %s c on b.productIndex = c.productIndex where (not(instr(readStatus, '@%s@')) or readStatus is null) and processStatus=0 and DATE_ADD(requestDate,INTERVAL 15 MINUTE)>NOW() $strAdd", 'tbl_guestrepair', 'tbl_guestrepairdetail', 'tbl_product', $_MYSESS['userIndex']);
    			break;
    		case 6:
	    		$strsql = sprintf("select articleIndex from %s where (not(instr(readStatus, '@%s@')) or readStatus is null) and guestIndex>0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestrequest', $_MYSESS['userIndex']);
    			break;
    		case 7:
	    		$strsql = sprintf("select returnIndex from %s where (not(instr(readStatus, '@%s@')) or readStatus is null) and processStatus=0 and DATE_ADD(requestDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestreturn', $_MYSESS['userIndex']);
    			break;
    	}
    	$result = Yii::$app->db->createCommand($strsql)->queryAll();
    	switch($caseNum)
    	{
    		case 3:
	    		$strsql2 = sprintf("update %s set readStatus = '@%s@' where readStatus is null and articleStatus=0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestopinion', $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
	    		$strsql2 = sprintf("update %s set readStatus = concat(readStatus, '@%s@') where not(instr(readStatus, '@%s@')) and articleStatus=0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestopinion', $_MYSESS['userIndex'], $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
    			break;
    		case 4:
	    		$strsql2 = sprintf("update %s set readStatus = '@%s@' where readStatus is null and articleStatus=0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestconsult', $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
	    		$strsql2 = sprintf("update %s set readStatus = concat(readStatus, '@%s@') where not(instr(readStatus, '@%s@')) and articleStatus=0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestconsult', $_MYSESS['userIndex'], $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
    			break;
    		case 5:
	    		$strsql2 = sprintf("update %s set readStatus = '@%s@' where readStatus is null and processStatus=0 and DATE_ADD(requestDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestrepair', $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
	    		$strsql2 = sprintf("update %s set readStatus = concat(readStatus, '@%s@') where not(instr(readStatus, '@%s@')) and processStatus=0 and DATE_ADD(requestDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestrepair', $_MYSESS['userIndex'], $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
    			break;
    		case 6:
	    		$strsql2 = sprintf("update %s set readStatus = '@%s@' where readStatus is null and guestIndex>0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestrequest', $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
	    		$strsql2 = sprintf("update %s set readStatus = concat(readStatus, '@%s@') where not(instr(readStatus, '@%s@')) and guestIndex>0 and DATE_ADD(articleDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestrequest', $_MYSESS['userIndex'], $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
    			break;
    		case 7:
	    		$strsql2 = sprintf("update %s set readStatus = '@%s@' where readStatus is null and processStatus=0 and DATE_ADD(requestDate,INTERVAL 15 MINUTE)>NOW()",'tbl_guestreturn', $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
	    		$strsql2 = sprintf("update %s set readStatus = concat(readStatus, '@%s@') where not(instr(readStatus, '@%s@')) and processStatus=0 and DATE_ADD(requestDate,INTERVAL 15 MINUTE)>NOW()", 'tbl_guestreturn', $_MYSESS['userIndex'], $_MYSESS['userIndex']);
	    		Yii::$app->db->createCommand($strsql2)->execute();
    			break;
    	}
    	return $result;
    }
    /*public function ConfirmOrder($orderIndex)
    {
        global $MYSQL, $MYSESS;
        
        $sql_query = sprintf("update %s set confirmDate=NOW(), confirmStatus = concat(confirmStatus, '@%s@') where not(instr(confirmStatus, '@%s@')) and orderIndex='$orderIndex'", 'tbl_productorder', $MYSESS['userIndex'], $MYSESS['userIndex']);
        Yii::$app->db->createCommand($sql_query)->execute();
        $this->RegisterHistoryData($orderIndex, "订单确认", "");
        return true;
    }*/
    
	/*$orderStatusStrArr = array('新订单', '等待付款', '己付款', '商品出库', '等待收货', '完成', '订单取消', '等待确认', '己确认');
	$returnKindStrArr  = array('退款至商城账户', '现金退款', '退款至银行卡', '退款至公司账户');
	$returnStatusStrArr2  = array('退款申请', '审核通过', '退款', '撤消');
	$returnStatusStrArr  = array('等待审核', '正在处理', '退款成功', '已撤消');
	$returnStatusDateStrArr = array('requestDate', 'processDate', 'completeDate', 'cancelDate');
	$repairStatusStrArr2  = array('售后服务申请', '审核通过', '', '撤消');
	$repairStatusStrArr  = array('等待审核', '正在处理', '成功', '已撤消');
	$repairStatusDateStrArr = array('requestDate', 'processDate', 'completeDate', 'cancelDate');
	
	public function GetOrderStatusStr($orderStatusIndex){ global $orderStatusStrArr; return $orderStatusStrArr[$orderStatusIndex];}
	public function GetReturnKindStr($returnKindIndex){ global $returnKindStrArr; return $returnKindStrArr[$returnKindIndex];}
	public function GetReturnStatusStr($returnStatusIndex){ global $returnStatusStrArr; return $returnStatusStrArr[$returnStatusIndex];}
	public function GetReturnStatusStr2($returnStatusIndex){ global $returnStatusStrArr2; return $returnStatusStrArr2[$returnStatusIndex];}
	public function GetRepairStatusStr($repairStatusIndex){ global $repairStatusStrArr; return $repairStatusStrArr[$repairStatusIndex];}
	public function GetRepairStatusStr2($repairStatusIndex){ global $repairStatusStrArr2; return $repairStatusStrArr2[$repairStatusIndex];}*/
	
	
//end user function rrrrrrrrrrrrrrrrrrrrrrrrrrr    
    
}?>
