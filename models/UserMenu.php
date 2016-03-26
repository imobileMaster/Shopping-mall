<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_usermenu".
 *
 * The followings are the available columns in table 'tbl_usermenu':
 * @property string $menuIndex
 * @property string $parentIndex
 * @property string $menuName
 * @property string $homeURL
 * @property string $orderNum
 */
class UserMenu extends ActiveRecord
{
    public $arrUserMenu, $strParentIndex, $depth;
	/**
	 * @return string the associated database table name
	 */
    var $MenuIndex, $ParentIndex, $MenuName, $HomeURL, $OrderNum, $Depth;
    var $menuContent;
    
    function Usermenu($MenuIndex = 0, $ParentIndex = 0, $MenuName = "", $HomeURL = "", $OrderNum = 0)
    {
        $this->arrUserMenu = array();
        $this->MenuIndex        = $MenuIndex;
        $this->ParentIndex    = $ParentIndex;
        $this->MenuName        = $MenuName;
        $this->HomeURL        = $HomeURL;
        $this->OrderNum        = $OrderNum;
        $this->Depth            = 0;
        $this->menuContent = "";
    }

    public function getAllMenuArray()
    {
        global $MYSQL;
        
        $strsql=sprintf("select * from tbl_usermenu order by parentIndex, orderNum");    
        $result = Yii::$app->db->createCommand($strsql)->queryAll();;

        foreach($result as $myrow){
            $menu_info = new UserMenu();            
            $menu_info->MenuIndex = $myrow["menuIndex"];            
            $menu_info->ParentIndex = $myrow["parentIndex"];
            $menu_info->MenuName = $myrow["menuName"];            
            $menu_info->HomeURL = $myrow["homeURL"];
            $menu_info->OrderNum = $myrow["orderNum"];
            array_push($this->arrUserMenu, $menu_info);
        }
        
        return $this->arrUserMenu;
    }
    
	public static function tableName()
	{
		return 'tbl_usermenu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentIndex', 'length', 'max'=>20),
			array('menuName, homeURL', 'length', 'max'=>200),
			array('orderNum', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('menuIndex, parentIndex, menuName, homeURL, orderNum', 'safe', 'on'=>'search'),
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
			'menuIndex' => 'Menu Index',
			'parentIndex' => 'Parent Index',
			'menuName' => 'Menu Name',
			'homeURL' => 'Home Url',
			'orderNum' => 'Order Num',
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

		$criteria->compare('menuIndex',$this->menuIndex,true);
		$criteria->compare('parentIndex',$this->parentIndex,true);
		$criteria->compare('menuName',$this->menuName,true);
		$criteria->compare('homeURL',$this->homeURL,true);
		$criteria->compare('orderNum',$this->orderNum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usermenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    function MakeMenuArray($parentIndex)
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $checkAdmin = ($_MYSESS['userIndex'] == 1);
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];

        $MYSQL['_userMenu']         = "tbl_usermenu";
        $MYSQL['_userPMenu']        = "tbl_userpermitmenu";
        $MYSQL['_userDB']           = "tbl_userdb2";
        $MYSQL['_userDB2']          = "tbl_userdb2";
        $MYSQL['_userGroup']        = "tbl_usergroup";        
        
        $this->depth ++;

        if($parentIndex == 0){
            $this->strParentIndex = "0";
            $strsql=sprintf("select distinct b.menuIndex from %s a inner join %s b on a.homeURL = b.homeURL left join %s c on c.userIndex = %s where INSTR(c.permitDB, concat('E',a.menuIndex,'E'))", $MYSQL['_userPMenu'], $MYSQL['_userMenu'], $MYSQL['_userDB'], $MYSESS["userIndex"]);
            $result = Yii::$app->db->createCommand($strsql)->queryAll();
            
            foreach($result as $row)
                $this->strParentIndex .= "," . $row['menuIndex'] . $this->GetParentIndex($row['menuIndex']);

            if($this->strParentIndex == "0"){
                $strsql=sprintf("select distinct b.menuIndex from %s a inner join %s b on a.homeURL = b.homeURL left join %s c on c.userIndex = %s inner join %s d on c.groupIndex = d.groupIndex where INSTR(d.permitDB, concat('E',a.menuIndex,'E'))", $MYSQL['_userPMenu'], $MYSQL['_userMenu'], $MYSQL['_userDB'], $MYSESS["userIndex"], $MYSQL['_userGroup']);
                $result = Yii::$app->db->createCommand($strsql)->queryAll();
                foreach($result as $row)
                    $this->strParentIndex .= "," . $row['menuIndex'] . $this->GetParentIndex($row['menuIndex']);
            }
            if($checkAdmin){
                $strsql=sprintf("select menuIndex from %s where parentIndex = 1", $MYSQL['_userMenu']);
                $result = Yii::$app->db->createCommand($strsql)->queryAll();
                foreach($result as $row)
                    $this->strParentIndex .= "," . $row['menuIndex'] . $this->GetParentIndex($row['menuIndex']);
            }
            $this->strParentIndex = "(".$this->strParentIndex.")";
        }
        $sql_query=sprintf("select * from %s where parentIndex=$parentIndex and menuIndex in %s order by orderNum", $MYSQL['_userMenu'], $this->strParentIndex);    

        $result = Yii::$app->db->createCommand($sql_query)->queryAll();

        foreach($result as $myrow)
        {
            $menu_info = new UserMenu();            
            $menu_info->Depth = $this->depth;
            $menu_info->MenuIndex = $myrow["menuIndex"];            
            $menu_info->ParentIndex = $myrow["parentIndex"];
            $menu_info->MenuName = $myrow["menuName"];            
            $menu_info->HomeURL = $myrow["homeURL"];
            $menu_info->OrderNum = $myrow["orderNum"];
            array_push($this->arrUserMenu, $menu_info);

            $this->MakeMenuArray($myrow["menuIndex"]);
        }
        $this->depth --;
        return false;
    }

