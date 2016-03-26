<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "tbl_goodsclass".
 *
 * The followings are the available columns in table 'tbl_goodsclass':
 * @property string $classIdx
 * @property string $parentIdx
 * @property string $classID
 * @property string $recommendProduct
 * @property string $orderNum
 */
class Goodsclass extends ActiveRecord
{
    public $etc;
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_goodsclass';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('classID', 'required'),
            array('classID', 'length', 'max'=>100),
            array('recommendProduct', 'match', 'pattern'=>'/^[\d\s,]+$/', 'message'=>'Recommended product must be their indices'),
            array('orderNum', 'numerical', 'integerOnly'=>true),
            
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('classIdx, parentIdx, classID, recommendProduct, orderNum', 'safe', 'on'=>'search'),
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
			'classIdx' => 'Class Idx',
			'parentIdx' => 'Parent Idx',
			'classID' => 'Class',
			'recommendProduct' => 'Recommend Product',
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
        $criteria->compare('classIdx',$this->classIdx, true);
        $criteria->compare('parentIdx',$this->parentIdx);
		$criteria->compare('classID',$this->classID,true);
		$criteria->compare('recommendProduct',$this->recommendProduct,true);
		$criteria->compare('orderNum',$this->orderNum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Goodsclass the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function makeRepStr($letter, $num)
    {
        $str = '';
        for($i = 0; $i < $num; $i++)
            $str .= $letter;
            
        return $str;
    }
    
    public static function getChildrenClasses($parentIdx = '0000', $containDepth = 1, $mask = '')
    {
        $maskStr = ($mask == '') ? '' : "and classIdx in ($mask)";
        $len = strlen($parentIdx) + 3 * $containDepth;
        $len_ = strlen($parentIdx);

        $strsql = "select classIdx, classID from tbl_goodsclass where classIdx like '{$parentIdx}%' {$maskStr} and length(classIdx) <= {$len} and length(classIdx) > {$len_} order by classIdx";
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }
    
    public static function getRootCategory($containRoot = 0, $depth = 1, $paddingLetter = '.', $paddingDepth = 4, $mask = '', $parent = '0000')
    {
        $keyArray = array();
        $valArray = array();

        if($containRoot)
        {
            array_push($keyArray, $parent);
            array_push($valArray, '大分类');
        }
        
        $_rootArray = Goodsclass::getChildrenClasses($parent, $depth, $mask);
        
        foreach($_rootArray as $row)
        {
            array_push($keyArray, $row['classIdx']);
            $padStr = Goodsclass::makeRepStr($paddingLetter, $paddingDepth * (strlen($row['classIdx']) - 4) / 3);
            array_push($valArray, $padStr.$row['classID']);
        }
                    
        return array_combine($keyArray, $valArray);
    }    

    public static function getMaxIdx($parentIdx)    
    {
        $strsql = "select max(classIdx) from tbl_goodsclass where parentIdx = $parentIdx";
        $result = Yii::$app->db->createCommand($strsql)->queryScalar();        
        $maxIdx = (int)(substr($result, strlen($result) - 3)) + 1; 
        return  sprintf("%03d", $maxIdx);
    }
    public function __GenClasses($result, $className="classIdx", $parentName="parentIdx")
    {
        for($i = 0; $i < count($result); $i++)
        {
            $result[$i]['subMenu'] = array();
        }
        $cn = count($result);
        for($j=$cn-1; $j>=0; $j--)
        {
            $parentIdx = $result[$j][$parentName];
            for($i=$j-1; $i>=0; $i--)
            {
                if($result[$i][$className] === $parentIdx){
                    array_unshift($result[$i]['subMenu'], $result[$j]);
                    array_splice($result, $j, 1);
                    break;
                }
            }
        }
        return $result;
    }
    
    public function _GetClasses($parentIdx = "0000", $depth=-1, $masterCategoryStr="", $raw = 0)
    {
        if($masterCategoryStr == "" || $masterCategoryStr == "0") 
            $categoryStr = "";
        else
            $categoryStr = "and classIdx in ($masterCategoryStr) ";
            
        if($depth == -1) 
            $classIdxLen = 200;
        else
            $classIdxLen = count($parentIdx) + 3 * $depth;
            
        $strsql = "SELECT * FROM tbl_goodsclass WHERE classIdx LIKE '$parentIdx%' AND classIdx<>'$parentIdx' and length(classIdx) < $classIdxLen ".$categoryStr."ORDER BY classIdx";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        if($raw == 0) return $this->__GenClasses($result);
        return $result;
    }
	
	public function GetClassesStr($parentIdx = "0000", $depth=-1, $masterCategoryStr="")
	{
		$classesStr = "";
		$resArr = $this->_GetClasses($parentIdx, -1 , "", 1);
		foreach($resArr as $raw)
			$classesStr .= ",".$raw['classIdx'];
        return $classesStr;
	}
    
    function GetParentIndex($categoryIndex){  
        if($categoryIndex != "0000")
            return  substr($categoryIndex, 0, count($categoryIndex)-3);
        
        return false;
    }
    
    public function GoodsClass($classIdx=0, $parentIdx=0, $classID="", $orderNum=0, $etc=0)
    {
        $this->classIdx = $classIdx;
        $this->parentIdx = $parentIdx;
        $this->classID = $classID;
        $this->orderNum = $orderNum;
        $this->etc = $etc;
    }
    
    public function GetChildClass1($parentIndex, $includeChild = false, $inStr="")
    {
        $retArray = array();
        if($inStr == "") 
            $strsql = "select *, 0 chkEnable from tbl_goodsclass where classIdx LIKE '$parentIndex%' order by classIdx";
        else
            $strsql = "select *, (instr('$inStr', concat('E',classIdx,'E'))) chkEnable from tbl_goodsclass where classIdx LIKE '$parentIndex%' order by classIdx";
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        
        foreach($result as $row)
        {
            $retObj = new Goodsclass($row['classIdx'], $row['parentIdx'], $row['classID'], 0, $row['chkEnable']);
            array_push($retArray, $retObj);
        }        
        return $retArray;
    }

    public function getMaskClass($keyword)
    {
        $keyword = trim($keyword);
        $searchStr = "concat(productCode, productName, productType, productColor, productOriginPlace, classID)";
        $strsql = "select distinct a.classIdx from tbl_product a inner join tbl_goodsclass b on a.classIdx = b.classIdx left join tbl_brandMark c on a.markIndex = c.markIndex where a.visibleStatus=0 and a.delStatus=0 and ({$searchStr} like '%{$keyword}%' or concat(markName, markNameCn) like '%$keyword%') order by a.classIdx";
        $fields = Yii::$app->db->createCommand($strsql)->queryAll();
        $result = array();

        foreach($fields as $row)
        {
            array_push($result, substr($row['classIdx'], 0, -3));
            array_push($result, $row['classIdx']);
        }

        return implode(',', array_unique($result));
    }
}
