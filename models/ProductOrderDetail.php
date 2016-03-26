<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_productorderdetail".
 *
 * The followings are the available columns in table 'tbl_productorderdetail':
 * @property string $orderDetailIndex
 * @property string $orderIndex
 * @property string $productIndex
 * @property string $orderAmount
 * @property string $orderPrice
 * @property string $orderPoint
 * @property string $orderNum
 * @property string $packNum
 * @property integer $retStatus
 */
class ProductOrderDetail extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_productorderdetail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('retStatus', 'numerical', 'integerOnly'=>true),
			array('orderIndex, productIndex, orderAmount, orderPoint, packNum', 'length', 'max'=>20),
			array('orderPrice, orderNum', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderDetailIndex, orderIndex, productIndex, orderAmount, orderPrice, orderPoint, orderNum, packNum, retStatus', 'safe', 'on'=>'search'),
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
			'orderDetailIndex' => 'Order Detail Index',
			'orderIndex' => 'Order Index',
			'productIndex' => 'Product Index',
			'orderAmount' => 'Order Amount',
			'orderPrice' => 'Order Price',
			'orderPoint' => 'Order Point',
			'orderNum' => 'Order Num',
			'packNum' => 'Pack Num',
			'retStatus' => 'Ret Status',
		);
	}

	public function GetOrderDetailArray($orderIndex)
    {
    	$sql_query = sprintf("select b.*, IF(b.productColor<>'无',concat(b.productName, ' ', b.productColor), b.productName) productName2, a.orderPrice, a.orderAmount, a.orderDetailIndex, a.packNum, a.orderPoint, a.retStatus from %s a left join %s b on a.productIndex = b.productIndex where orderIndex = '$orderIndex'", 'tbl_productorderdetail', 'tbl_product');
        return Yii::$app->db->createCommand($sql_query)->queryAll();
    }
    
    public function Delete_user($orderIndex, $nowDetailIndexArray)
    {
        if($nowDetailIndexArray != "")
    		$sql_query = sprintf("select productIndex, orderDetailIndex, orderAmount, orderStatus from %s a inner join %s b on a.orderIndex = b.orderIndex where a.orderIndex = '$orderIndex' and not(orderDetailIndex in ($nowDetailIndexArray))", 'tbl_productorderdetail', 'tbl_productorder');
    	else
    		$sql_query = sprintf("select productIndex, orderDetailIndex, orderAmount, orderStatus from %s a inner join %s b on a.orderIndex = b.orderIndex where a.orderIndex = '$orderIndex'", 'tbl_productorderdetail', 'tbl_productorder');
		$result = Yii::$app->db->createCommand($sql_query)->queryAll();

		foreach ($result as $row)
		{
			if($row['orderStatus']== 0){
				$sql_query = sprintf("delete from %s where orderDetailIndex='%s'", 'tbl_productorderdetail', $row['orderDetailIndex']);
				Yii::$app->db->createCommand($sql_query)->execute();
				$sql_query = sprintf("update %s set requestAmount = requestAmount - '%s' where productIndex = '%s'", 'tbl_product', $row['orderAmount'], $row['productIndex']);			
				Yii::$app->db->createCommand($sql_query)->execute();
			}
		}
       return $result;
    }
    
    function Register_user($orderIndex, $productIndex, $orderAmount, $orderPrice, $packNum, $orderPoint=0)
    {
        $sql_query = sprintf("insert into %s (orderIndex, productIndex, orderAmount, orderPrice, packNum, orderPoint) values('%s', '%s', '%s', '%s', '%s', '$orderPoint')", 'tbl_productorderdetail', $orderIndex, $productIndex, $orderAmount, $orderPrice, $packNum);
        Yii::$app->db->createCommand($sql_query)->execute();
        $sql_query = sprintf("update %s set requestAmount = requestAmount + '$orderAmount' where productIndex = '$productIndex'", 'tbl_product');
        Yii::$app->db->createCommand($sql_query)->execute();
        if($orderPoint > 0)
		{
			$strsql = sprintf("select guestIndex from %s where orderIndex='$orderIndex'", 'tbl_productorder');
        	$row = Yii::$app->db->createCommand($strsql)->queryScalar();
			$guestIndex = $row;
			$sql_query = sprintf("update %s set pointAmount = pointAmount - '%s' where guestIndex = '$guestIndex'", 'tbl_userinfo', ($orderPoint*$orderAmount));
       		Yii::$app->db->createCommand($sql_query)->execute();
		}
        return true;
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

		$criteria->compare('orderDetailIndex',$this->orderDetailIndex,true);
		$criteria->compare('orderIndex',$this->orderIndex,true);
		$criteria->compare('productIndex',$this->productIndex,true);
		$criteria->compare('orderAmount',$this->orderAmount,true);
		$criteria->compare('orderPrice',$this->orderPrice,true);
		$criteria->compare('orderPoint',$this->orderPoint,true);
		$criteria->compare('orderNum',$this->orderNum,true);
		$criteria->compare('packNum',$this->packNum,true);
		$criteria->compare('retStatus',$this->retStatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productorderdetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