    public static function GetUserMenuArray($parentIndex, $strMenuIndex)
    {
        $sql_query = "SELECT * FROM tbl_usermenu where parentIndex='$parentIndex' and menuIndex in $strMenuIndex order by orderNum";    
        return Yii::$app->db->createCommand($sql_query)->queryAll();
    }
    
    function GetParentIndex($menuIndex){
        $ret = "";
        $strsql = "select parentIndex from tbl_usermenu where menuIndex=$menuIndex";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        
        if($result)
            $ret .= ",".$result[0]['parentIndex'] . $this->GetParentIndex($result[0]['parentIndex']);

        return $ret;
    }    
    
    function listChild($parentIndex, $strMenuIndex, $title="", $baseUrl='')
    {
        $array = $this->GetUserMenuArray($parentIndex, $strMenuIndex);

        foreach($array as $row)
        {
            $this->menuContent .= '<li><a title2="';
            if($title!="") 
                $this->menuContent .= $title.' — ';
            $this->menuContent .= $row['menuName'].'" href="';
            
            if($row['homeURL']!="") 
                $this->menuContent .= $baseUrl.'/'.$row['homeURL'].'"'; 
            else 
                $this->menuContent .= 'javascript:void(0);"';
                
            $childArray = $this->GetUserMenuArray($row['menuIndex'], $strMenuIndex);
            $this->menuContent .= ' class="clickItem ';
            if(count($childArray)>0) 
                $this->menuContent .= ' parent';
            $this->menuContent .= '"><span>'.$row['menuName'].'</span></a>';
            
            if(count($childArray)>0){
                $this->menuContent .= '<div><ul>';
                if($title!="") 
                    $this->listChild($row['menuIndex'], $strMenuIndex, $title.' — '.$row['menuName'], $baseUrl);
                else
                    $this->listChild($row['menuIndex'], $strMenuIndex, $row['menuName'], $baseUrl);
                $this->menuContent .= '</ul></div>';
            }
            $this->menuContent .= '</li>';
        }  
    }

    public function DeleteFromUserMenu()
    {
        global $MYSQL;
        $strsql = sprintf("DELETE FROM tbl_usermenu");    
        Yii::$app->db->createCommand($strsql)->execute();
    }
    
    function Register($menuIndex, $parentIndex, $menuName, $homeURL, $orderNum)
    {
        global $MYSQL;        
        $strsql = sprintf("INSERT INTO tbl_usermenu (menuIndex, parentIndex, menuName, homeURL, orderNum ) VALUES ('%s', '%s', '%s', '%s', '%s')", $menuIndex, $parentIndex, $menuName, $homeURL, $orderNum);
        Yii::$app->db->createCommand($strsql)->execute();
    }

    public function _getAncestors($menuIndex)    
    {
        $retArray = array();
        $strsql = "select menuName, parentIndex from tbl_usermenu where menuIndex = $menuIndex";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();  
        
        if(count($result))      
        {
            $retArray [$result[0]['menuName']] = null;
            $preArray = $this->_getAncestors($result[0]['parentIndex']);
            $retArray = array_merge($preArray, $retArray );            
        }
        else
            $retArray = array('首页'=>null);    
        return $retArray;
    }
    
    public function getAncestors($pageUrl)    
    {
        $strsql = "select menuIndex from tbl_usermenu where homeUrl = '$pageUrl'";
        $result = Yii::$app->db->createCommand($strsql)->queryScalar();
        
        if(!$result) 
            return array();
        else
            return $this->_getAncestors($result);
    }
}
