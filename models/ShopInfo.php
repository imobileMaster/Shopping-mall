<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_shopinfo".
 *
 * The followings are the available columns in table 'tbl_shopinfo':
 * @property string $shopIndex
 * @property string $shopName
 * @property string $shopAddress
 * @property string $shopMember
 * @property string $shopTelNumber
 * @property integer $orderNum
 */
class ShopInfo extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_shopinfo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderNum', 'numerical', 'integerOnly'=>true),
			array('shopName, shopAddress', 'length', 'max'=>200),
			array('shopMember, shopTelNumber', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('shopIndex, shopName, shopAddress, shopMember, shopTelNumber, orderNum', 'safe', 'on'=>'search'),
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
			'shopIndex' => 'Shop Index',
			'shopName' => 'Shop Name',
			'shopAddress' => 'Shop Address',
			'shopMember' => 'Shop Member',
			'shopTelNumber' => 'Shop Tel Number',
			'orderNum' => 'Order Num',
		);
	}
	
	public function GetItemArray()
	{ 
        $sql_query = sprintf("select * from %s order by orderNum", 'tbl_shopinfo');
        return Yii::$app->db->createCommand($sql_query)->queryAll();
	}
    
    public function GetItem($shopIndex)
    {
        $sql_query = sprintf("select * from %s where shopIndex='$shopIndex'", 'tbl_shopinfo');
        return Yii::$app->db->createCommand($sql_query)->queryOne();
    }
    
    public function orderItem($orderNum)
    {        
        $sql_query = "select * from tbl_shopinfo where orderNum = $orderNum";
        $item = yii::$app->db->CreateCommand($sql_query)->queryOne();
        if ($item)     
        {
            $sql_query = "select max(orderNum) nowIndex from tbl_shopinfo";
            $currentOrderNum = yii::$app->db->createCommand($sql_query)->queryScalar() + 1;
            $item['orderNum'] = $currentOrderNum;
            
            $orderNum = $item['orderNum'];
            $shopIndex = $item['shopIndex'];
            $shopName = $item['shopName'];
            $shopMember = $item['shopMember'];
            $shopTelNumber = $item['shopTelNumber'];
            $shopAddress = $item['shopAddress'];
            
            $sql_query = "update tbl_shopinfo set shopName = '$shopName', shopMember = '$shopMember', orderNum = '$orderNum', shopTelNumber = '$shopTelNumber', shopAddress = '$shopAddress' where shopIndex = '$shopIndex'";
            yii::$app->db->createCommand($sql_query)->execute();
        }
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

		$criteria->compare('shopIndex',$this->shopIndex,true);
		$criteria->compare('shopName',$this->shopName,true);
		$criteria->compare('shopAddress',$this->shopAddress,true);
		$criteria->compare('shopMember',$this->shopMember,true);
		$criteria->compare('shopTelNumber',$this->shopTelNumber,true);
		$criteria->compare('orderNum',$this->orderNum);
        
        $criteria->order = 'orderNum';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Shopinfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
