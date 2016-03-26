<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_regioncode".
 *
 * The followings are the available columns in table 'tbl_regioncode':
 * @property string $regionIndex
 * @property string $parentIndex
 * @property string $regionID
 * @property string $regionInfo
 * @property string $orderNum
 */
class RegionCode extends ActiveRecord
{
	
	var $regionIndex, $parentIndex, $regionID, $regionInfo, $orderNum;
	var $depth = 0;
	
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_regioncode';
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
			array('regionID', 'length', 'max'=>200),
			array('regionInfo, orderNum', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('regionIndex, parentIndex, regionID, regionInfo, orderNum', 'safe', 'on'=>'search'),
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
			'regionIndex' => 'Region Index',
			'parentIndex' => 'Parent Index',
			'regionID' => 'Region',
			'regionInfo' => 'Region Info',
			'orderNum' => 'Order Num',
		);
	}
	public function CRegionCode($regionIndex=0, $parentIndex=0, $regionID="", $regionInfo="", $orderNum=0)
    {
        $this->regionIndex = $regionIndex;
        $this->parentIndex = $parentIndex;
        $this->regionID = $regionID;
        $this->regionInfo = $regionInfo;
        $this->orderNum = $orderNum;        
    }

	public function GetItem($regionIndex)
	{
		$strsql = sprintf("select * from %s where regionIndex = '$regionIndex'", 'tbl_regioncode');
		return Yii::$app->db->createCommand($strsql)->queryOne();
	}
	
	public function GetRegionCodeArray($regionIndex)
	{
		$procRgnObj = $this->GetItem($regionIndex);
		$globalRgnCode = $regionIndex;
		if($procRgnObj){
			if($procRgnObj['parentIndex']!= 0) $globalRgnCode = $this->GetRegionCodeArray($procRgnObj['parentIndex']).",".$globalRgnCode;
		}
		return $globalRgnCode;
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

		$criteria->compare('regionIndex',$this->regionIndex,true);
		$criteria->compare('parentIndex',$this->parentIndex,true);
		$criteria->compare('regionID',$this->regionID,true);
		$criteria->compare('regionInfo',$this->regionInfo,true);
		$criteria->compare('orderNum',$this->orderNum,true);

        $criteria->order = 'orderNum';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchByparentIndex($parentIndex = 0)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;                               

        $criteria->compare('regionIndex',$this->regionIndex,true);    
        $criteria->compare('parentIndex',$parentIndex);         
        $criteria->compare('regionID',$this->regionID,true);
        $criteria->compare('regionInfo',$this->regionInfo,true);
        $criteria->compare('orderNum',$this->orderNum,true);

        $criteria->order = 'orderNum';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Regioncode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function GetChildClass($parentIndex, $includeChild = false)
	{
        global $depth; 
		$depth++;
		$retArray = array();
		$strsql = sprintf("select * from %s where parentIndex = '$parentIndex' order by orderNum", 'tbl_regioncode');
		$result = Yii::$app->db->createCommand($strsql)->queryAll();
		
		foreach ($result as $row) {
			$row['parentIndex'] = $depth;
			array_push($retArray, $row);
			if($includeChild){
				$addArray = $this->GetChildClass($row['regionIndex'], $includeChild);
				$retArray = array_merge($retArray, $addArray);
			}
		}		
		$depth--;
		
		return $retArray;
	}
}
