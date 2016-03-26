<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_netaccount".
 *
 * The followings are the available columns in table 'tbl_netaccount':
 * @property string $guestIndex
 * @property string $netMoney
 */
class NetAccount extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_netaccount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('guestIndex', 'length', 'max'=>20),
			array('netMoney', 'length', 'max'=>13),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('guestIndex, netMoney', 'safe', 'on'=>'search'),
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
			'netMoney' => 'Net Money',
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
		$criteria->compare('netMoney',$this->netMoney,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Netaccount the static model class
	 */
    public function GetNetAccount($guestIndex)
	{
		$strsql = sprintf("select * from %s where guestIndex='$guestIndex'", 'tbl_netaccount');
		return Yii::$app->db->createCommand($strsql)->queryOne();
	}
	
	public function CreateNetAccount($guestIndex)
	{
		if(!($this->GetNetAccount($guestIndex))){
			$strsql = sprintf("INSERT INTO %s (guestIndex, netMoney) values('$guestIndex', '0')", 'tbl_netaccount');
			Yii::$app->db->createCommand($strsql)->execute();
		}
	}
	
	public function NetMoneyOutput($guestIndex, $outputMoney, $outputType=0, $outputNote="")
	{
		if($outputMoney <= 0) return false;
		$this->CreateNetAccount($guestIndex);
		$netAccountObj = $this->GetNetAccount($guestIndex);
		$remainNetMoney = $netAccountObj['netMoney'];
		if($remainNetMoney < $outputMoney) return false;

		$strsql = sprintf("INSERT INTO %s (guestIndex, outputMoney, outputDate, outputType, outputNote) values ('$guestIndex', '$outputMoney', NOW(), '$outputType', '$outputNote')", 'tbl_netaccountoutput');
		Yii::$app->db->createCommand($strsql)->execute();
		$strsql = sprintf("UPDATE %s set netMoney = netMoney - $outputMoney where guestIndex='$guestIndex'", 'tbl_netaccount');
		return Yii::$app->db->createCommand($strsql)->execute();
	}
}
