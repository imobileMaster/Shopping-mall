<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\UserInfo;
/**
 * This is the model class for table "tbl_productordermoney".
 *
 * The followings are the available columns in table 'tbl_productordermoney':
 * @property string $orderIndex
 * @property string $payDate
 * @property integer $payKind
 * @property string $moneyAmount
 * @property string $moneyInfo
 * @property string $moneyNumber
 * @property string $moneyUserIndex
 * @property string $moneyUserIP
 * @property string $moneyIndex
 */
class ProductOrderMoney extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_productordermoney';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payKind', 'numerical', 'integerOnly'=>true),
			array('orderIndex, moneyUserIndex', 'length', 'max'=>20),
			array('moneyAmount', 'length', 'max'=>13),
			array('moneyInfo, moneyNumber', 'length', 'max'=>200),
			array('moneyUserIP', 'length', 'max'=>255),
			array('payDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderIndex, payDate, payKind, moneyAmount, moneyInfo, moneyNumber, moneyUserIndex, moneyUserIP, moneyIndex', 'safe', 'on'=>'search'),
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
			'orderIndex' => 'Order Index',
			'payDate' => 'Pay Date',
			'payKind' => 'Pay Kind',
			'moneyAmount' => 'Money Amount',
			'moneyInfo' => 'Money Info',
			'moneyNumber' => 'Money Number',
			'moneyUserIndex' => 'Money User Index',
			'moneyUserIP' => 'Money User Ip',
			'moneyIndex' => 'Money Index',
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
		$criteria->compare('payDate',$this->payDate,true);
		$criteria->compare('payKind',$this->payKind);
		$criteria->compare('moneyAmount',$this->moneyAmount,true);
		$criteria->compare('moneyInfo',$this->moneyInfo,true);
		$criteria->compare('moneyNumber',$this->moneyNumber,true);
		$criteria->compare('moneyUserIndex',$this->moneyUserIndex,true);
		$criteria->compare('moneyUserIP',$this->moneyUserIP,true);
		$criteria->compare('moneyIndex',$this->moneyIndex,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productordermoney the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function GetOrderMoneyHistory($startDate, $endDate, $payStatus)
    {  
        $strsql = "select a.*, b.orderTicketNumber, b.ticketNumber, b.sendTicketNumber, c.userName from tbl_productordermoney a inner join tbl_productorder b on a.orderIndex = b.orderIndex inner join tbl_userdb2 c on a.moneyUserIndex=c.userIndex where TO_DAYS(a.payDate)>=TO_DAYS('$startDate') and TO_DAYS(a.payDate)<=TO_DAYS('$endDate') and (a.payKind='$payStatus' or '$payStatus'='-1') order by a.payDate desc";
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }
    
    public function GetPayRecords($orderIndex)
    {
        $strsql = sprintf("select a.*, b.userName from %s a left join %s b on a.moneyUserIndex = b.userIndex where orderIndex = '$orderIndex'", 'tbl_productordermoney', 'tbl_userdb2');
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }

    public function RegisterHistoryData($orderIndex, $historyTitle, $historyContent)
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];
        $sql_query = sprintf("INSERT INTO tbl_productorderhistory (orderIndex, historyDate, historyTitle, historyContent, historyIP, userIndex) values('$orderIndex', NOW(), '$historyTitle', '$historyContent', '%s', '%s')", $_SERVER["REMOTE_ADDR"], $MYSESS['userIndex']);
        Yii::$app->db->createCommand($sql_query)->execute();
        return true;
    }
    
    public function RegisterOrderMoney($orderIndex, $payKind, $moneyNumber, $moneyAmount, $moneyInfo)
    {
        $_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];
        $strsql = sprintf("insert into %s (orderIndex, payDate, payKind, moneyAmount, moneyInfo, moneyNumber, moneyUserIndex, moneyUserIP) values ('$orderIndex', NOW(), '$payKind', '$moneyAmount', '$moneyInfo', '$moneyNumber', '%s', '%s')", 'tbl_productordermoney', $MYSESS['userIndex'], $_SERVER["REMOTE_ADDR"]);
        Yii::$app->db->createCommand($strsql)->execute();
        
        $this->RegisterHistoryData($orderIndex, "支付", $moneyInfo);
        $strsql = sprintf("update %s set recvMoney = recvMoney + %f where orderIndex='$orderIndex'", 'tbl_productorder', $moneyAmount);
        Yii::$app->db->createCommand($strsql)->execute();
        
        $strsql = sprintf("update %s set payInitialDate=NOW() where orderIndex='$orderIndex' and payInitialDate='0000-00-00'", 'tbl_productorder');
        Yii::$app->db->createCommand($strsql)->execute();
        
        $strsql = sprintf("update %s set payCompleteDate=NOW() where orderMoney = recvMoney", 'tbl_productorder');
        Yii::$app->db->createCommand($strsql)->execute();
        
        $strsql = sprintf("update %s set confirmDate=NOW() where orderMoney = recvMoney and confirmDate='0000-00-00'", 'tbl_productorder');
        Yii::$app->db->createCommand($strsql)->execute();
        
        $this->CheckPseudoOrderComplete($orderIndex);
        return true;
    }
    
    public function CheckPseudoOrderComplete($orderIndex)
    {
        
        $procOrder = new ProductOrder();
        $pseudoCheck = false;
        $strsql = sprintf("select guestIndex, pseudoCheck from %s where orderIndex='$orderIndex' and orderMoney = recvMoney", 'tbl_productorder');
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        $guestIndex = 0;
        if(count($result)) {
            $pseudoCheck = $result[0]['pseudoCheck'];
            $guestIndex = $result[0]['guestIndex'];
        }
        if($pseudoCheck){
            $strsql = sprintf("select orderPrice, orderAmount, orderDetailIndex from %s where orderIndex='$orderIndex'", 'tbl_productorderdetail');
            $result = Yii::$app->db->createCommand($strsql)->queryAll();
            
            foreach($result as $row)
            {
                $orderPrice = $row['orderPrice'];
                $orderDetailIndex = $row['orderDetailIndex'];
                $orderAmount = $row['orderAmount'];
                for($i=0; $i<$orderAmount; $i++)
                {
                    $procOrder->GenGiftCard($guestIndex, $orderPrice, $orderDetailIndex);
                }
            }
            
            $strsql = sprintf("update %s set completeDate=NOW(), sendDate=NOW(), recvDate=NOW(), productOutDate=NOW() where orderIndex='$orderIndex' and orderMoney = recvMoney", 'tbl_productorder');
            Yii::$app->db->createCommand($strsql)->execute();            
            $procGuest = new UserInfo();
            $procGuest->CheckUserDegree($guestIndex);
        }
        
        $procOrder->CheckCompleteOrder($orderIndex);
        return true;
    }
    
    public function CancelOrderMoney($orderIndex, $moneyIndex)
    {
        $strsql = sprintf("select moneyAmount from %s where orderIndex='$orderIndex' and moneyIndex='$moneyIndex'", 'tbl_productordermoney');
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        if(count($result)){
            $orderMoney = $result[0]['moneyAmount'];
            if($orderMoney){
                $strsql = sprintf("delete from %s where moneyIndex='$moneyIndex' and (orderIndex='$orderIndex')", 'tbl_productordermoney');
                Yii::$app->db->createCommand($strsql)->execute();            
                $strsql = sprintf("Update %s set recvMoney = recvMoney - $orderMoney, payCompleteDate='0000-00-00' where orderIndex='$orderIndex'", 'tbl_productorder');
                Yii::$app->db->createCommand($strsql)->execute();            
                $strsql = sprintf("update %s set payInitialDate='0000-00-00' where orderIndex='$orderIndex' and recvMoney=0", 'tbl_productorder');
                Yii::$app->db->createCommand($strsql)->execute();            
            }
        } else return false;
        return true;
    }
}
