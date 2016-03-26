<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_usergiftcard".
 *
 * The followings are the available columns in table 'tbl_usergiftcard':
 * @property string $giftRecordIndex
 * @property string $guestIndex
 * @property string $giftCardIndex
 * @property string $cardMoney
 * @property string $remainMoney
 * @property string $cardID
 * @property string $cardPWD
 * @property string $startDate
 * @property string $endDate
 * @property integer $delStatus
 * @property string $orderDetailIndex
 * @property string $cardInfo
 */
class UserGiftCard extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_usergiftcard';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('delStatus', 'numerical', 'integerOnly'=>true),
			array('guestIndex, orderDetailIndex', 'length', 'max'=>20),
			array('giftCardIndex', 'length', 'max'=>11),
			array('cardMoney, remainMoney', 'length', 'max'=>10),
			array('cardID, cardPWD', 'length', 'max'=>200),
			array('startDate, endDate, cardInfo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('giftRecordIndex, guestIndex, giftCardIndex, cardMoney, remainMoney, cardID, cardPWD, startDate, endDate, delStatus, orderDetailIndex, cardInfo', 'safe', 'on'=>'search'),
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
			'giftRecordIndex' => 'Gift Record Index',
			'guestIndex' => 'Guest Index',
			'giftCardIndex' => 'Gift Card Index',
			'cardMoney' => 'Card Money',
			'remainMoney' => 'Remain Money',
			'cardID' => 'Card',
			'cardPWD' => 'Card Pwd',
			'startDate' => 'Start Date',
			'endDate' => 'End Date',
			'delStatus' => 'Del Status',
			'orderDetailIndex' => 'Order Detail Index',
			'cardInfo' => 'Card Info',
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

		$criteria->compare('giftRecordIndex',$this->giftRecordIndex,true);
		$criteria->compare('guestIndex',$this->guestIndex,true);
		$criteria->compare('giftCardIndex',$this->giftCardIndex,true);
		$criteria->compare('cardMoney',$this->cardMoney,true);
		$criteria->compare('remainMoney',$this->remainMoney,true);
		$criteria->compare('cardID',$this->cardID,true);
		$criteria->compare('cardPWD',$this->cardPWD,true);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('endDate',$this->endDate,true);
		$criteria->compare('delStatus',$this->delStatus);
		$criteria->compare('orderDetailIndex',$this->orderDetailIndex,true);
		$criteria->compare('cardInfo',$this->cardInfo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usergiftcard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
//start user function
	
    public function GetGiftCardRemain2($cardID, $guestIndex)
	{
        $sql_query = sprintf("SELECT remainMoney FROM %s WHERE remainMoney>0 and (TO_DAYS(startDate)<=TO_DAYS(CURRENT_DATE) and TO_DAYS(endDate)>=TO_DAYS(CURRENT_DATE)) and ((cardID='$cardID') and (guestIndex='$guestIndex')) and delStatus='0'", 'tbl_usergiftcard');
        return Yii::$app->db->createCommand($sql_query)->queryScalar();
	}
	
	public function UpdateGiftCardUse2($orderIndex, $cardRealID, $guestIndex, $cardUseMoney)
	{
        $sql_query = sprintf("UPDATE %s set remainMoney = remainMoney - $cardUseMoney WHERE (cardID='$cardRealID') and (guestIndex='$guestIndex')", 'tbl_usergiftcard');
        Yii::$app->db->createCommand($sql_query)->execute();
        $sql_query = sprintf("INSERT INTO %s (orderIndex, coinType, coinAmount, coinIndex) values ('$orderIndex', '1', '$cardUseMoney', '$cardRealID')", 'tbl_productorderdetailstatus');
        Yii::$app->db->createCommand($sql_query)->execute();
        $sql_query = sprintf("UPDATE %s set useCardMoney = useCardMoney + '$cardUseMoney' where orderIndex='$orderIndex'", 'tbl_productorder');
        Yii::$app->db->createCommand($sql_query)->execute();
        
    	return true;
	}
    
    public function GetCardPrice($orderIndex)
    {
        $sql_query = sprintf("SELECT coinAmount from %s where orderIndex='$orderIndex' and coinType='1'", 'tbl_productorderdetailstatus');
        return Yii::$app->db->createCommand($sql_query)->queryScalar();
    }
//end user function 
    public function GetGiftCardArrayForGuestMoney($guestIndex)
    {
        $sql_query = sprintf("SELECT SUM(remainMoney) smMoney FROM tbl_usergiftcard WHERE guestIndex='%s' and delStatus='0' and remainMoney>0", $guestIndex);
        return Yii::$app->db->createCommand($sql_query)->queryScalar();
    }
    
    function GetGiftCardArrayForManage($userID="")
    {
        if($userID != "")
            $sql_query = "SELECT a.userID, b.* FROM tbl_userinfo a right join tbl_usergiftcard b on a.guestIndex=b.guestIndex WHERE b.delStatus='0' and TO_DAYS(endDate)>=TO_DAYS(NOW()) and a.userID LIKE '%".$userID."%' order by a.userID";
        else 
            $sql_query = "SELECT a.userID, b.* FROM tbl_userinfo a right join tbl_usergiftcard b on a.guestIndex=b.guestIndex WHERE b.delStatus='0' and TO_DAYS(endDate)>=TO_DAYS(NOW()) order by a.userID";
        return Yii::$app->db->createCommand($sql_query)->queryAll();
    }
    
    public function GetGiftCardArrayForGuest($guestIndex)
    {
        $sql_query = "SELECT * FROM tbl_usergiftcard WHERE guestIndex='$guestIndex' and delStatus='0' and remainMoney>0 order by startDate";
        return Yii::$app->db->createCommand($sql_query)->queryAll();
    }
    public function deleteItem($userID)
    {
        if($userID =="") return false;
        $sql_query = "DELETE FROM tbl_usergiftcard WHERE giftRecordIndex='$userID'";
        Yii::$app->db->createCommand($sql_query)->execute();
    }
    function LogHistory($giftRecordIndex, $logTitle)
    {
        
        $sql_query = "SELECT * FROM tbl_usergiftcard WHERE giftRecordIndex='$giftRecordIndex'";
        $result = Yii::$app->db->createCommand($sql_query)->queryAll();

        foreach($result as $row)
        {
            $cardID = $row['cardID'];
            $sql_query = "INSERT INTO tbl_usergiftcardhistory (historyDate, historyTitle, historyContent, historyIP, userIndex) values(NOW(), '$logTitle', '卡号:' '$cardID', '127.0.0.1', '0')";
            Yii::$app->db->createCommand($sql_query)->execute();
        } 
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
        $cardPWD .= substr(((date("s")*103+date("i")*11+date("H")*1)+$this->GetMaxIndexFromTable('tbl_usergiftcard', "giftRecordIndex", true)),-3);
        
        $strsql = "select count(*) cn from tbl_usergiftcard where cardPWD='$cardPWD'";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        
        foreach($result as $row)
        {
            if($row['cn']> 0) 
                return $this->GenCardPWD();
            else 
                return $cardPWD;    
        }
       
        return false;
    }
    
    function GetMaxIndexFromTable($tblName, $fldName, $chkNext = false)
    {
        $maxIndex = 0;
        $sql_query = sprintf("select max($fldName) nowIndex from $tblName");
        $result = Yii::$app->db->createCommand($sql_query)->queryAll();
        foreach($result as $row)
            if($row['nowIndex']) $maxIndex = $row['nowIndex'];
    
        if($chkNext) $maxIndex++;
        
        return $maxIndex;
    }
    
    function ReGenGiftCard($cardIndex, $guestIndex, $cardInfo="")
    {
        $cardPWD = $this->GenCardPWD();
        if($cardInfo != "")
        {
            $strsql = "UPDATE tbl_usergiftcard set cardInfo='$cardInfo' where giftRecordIndex='$cardIndex'";
            SQLCmdExe($strsql);
        }
        $strsql = "UPDATE tbl_usergiftcard set guestIndex='$guestIndex', cardPWD='$cardPWD' where giftRecordIndex='$cardIndex'";
        
        return Yii::$app->db->createCommand($strsql)->execute();
    }
    
    function GenGiftCard($guestIndex, $orderPrice, $orderDetailIndex)
    {     
        $cardID = $this->GenCardID();
        $cardPWD = $this->GenCardPWD();
        $strsql = "INSERT INTO tbl_usergiftcard (guestIndex, cardMoney, remainMoney, cardID, cardPWD, startDate, endDate, orderDetailIndex) values('$guestIndex', '$orderPrice', '$orderPrice', '$cardID', '$cardPWD', CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 6 MONTH), '$orderDetailIndex')";
        Yii::$app->db->createCommand($strsql)->execute();
        
        return $this->GetMaxIndexFromTable('tbl_usergiftcard', "giftRecordIndex");
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
        $cardID .= substr((1000+$this->GetMaxIndexFromTable('tbl_usergiftcard', "giftRecordIndex", true)),-3);
        
        $strsql = "select count(*) cn from tbl_usergiftcard where cardID='$cardID'";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row)
            if($row['cn'] > 0) 
                return $this->GenCardID();
            else 
                return $cardID;
        
        return false;
    }
}
