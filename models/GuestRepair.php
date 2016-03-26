<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_guestrepair".
 *
 * The followings are the available columns in table 'tbl_guestrepair':
 * @property string $repairIndex
 * @property string $guestIndex
 * @property string $orderIndex
 * @property integer $repairType
 * @property string $regionIndex
 * @property integer $positionType
 * @property integer $carrType
 * @property integer $sendType
 * @property string $contactName
 * @property string $phoneNumber
 * @property string $telNumber
 * @property string $postCode
 * @property string $getAddress
 * @property string $getTime
 * @property string $sendAddress
 * @property integer $collateralCondition
 * @property integer $shapeType
 * @property integer $packType
 * @property integer $receiptCheck
 * @property integer $reportCheck
 * @property string $repairContent
 * @property string $requestDate
 * @property string $processDate
 * @property string $inputDate
 * @property string $outputDate
 * @property string $sendDate
 * @property string $completeDate
 * @property string $cancelDate
 * @property integer $processStatus
 * @property string $readStatus
 * @property string $repairNote
 */
class GuestRepair extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_guestrepair';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('repairType, positionType, carrType, sendType, collateralCondition, shapeType, packType, receiptCheck, reportCheck, processStatus', 'numerical', 'integerOnly'=>true),
			array('guestIndex, orderIndex, regionIndex', 'length', 'max'=>20),
			array('contactName, phoneNumber, telNumber, getAddress, sendAddress', 'length', 'max'=>200),
			array('postCode', 'length', 'max'=>50),
			array('getTime, repairNote', 'length', 'max'=>255),
			array('repairContent, requestDate, processDate, inputDate, outputDate, sendDate, completeDate, cancelDate, readStatus', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('repairIndex, guestIndex, orderIndex, repairType, regionIndex, positionType, carrType, sendType, contactName, phoneNumber, telNumber, postCode, getAddress, getTime, sendAddress, collateralCondition, shapeType, packType, receiptCheck, reportCheck, repairContent, requestDate, processDate, inputDate, outputDate, sendDate, completeDate, cancelDate, processStatus, readStatus, repairNote', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'repairIndex' => 'Repair Index',
			'guestIndex' => 'Guest Index',
			'orderIndex' => 'Order Index',
			'repairType' => 'Repair Type',
			'regionIndex' => 'Region Index',
			'positionType' => 'Position Type',
			'carrType' => 'Carr Type',
			'sendType' => 'Send Type',
			'contactName' => 'Contact Name',
			'phoneNumber' => 'Phone Number',
			'telNumber' => 'Tel Number',
			'postCode' => 'Post Code',
			'getAddress' => 'Get Address',
			'getTime' => 'Get Time',
			'sendAddress' => 'Send Address',
			'collateralCondition' => 'Collateral Condition',
			'shapeType' => 'Shape Type',
			'packType' => 'Pack Type',
			'receiptCheck' => 'Receipt Check',
			'reportCheck' => 'Report Check',
			'repairContent' => 'Repair Content',
			'requestDate' => 'Request Date',
			'processDate' => 'Process Date',
			'inputDate' => 'Input Date',
			'outputDate' => 'Output Date',
			'sendDate' => 'Send Date',
			'completeDate' => 'Complete Date',
			'cancelDate' => 'Cancel Date',
			'processStatus' => 'Process Status',
			'readStatus' => 'Read Status',
			'repairNote' => 'Repair Note',
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

		$criteria->compare('repairIndex',$this->repairIndex,true);
		$criteria->compare('guestIndex',$this->guestIndex,true);
		$criteria->compare('orderIndex',$this->orderIndex,true);
		$criteria->compare('repairType',$this->repairType);
		$criteria->compare('regionIndex',$this->regionIndex,true);
		$criteria->compare('positionType',$this->positionType);
		$criteria->compare('carrType',$this->carrType);
		$criteria->compare('sendType',$this->sendType);
		$criteria->compare('contactName',$this->contactName,true);
		$criteria->compare('phoneNumber',$this->phoneNumber,true);
		$criteria->compare('telNumber',$this->telNumber,true);
		$criteria->compare('postCode',$this->postCode,true);
		$criteria->compare('getAddress',$this->getAddress,true);
		$criteria->compare('getTime',$this->getTime,true);
		$criteria->compare('sendAddress',$this->sendAddress,true);
		$criteria->compare('collateralCondition',$this->collateralCondition);
		$criteria->compare('shapeType',$this->shapeType);
		$criteria->compare('packType',$this->packType);
		$criteria->compare('receiptCheck',$this->receiptCheck);
		$criteria->compare('reportCheck',$this->reportCheck);
		$criteria->compare('repairContent',$this->repairContent,true);
		$criteria->compare('requestDate',$this->requestDate,true);
		$criteria->compare('processDate',$this->processDate,true);
		$criteria->compare('inputDate',$this->inputDate,true);
		$criteria->compare('outputDate',$this->outputDate,true);
		$criteria->compare('sendDate',$this->sendDate,true);
		$criteria->compare('completeDate',$this->completeDate,true);
		$criteria->compare('cancelDate',$this->cancelDate,true);
		$criteria->compare('processStatus',$this->processStatus);
		$criteria->compare('readStatus',$this->readStatus,true);
		$criteria->compare('repairNote',$this->repairNote,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Guestrepair the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    function GetRepairArr($orderYear, $orderMonth=0, $repairType=-1, $processStatus=-1, $orderTicketNumber="")
    {
        $strCondition = "";
        if($orderMonth > 0) 
            $strCondition .= " and month(requestDate)='".$orderMonth."'";
        if($repairType != -1) 
            $strCondition .= " and repairType='".$repairType."'";
        if($processStatus != -1) 
            $strCondition .= " and processStatus='".$processStatus."'";
        if($orderTicketNumber != "") 
            $strCondition .= " and orderTicketNumber LIKE '%".$orderTicketNumber."%'";
        $strsql = sprintf("select a.*, b.orderTicketNumber, c.userName, c.userID from %s a inner join %s b on a.orderIndex = b.orderIndex inner join %s c on a.guestIndex = c.guestIndex where year(requestDate)='$orderYear' %s order by requestDate desc", "tbl_guestrepair", 'tbl_productorder', "tbl_userinfo", $strCondition);
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }

    function GetProductArraFromMain($repairIndex)
    {
        $strsql = sprintf("select d.productIndex, d.productName, d.productType, IF(d.productColor<>'无',concat(d.productName, ' ', d.productColor), d.productName) productName2 from %s a inner join %s d on a.productIndex = d.productIndex where repairIndex='$repairIndex'", "tbl_guestrepairdetail", "tbl_product");
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }

    function GetHistoryDataForOrder($repairIndex)
    {
        $strsql = sprintf("select a.*, b.userName from tbl_guestrepairhistory a inner join %s b on a.userIndex = b.userIndex where repairIndex='$repairIndex' order by historyDate", 'tbl_userdb2');
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }   
    
    public function UpdateProcess($repairIndex, $processStatus, $historyContent="")
    {
            
        $fldName=Yii::$app->params['repairStatusDateStrArr'][$processStatus];
        $sql_query = sprintf("UPDATE %s set processStatus='$processStatus', $fldName = NOW() where repairIndex='$repairIndex'", 'tbl_guestrepair');
        Yii::$app->db->createCommand($sql_query)->execute();
        
        if($processStatus == 1) $this->RegisterHistoryData($repairIndex, "审核通过", $historyContent);
        if($processStatus == 3){
            $this->RegisterHistoryData($repairIndex, "撤消", $historyContent);
            if($repairType == 2){
                $strsql = sprintf("select orderDetailIndex from %s a inner join %s b on a.repairIndex=b.repairIndex inner join %s c on a.orderIndex = c.orderIndex and b.productIndex=c.productIndex where a.repairIndex='$repairIndex' and repairType=2", 'tbl_guestrepair', 'tbl_guestrepairdetail', 'tbl_productorderdetail');
                $result = Yii::$app->db->createCommand($strsql)->queryAll();
                while(count($result)){
                    $strsql2 = sprintf("UPDATE %s set retStatus = '0' where orderDetailIndex='%s'", 'tbl_productorderdetail', $result[0]['orderDetailIndex']);
                    Yii::$app->db->createCommand($strsql2)->execute();
                }
            }
        }
        if($processStatus == 2)
        {
            $strsql = sprintf("select repairType from %s where repairIndex='$repairIndex'", 'tbl_guestrepair');
            $result = Yii::$app->db->createCommand($strsql)->queryAll();
            $repairType = 1;
            if(count($result)) 
                $repairType = $result[0]['repairType'];
            if($repairType == 2) $this->RegisterHistoryData($repairIndex, "退货成功", $historyContent);
            else $this->RegisterHistoryData($repairIndex, "换货成功", $historyContent);
            $strsql = sprintf("INSERT INTO %s (productIndex, inputDate, inputAmount, inputCase) select b.productIndex, NOW(), orderAmount, '1' from %s a inner join %s b on a.repairIndex=b.repairIndex inner join %s c on a.orderIndex = c.orderIndex and b.productIndex=c.productIndex where a.repairIndex='$repairIndex' and repairType=2", 'tbl_productinput', 'tbl_guestrepair', 'tbl_guestrepairdetail', 'tbl_productorderdetail');
            Yii::$app->db->createCommand($strsql)->execute();
        }
    }
    
    public function RegisterHistoryData($repairIndex, $historyTitle, $historyContent)
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $sql_query = sprintf("INSERT INTO tbl_guestrepairhistory (repairIndex, historyDate, historyTitle, historyContent, historyIP, userIndex) values('$repairIndex', NOW(), '$historyTitle', '$historyContent', '%s', '%s')", $_SERVER["REMOTE_ADDR"], $_MYSESS['userIndex']);
        Yii::$app->db->createCommand($sql_query)->execute();
        return true;
    } 
}
