<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_userinfo".
 *
 * The followings are the available columns in table 'tbl_userinfo':
 * @property string $guestIndex
 * @property string $userID
 * @property string $userName
 * @property string $userPassword
 * @property string $userEmailAddress
 * @property string $userTelNumber
 * @property string $userPhoneNumber
 * @property integer $userSex
 * @property string $userBirthday
 * @property string $userIDCardNumber
 * @property string $userAddress
 * @property string $regionIndex
 * @property string $postCode
 * @property string $userDegree
 * @property integer $regStatus
 * @property integer $userLock
 * @property integer $delStatus
 * @property string $pointAmount
 * @property string $regDate
 * @property string $visitNumber
 * @property string $onlineTime
 * @property string $chatUserIndex
 * @property string $photoStr
 */
class UserInfo extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_userinfo';
	}            

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userSex, regStatus, userLock, delStatus', 'numerical', 'integerOnly'=>true),
			array('userID, userName, userPassword, userEmailAddress, userTelNumber, userPhoneNumber, userIDCardNumber, postCode', 'length', 'max'=>200),
			array('userAddress, photoStr', 'length', 'max'=>255),
			array('regionIndex, pointAmount, visitNumber, chatUserIndex', 'length', 'max'=>20),
			array('userDegree', 'length', 'max'=>10),
			array('userBirthday, regDate, onlineTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('guestIndex, userID, userName, userPassword, userEmailAddress, userTelNumber, userPhoneNumber, userSex, userBirthday, userIDCardNumber, userAddress, regionIndex, postCode, userDegree, regStatus, userLock, delStatus, pointAmount, regDate, visitNumber, onlineTime, chatUserIndex, photoStr', 'safe', 'on'=>'search'),
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
			'guestIndex' => 'Guest Index',
			'userID' => 'User',
			'userName' => 'User Name',
			'userPassword' => 'User Password',
			'userEmailAddress' => 'User Email Address',
			'userTelNumber' => 'User Tel Number',
			'userPhoneNumber' => 'User Phone Number',
			'userSex' => 'User Sex',
			'userBirthday' => 'User Birthday',
			'userIDCardNumber' => 'User Idcard Number',
			'userAddress' => 'User Address',
			'regionIndex' => 'Region Index',
			'postCode' => 'Post Code',
			'userDegree' => 'User Degree',
			'regStatus' => 'Reg Status',
			'userLock' => 'User Lock',
			'delStatus' => 'Del Status',
			'pointAmount' => 'Point Amount',
			'regDate' => 'Reg Date',
			'visitNumber' => 'Visit Number',
			'onlineTime' => 'Online Time',
			'chatUserIndex' => 'Chat User Index',
			'photoStr' => 'Photo Str',
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

		$criteria->compare('guestIndex',$this->guestIndex,true);
		$criteria->compare('userID',$this->userID,true);
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('userPassword',$this->userPassword,true);
		$criteria->compare('userEmailAddress',$this->userEmailAddress,true);
		$criteria->compare('userTelNumber',$this->userTelNumber,true);
		$criteria->compare('userPhoneNumber',$this->userPhoneNumber,true);
		$criteria->compare('userSex',$this->userSex);
		$criteria->compare('userBirthday',$this->userBirthday,true);
		$criteria->compare('userIDCardNumber',$this->userIDCardNumber,true);
		$criteria->compare('userAddress',$this->userAddress,true);
		$criteria->compare('regionIndex',$this->regionIndex,true);
		$criteria->compare('postCode',$this->postCode,true);
		$criteria->compare('userDegree',$this->userDegree,true);
		$criteria->compare('regStatus',$this->regStatus);
		$criteria->compare('userLock',$this->userLock);
		$criteria->compare('delStatus',$this->delStatus);
		$criteria->compare('pointAmount',$this->pointAmount,true);
		$criteria->compare('regDate',$this->regDate,true);
		$criteria->compare('visitNumber',$this->visitNumber,true);
		$criteria->compare('onlineTime',$this->onlineTime,true);
		$criteria->compare('chatUserIndex',$this->chatUserIndex,true);
		$criteria->compare('photoStr',$this->photoStr,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Userinfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function GetGuestIndexFormGuestID($userID)
    {
        
        $strsql = "select guestIndex from tbl_userinfo where userID='$userID'";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row) return $row["guestIndex"];
        return false;
    }

    public function GetUserInfoArrayForPage($userID, $userName, $userSex, $regStatus, $userLock)
    {
        $sql_query = "select * from tbl_userinfo WHERE delStatus='0' and userID LIKE '%".$userID."%' and userName LIKE '%".$userName."%'";
        if($userSex == 0) $sql_query .= " and userSex=userSex";
        if($userSex == 1) $sql_query .= " and userSex='0'";
        if($userSex == 2) $sql_query .= " and userSex='1'";
        if($regStatus == 0) $sql_query .= " and regStatus=regStatus";
        if($regStatus == 1) $sql_query .= " and regStatus='0'";
        if($regStatus == 2) $sql_query .= " and regStatus='1'";
        if($userLock == 0) $sql_query .= " and userLock=userLock";
        if($userLock == 1) $sql_query .= " and userLock='0'";
        if($userLock == 2) $sql_query .= " and userLock='1'";
        
        $result = Yii::$app->db->createCommand($sql_query)->queryAll();
        return $result;
    }

    public function findModel($id)
    {
        global $MYSQL;
        $sql_query = "select * from tbl_userinfo WHERE userID='$id'";
        $result = Yii::$app->db->createCommand($sql_query)->queryAll();
        $i = 0;
        foreach($result as $row)
            $i++;
        if($i>0)
            return true;
        else
            return false;
    }

    public function getIndex($id)
    {
        $sql_query = "select guestIndex from tbl_userinfo WHERE userID='$id'";
        $guestIndex = Yii::$app->db->createCommand($sql_query)->queryScalar();
        return $guestIndex;
    }

    function GetGuestInfo($guestIndex)
    {
        $sql_query = "select * from tbl_userinfo WHERE guestIndex='$guestIndex' and delStatus = '0'";
        return Yii::$app->db->createCommand($sql_query)->queryOne();
    }

    function ChangeUserIDs($userIDStr)
    {
        $ret = "";
        $strsql = "select userID from tbl_userinfo where INSTR('$userIDStr', concat('#',guestIndex,'#'))";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row) 
        {
            if($ret != "") $ret .= ", ";
            $ret .= $row["userID"];
        }
        return $ret;
    }
	
	function CheckUserDegree($guestIndex)
	{
		$strsql = sprintf("select SUM(orderAmount * orderPrice) sumPrice from %s a inner join %s b on a.orderIndex = b.orderIndex where guestIndex='$guestIndex' and completeDate<>'0000-00-00'", 'tbl_productorderdetail', 'tbl_productorder');
		$result = Yii::$app->db->createCommand($strsql)->queryScalar();
		$sumPrice = 0;
		if($result) $sumPrice = $result;
		if($sumPrice == "") $sumPrice = 0;
		$userDegree = 0;
		$strsql = sprintf("select userDegreeLimit from %s a inner join %s b on a.userDegree=b.userDegree where a.guestIndex='$guestIndex'", 'tbl_userinfo', 'tbl_userdegree');
		$result = Yii::$app->db->createCommand($strsql)->queryOne();
		if($result){
			if($sumPrice < $result['userDegreeLimit']) $sumPrice = $result['userDegreeLimit'];
		}
		
		$strsql = sprintf("select userDegree from %s where userDegreeLimit <= '%s' order by userDegreeLimit desc limit 1", 'tbl_userdegree', $sumPrice);
		$result = Yii::$app->db->createCommand($strsql)->queryOne();
		if($result) $userDegree = $result['userDegree'];
		$query = sprintf("update %s set userDegree = '$userDegree' where guestIndex='$guestIndex'", 'tbl_userinfo');
		Yii::$app->db->createCommand($query)->execute();
		return true;
	}
}
