<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_userdb2".
 *
 * The followings are the available columns in table 'tbl_userdb2':
 * @property string $userIndex
 * @property string $userName
 * @property string $userID
 * @property string $userPassword
 * @property string $userInfo
 * @property string $logonDate
 * @property string $logonIP
 * @property string $rePwdDate
 * @property string $logonCount
 * @property string $groupIndex
 * @property string $unionIndex
 * @property integer $delStatus
 * @property integer $chatPermit
 * @property string $permitDB
 */
class UserDB2 extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
     
    private $_user = false;
	public static function tableName()
	{
		return 'tbl_userdb2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return [
            ['chatPermit', 'integer'],
            [['userID', 'userPassword'], 'string', 'length' => [2, 124]],
            [['userID', 'userPassword'], 'required'],
        ];
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
			'userIndex' => 'User Index',
			'userName' => 'User Name',
			'userID' => 'User',
			'userPassword' => 'User Password',
			'userInfo' => 'User Info',
			'logonDate' => 'Logon Date',
			'logonIP' => 'Logon Ip',
			'rePwdDate' => 'Re Pwd Date',
			'logonCount' => 'Logon Count',
			'groupIndex' => 'Group Index',
			'unionIndex' => 'Union Index',
			'delStatus' => 'Del Status',
			'chatPermit' => 'Chat Permit',
			'permitDB' => 'Permit Db',
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

		$criteria->compare('userIndex',$this->userIndex,true);
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('userID',$this->userID,true);
		$criteria->compare('userPassword',$this->userPassword,true);
		$criteria->compare('userInfo',$this->userInfo,true);
		$criteria->compare('logonDate',$this->logonDate,true);
		$criteria->compare('logonIP',$this->logonIP,true);
		$criteria->compare('rePwdDate',$this->rePwdDate,true);
		$criteria->compare('logonCount',$this->logonCount,true);
		$criteria->compare('groupIndex',$this->groupIndex,true);
		$criteria->compare('unionIndex',$this->unionIndex,true);
		$criteria->compare('delStatus',$this->delStatus);
		$criteria->compare('chatPermit',$this->chatPermit);
		$criteria->compare('permitDB',$this->permitDB,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Logs in a user using the provided userid and password.
     * @return the result integer
     */
    public function login()
    {
        if ($this->validate()) {

            if($this->getUser())
            {
                if($this->_user->validatePassword($this->userPassword))
                {
                    if($this->_user->getOnline())
                        return 3;

                    Yii::$app->user->login($this->_user, 3600*24*30);
                    // register session values
                    $MYSESS['groupIndex'] = $this->_user->groupIndex;
                    $MYSESS['unionIndex'] = $this->_user->unionIndex;
                    $MYSESS['friendCheck'] = ($MYSESS["unionIndex"] != 1);
                    $MYSESS['userIndex'] = $this->_user->userIndex;
                    $MYSESS['userName'] = $this->_user->userName;
                    $MYSESS['chatPermit'] = $this->_user->chatPermit;
                    $MYSESS['menuIndex'] = 0;

                    $permitDB = $this->getPermitDB($MYSESS['unionIndex']);

                    $MYSESS['masterCategoryStr'] = $this->getMasterCategoryStr($MYSESS["groupIndex"], $MYSESS["userIndex"], $permitDB);

                    Yii::$app->session->set('MYSESS',$MYSESS);
//                    Yii::$app->user->setName($this->getGroupName($this->_user->getId()));
                    $this->updateLogOnDate($MYSESS["userIndex"]);

                    return 1;
                }
            }
        }

        return 2;
    }

    /**
     * Finds user by [[userid]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUserID($this->userID);
        }

        return $this->_user;
    }

    public function setMasterCategoryStr()
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS = $_MYSESS;
        $permitDB = $this->getPermitDB($MYSESS['unionIndex']);
        $MYSESS['masterCategoryStr'] = $this->getMasterCategoryStr($MYSESS["groupIndex"], $MYSESS["userIndex"], $permitDB);
        Yii::$app->user->setState('MYSESS',null);
        Yii::$app->user->setState('MYSESS',$MYSESS);
    }
    public function logout()
    {
        $this->updateOnlineTimeForLogout();
        Yii::$app->user->logout(); 
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Userdb2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function GetUserArray()
    {
        $strsql = sprintf("select a.*, b.groupName, c.unionName from tbl_userdb2 a inner join tbl_usergroup b on a.groupIndex=b.groupIndex inner join tbl_userunion c on a.unionIndex=c.unionIndex where a.delStatus='0' order by b.groupIndex, a.userIndex");
        $result = Yii::$app->db->createCommand($strsql)->query()->readAll();
        return $result;
    }
    
    function GetUserHistoryArray($startDate, $endDate, $userIndex=0)
    {
        if($userIndex == -1)
            $sql_query=sprintf("select distinct a.* from tbl_userhistory a left join tbl_userdb2 b on a.userName=b.userName where TO_DAYS(historyDate)>=TO_DAYS('$startDate') and TO_DAYS(historyDate)<=TO_DAYS('$endDate') and (b.userIndex is null) order by historyDate");        
        else
            $sql_query=sprintf("select distinct a.* from tbl_userhistory a left join tbl_userdb2 b on a.userName=b.userName where TO_DAYS(historyDate)>=TO_DAYS('$startDate') and TO_DAYS(historyDate)<=TO_DAYS('$endDate') and (b.userIndex='$userIndex' or '$userIndex'='0') order by historyDate");        
        $result = Yii::$app->db->createCommand($sql_query)->query()->readAll();
        return $result;        
    }
    
    function DeleteHistory($startDate, $endDate)
    {
        global $MYSQL;
        $sql_query=sprintf("Delete from tbl_userhistory where TO_DAYS(historyDate)>=TO_DAYS('$startDate') and TO_DAYS(historyDate)<=TO_DAYS('$endDate')");
        Yii::$app->db->createCommand($sql_query)->execute();
    }
    //start user function rrrrrrrrrrrrrrrrrrrrrrr
    public function GetItem($userIndex)
    {
        $strsql = sprintf("select a.*, b.groupName, c.unionName from %s a inner join %s b on a.groupIndex = b.groupIndex inner join %s c on a.unionIndex = c.unionIndex where delStatus='0' and userIndex = '$userIndex'", 'tbl_userdb2', 'tbl_usergroup', 'tbl_userunion');
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        if(count($result))
            return $result[0];
        return false;
    }
    
    public function GetItemArray()
    {
        $strsql = sprintf("select a.*, b.groupName, c.unionName from %s a inner join %s b on a.groupIndex = b.groupIndex inner join %s c on a.unionIndex = c.unionIndex where delStatus='0'", 'tbl_userdb2', 'tbl_usergroup', 'tbl_userunion');
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }
    
    public function UpdatePermitDB($userIndex, $permitDB)
    {        
        $strsql = sprintf("Update %s set permitDB='$permitDB' where userIndex='$userIndex'", 'tbl_userdb2');
        return Yii::$app->db->createCommand($strsql)->execute();
    }
    
    public function Delete_user($userIndex)
    {
        if($userIndex == 1) 
            return false;
        $sql_query = sprintf("Update %s set delStatus='1' WHERE userIndex='%s'", 'tbl_userdb2', $userIndex);    
        return Yii::$app->db->createCommand($sql_query)->execute();
    }
    
    public function Register_user($userIndex, $userID, $userName, $userInfo, $groupIndex, $unionIndex, $chatPermit, $userPassword="")
    {
        if(!($userIndex)){
            $sql_query = sprintf("SELECT * from %s where userID='$userID'", 'tbl_userdb2');
            $result = Yii::$app->db->createCommand($sql_query)->queryAll();
            if(count($result))  return false;
            $sql_query = sprintf("INSERT INTO %s (userID, userName, userInfo, groupIndex, unionIndex, chatPermit, permitDB) VALUES ('$userID', '$userName', '$userInfo', '$groupIndex', '$unionIndex', '$chatPermit', '')", 'tbl_userdb2');
        } else {
            $sql_query = sprintf("SELECT * from %s where userID='$userID' and userIndex<>'$userIndex'", 'tbl_userdb2');
            $result = Yii::$app->db->createCommand($sql_query)->queryAll();
            if(count($result))  return false;
            $sql_query = sprintf("UPDATE %s SET userID='$userID', userName='$userName', userInfo='$userInfo', groupIndex='$groupIndex', unionIndex='$unionIndex', chatPermit='$chatPermit' WHERE userIndex='%s'", 'tbl_userdb2', $userIndex);
        }
        Yii::$app->db->createCommand($sql_query)->execute();
        
        if(!($userIndex)) $userIndex = $this->GetMaxIndexFromTable('tbl_userdb2', "userIndex");
        if($userPassword){
            $sql_query = sprintf("UPDATE %s set userPassword='%s' where userIndex='$userIndex'", 'tbl_userdb2', crypt($userPassword));
            $result = Yii::$app->db->createCommand($sql_query)->execute();
        }
        return $userIndex;
    }
    
    public function GetMaxIndexFromTable($tblName, $fldName, $chkNext = false){
        $maxIndex = 0;
        $sql_query = sprintf("select max($fldName) nowIndex from $tblName");
        $row = Yii::$app->db->createCommand($sql_query)->queryScalar();
        if(isset($row)) $maxIndex = $row;
        if($chkNext) $maxIndex++;
        return $maxIndex;
    }
    public function getGroupName($id)
    {
        $strsql = "select groupName from tbl_userdb2 a join tbl_usergroup b on a.groupIndex = b.groupIndex where userIndex=$id;";
        return Yii::$app->db->createCommand($strsql)->queryScalar();
    }
    
    public function getPermitDB($unionIndex)
    {
        $strsql = "select permitDB from tbl_userunion where unionIndex='$unionIndex'";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row)
            return $row['permitDB'];
    }
    
    public function getMasterCategoryStr($groupIndex, $userIndex, $permitDB)
    {
        $str = "0";
        $strsql = "select classIdx from tbl_useruserpermit where userIndex='$userIndex' and (INSTR('$permitDB', concat('E', classIdx, 'E')))";
        $res = Yii::$app->db->createCommand($strsql)->queryAll();
        if(count($res)){
            foreach($res as $row)
                $str .= " ,".$row['classIdx'];
        } else {
            $strsql = "select classIdx from tbl_usergrouppermit where groupIndex='$groupIndex' and (INSTR('$permitDB', concat('E', classIdx, 'E')))";
            $res2 = Yii::$app->db->createCommand($strsql)->queryAll();
            foreach($res2 as $row2)
                $str .= ",".$row2['classIdx'];
        }
        return $str;
    }
    
    public function updateLogOnDate($userIndex)
    {
        $strsql = sprintf("update tbl_userdb2 set logonDate=NOW(), logonCount=logonCount+1, logonIP='%s' where userIndex='%s'", $_SERVER["REMOTE_ADDR"], $userIndex);
        Yii::$app->db->createCommand($strsql)->execute();
    }
    
    public function getUserPassword()
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
         $query = sprintf("select * from %s where userIndex='%s' and delStatus='0'", 'tbl_userdb2', $_MYSESS['userIndex']);
         $result = Yii::$app->db->createCommand($query)->queryAll();
         foreach($result as $row)
            return $row;
         return false;       
    }
    
    public function savePassword($data)
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $strsql = sprintf("update %s set userPassword='%s', rePwdDate=NOW() where userIndex='%s'", 'tbl_userdb2', $data, $_MYSESS['userIndex']);
        Yii::$app->db->createCommand($strsql)->execute();
                          
    }
    
    public function updateOnlineTime()
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
		$strsql = "update tbl_userdb2 set logonDate = Now() where userIndex = ".$_MYSESS['userIndex'];
		Yii::$app->db->createCommand($strsql)->execute();
    }
    
    public function updateOnlineTimeForLogout()
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
		$strsql = "update tbl_userdb2 set logonDate = DATE_SUB(logonDate, INTERVAL 60 SECOND) where userIndex = ".$_MYSESS['userIndex'];
		Yii::$app->db->createCommand($strsql)->execute();
    }
}
