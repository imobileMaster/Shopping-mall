<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_guestreturn".
 *
 * The followings are the available columns in table 'tbl_guestreturn':
 * @property string $returnIndex
 * @property integer $guestIndex
 * @property string $orderIndex
 * @property integer $returnType
 * @property string $requestName
 * @property string $requestPhoneNumber
 * @property string $requestContent
 * @property string $bankAccountName
 * @property string $bankAccountNumber
 * @property string $requestDate
 * @property string $processDate
 * @property string $inputDate
 * @property string $cancelDate
 * @property string $completeDate
 * @property integer $processStatus
 * @property string $readStatus
 */
class GuestReturn extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_guestreturn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('guestIndex, returnType, processStatus', 'numerical', 'integerOnly'=>true),
			array('orderIndex', 'length', 'max'=>20),
			array('requestName, requestPhoneNumber, bankAccountName, bankAccountNumber', 'length', 'max'=>200),
			array('requestContent, requestDate, processDate, inputDate, cancelDate, completeDate, readStatus', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('returnIndex, guestIndex, orderIndex, returnType, requestName, requestPhoneNumber, requestContent, bankAccountName, bankAccountNumber, requestDate, processDate, inputDate, cancelDate, completeDate, processStatus, readStatus', 'safe', 'on'=>'search'),
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
			'returnIndex' => 'Return Index',
			'guestIndex' => 'Guest Index',
			'orderIndex' => 'Order Index',
			'returnType' => 'Return Type',
			'requestName' => 'Request Name',
			'requestPhoneNumber' => 'Request Phone Number',
			'requestContent' => 'Request Content',
			'bankAccountName' => 'Bank Account Name',
			'bankAccountNumber' => 'Bank Account Number',
			'requestDate' => 'Request Date',
			'processDate' => 'Process Date',
			'inputDate' => 'Input Date',
			'cancelDate' => 'Cancel Date',
			'completeDate' => 'Complete Date',
			'processStatus' => 'Process Status',
			'readStatus' => 'Read Status',
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

		$criteria->compare('returnIndex',$this->returnIndex,true);
		$criteria->compare('guestIndex',$this->guestIndex);
		$criteria->compare('orderIndex',$this->orderIndex,true);
		$criteria->compare('returnType',$this->returnType);
		$criteria->compare('requestName',$this->requestName,true);
		$criteria->compare('requestPhoneNumber',$this->requestPhoneNumber,true);
		$criteria->compare('requestContent',$this->requestContent,true);
		$criteria->compare('bankAccountName',$this->bankAccountName,true);
		$criteria->compare('bankAccountNumber',$this->bankAccountNumber,true);
		$criteria->compare('requestDate',$this->requestDate,true);
		$criteria->compare('processDate',$this->processDate,true);
		$criteria->compare('inputDate',$this->inputDate,true);
		$criteria->compare('cancelDate',$this->cancelDate,true);
		$criteria->compare('completeDate',$this->completeDate,true);
		$criteria->compare('processStatus',$this->processStatus);
		$criteria->compare('readStatus',$this->readStatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Guestreturn the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    function GetReturnArr($orderYear, $orderMonth=0, $processStatus=-1, $orderTicketNumber="")
    {
        $strCondition = "";
        if($orderMonth > 0) 
            $strCondition .= " and month(requestDate)='".$orderMonth."'";
        if($processStatus != -1) 
            $strCondition .= " and processStatus='".$processStatus."'";
        if($orderTicketNumber != "") 
            $strCondition .= " and orderTicketNumber LIKE '%".$orderTicketNumber."%'";
        $strsql = sprintf("select a.*, b.orderTicketNumber, b.orderMoney+b.netMoney orderMoney, c.userName, c.userID from %s a inner join %s b on a.orderIndex = b.orderIndex inner join %s c on a.guestIndex = c.guestIndex where year(requestDate)='$orderYear' %s order by requestDate desc", "tbl_guestreturn", 'tbl_productorder', "tbl_userinfo", $strCondition);
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }

    function GetHistoryDataForOrder($returnIndex)
    {
        $strsql = sprintf("select a.*, b.userName from tbl_guestreturnhistory a inner join %s b on a.userIndex = b.userIndex where returnIndex='$returnIndex' order by historyDate", 'tbl_userdb2');
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }
}
