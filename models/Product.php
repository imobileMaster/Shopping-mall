<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_product".
 *
 * The followings are the available columns in table 'tbl_product':
 * @property string $productIndex
 * @property integer $classIdx
 * @property integer $markIndex
 * @property integer $productKindIndex
 * @property string $productCode
 * @property string $productName
 * @property string $productType
 * @property string $productColor
 * @property string $productOriginPlace
 * @property string $regDate
 * @property string $marketPrice
 * @property string $productPriceNow
 * @property string $productPriceOld
 * @property string $pointPrice
 * @property string $pointLowPrice
 * @property string $productWeight
 * @property string $weightUnit
 * @property string $productPackage
 * @property string $productService
 * @property string $productDetailInfo
 * @property string $relatedProductInfo
 * @property string $uploadCheck
 * @property string $remainAmount
 * @property string $requestAmount
 * @property string $limitAmount
 * @property string $sellAmount
 * @property integer $visibleStatus
 * @property integer $delStatus
 * @property string $discountRate
 * @property string $pointNum
 * @property string $carriageCharge
 * @property integer $receiptGeneralRate
 * @property integer $receiptVATRate
 * @property string $selDatePromotion
 * @property string $orderNumPromotion
 * @property string $selDateBestSells
 * @property string $orderNumBestSells
 * @property string $selDateNews
 * @property string $orderNumNews
 * @property string $selDateDiscount
 * @property string $orderNumDiscount
 * @property string $selDateBargain
 * @property string $orderNumBargain
 * @property integer $schedule
 * @property integer $peanuts
 * @property string $masterIndex
 * @property integer $chkTicket
 * @property string $productBarCode
 */
class Product extends ActiveRecord
{
    
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('classIdx, markIndex, productKindIndex, visibleStatus, delStatus, receiptGeneralRate, receiptVATRate, schedule, peanuts, chkTicket', 'numerical', 'integerOnly'=>true),
			array('productCode, productName, productType, productColor, productOriginPlace, productPackage, relatedProductInfo, uploadCheck, productBarCode', 'length', 'max'=>200),
			array('marketPrice, productPriceNow, productPriceOld, pointPrice, pointLowPrice, remainAmount, requestAmount, sellAmount, pointNum, masterIndex', 'length', 'max'=>20),
			array('productWeight, limitAmount, discountRate, orderNumPromotion, orderNumBestSells, orderNumNews, orderNumDiscount, orderNumBargain', 'length', 'max'=>10),
			array('weightUnit, carriageCharge', 'length', 'max'=>13),
			array('regDate, productService, productDetailInfo, selDatePromotion, selDateBestSells, selDateNews, selDateDiscount, selDateBargain', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('productIndex, classIdx, markIndex, productKindIndex, productCode, productName, productType, productColor, productOriginPlace, regDate, marketPrice, productPriceNow, productPriceOld, pointPrice, pointLowPrice, productWeight, weightUnit, productPackage, productService, productDetailInfo, relatedProductInfo, uploadCheck, remainAmount, requestAmount, limitAmount, sellAmount, visibleStatus, delStatus, discountRate, pointNum, carriageCharge, receiptGeneralRate, receiptVATRate, selDatePromotion, orderNumPromotion, selDateBestSells, orderNumBestSells, selDateNews, orderNumNews, selDateDiscount, orderNumDiscount, selDateBargain, orderNumBargain, schedule, peanuts, masterIndex, chkTicket, productBarCode', 'safe', 'on'=>'search'),
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
	            'class' => array(self::BELONGS_TO, 'Goodsclass', 'classIdx'),
	            'brand' => array(self::BELONGS_TO, 'Brandmark', 'markIndex'),        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'productIndex' => 'Product Index',
			'classIdx' => 'Class Index',
			'markIndex' => 'Mark Index',
			'productKindIndex' => 'Product Kind Index',
			'productCode' => 'Product Code',
			'productName' => 'Product Name',
			'productType' => 'Product Type',
			'productColor' => 'Product Color',
			'productOriginPlace' => 'Product Origin Place',
			'regDate' => 'Reg Date',
			'marketPrice' => 'Market Price',
			'productPriceNow' => 'Product Price Now',
			'productPriceOld' => 'Product Price Old',
			'pointPrice' => 'Point Price',
			'pointLowPrice' => 'Point Low Price',
			'productWeight' => 'Product Weight',
			'weightUnit' => 'Weight Unit',
			'productPackage' => 'Product Package',
			'productService' => 'Product Service',
			'productDetailInfo' => 'Product Detail Info',
			'relatedProductInfo' => 'Related Product Info',
			'uploadCheck' => 'Upload Check',
			'remainAmount' => 'Remain Amount',
			'requestAmount' => 'Request Amount',
			'limitAmount' => 'Limit Amount',
			'sellAmount' => 'Sell Amount',
			'visibleStatus' => 'Visible Status',
			'delStatus' => 'Del Status',
			'discountRate' => 'Discount Rate',
			'pointNum' => 'Point Num',
			'carriageCharge' => 'Carriage Charge',
			'receiptGeneralRate' => 'Receipt General Rate',
			'receiptVATRate' => 'Receipt Vatrate',
			'selDatePromotion' => 'Sel Date Promotion',
			'orderNumPromotion' => 'Order Num Promotion',
			'selDateBestSells' => 'Sel Date Best Sells',
			'orderNumBestSells' => 'Order Num Best Sells',
			'selDateNews' => 'Sel Date News',
			'orderNumNews' => 'Order Num News',
			'selDateDiscount' => 'Sel Date Discount',
			'orderNumDiscount' => 'Order Num Discount',
			'selDateBargain' => 'Sel Date Bargain',
			'orderNumBargain' => 'Order Num Bargain',
			'schedule' => 'Schedule',
			'peanuts' => 'Peanuts',
			'masterIndex' => 'Master Index',
			'chkTicket' => 'Chk Ticket',
			'productBarCode' => 'Product Bar Code',
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

		$criteria->compare('productIndex',$this->productIndex,true);
		$criteria->compare('classIdx',$this->classIdx);
		$criteria->compare('markIndex',$this->markIndex);
		$criteria->compare('productKindIndex',$this->productKindIndex);
		$criteria->compare('productCode',$this->productCode,true);
		$criteria->compare('productName',$this->productName,true);
		$criteria->compare('productType',$this->productType,true);
		$criteria->compare('productColor',$this->productColor,true);
		$criteria->compare('productOriginPlace',$this->productOriginPlace,true);
		$criteria->compare('regDate',$this->regDate,true);
		$criteria->compare('marketPrice',$this->marketPrice,true);
		$criteria->compare('productPriceNow',$this->productPriceNow,true);
		$criteria->compare('productPriceOld',$this->productPriceOld,true);
		$criteria->compare('pointPrice',$this->pointPrice,true);
		$criteria->compare('pointLowPrice',$this->pointLowPrice,true);
		$criteria->compare('productWeight',$this->productWeight,true);
		$criteria->compare('weightUnit',$this->weightUnit,true);
		$criteria->compare('productPackage',$this->productPackage,true);
		$criteria->compare('productService',$this->productService,true);
		$criteria->compare('productDetailInfo',$this->productDetailInfo,true);
		$criteria->compare('relatedProductInfo',$this->relatedProductInfo,true);
		$criteria->compare('uploadCheck',$this->uploadCheck,true);
		$criteria->compare('remainAmount',$this->remainAmount,true);
		$criteria->compare('requestAmount',$this->requestAmount,true);
		$criteria->compare('limitAmount',$this->limitAmount,true);
		$criteria->compare('sellAmount',$this->sellAmount,true);
		$criteria->compare('visibleStatus',$this->visibleStatus);
		$criteria->compare('delStatus',$this->delStatus);
		$criteria->compare('discountRate',$this->discountRate,true);
		$criteria->compare('pointNum',$this->pointNum,true);
		$criteria->compare('carriageCharge',$this->carriageCharge,true);
		$criteria->compare('receiptGeneralRate',$this->receiptGeneralRate);
		$criteria->compare('receiptVATRate',$this->receiptVATRate);
		$criteria->compare('selDatePromotion',$this->selDatePromotion,true);
		$criteria->compare('orderNumPromotion',$this->orderNumPromotion,true);
		$criteria->compare('selDateBestSells',$this->selDateBestSells,true);
		$criteria->compare('orderNumBestSells',$this->orderNumBestSells,true);
		$criteria->compare('selDateNews',$this->selDateNews,true);
		$criteria->compare('orderNumNews',$this->orderNumNews,true);
		$criteria->compare('selDateDiscount',$this->selDateDiscount,true);
		$criteria->compare('orderNumDiscount',$this->orderNumDiscount,true);
		$criteria->compare('selDateBargain',$this->selDateBargain,true);
		$criteria->compare('orderNumBargain',$this->orderNumBargain,true);
		$criteria->compare('schedule',$this->schedule);
		$criteria->compare('peanuts',$this->peanuts);
		$criteria->compare('masterIndex',$this->masterIndex,true);
		$criteria->compare('chkTicket',$this->chkTicket);
		$criteria->compare('productBarCode',$this->productBarCode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    function SearchProduct($genre, $class, $s_keyword, $orderFldName = "", $limitStr = "", $classIdx = '')
    {
        $strExe = "";
        $strExe2 = "";
        if($genre != -1){
            switch($genre){
                case "2":
                    $dateFldName = "5";
                    break;
                case "3":
                    $dateFldName = "4";
                    break;
                case "4":
                    $dateFldName = "3";
                    break;
                default:
                    $dateFldName = $genre;
            }
            $strExe = " inner join tbl_productselectdb g on a.productIndex=g.productIndex and pageTypeIndex=".$dateFldName;
        }
        
        if($class != -1)
            $strExe2 .= " and a.classIdx LIKE " . "'" . $class . "%'";
        
        if($classIdx)
            $strsql = "select distinct a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.classID, c.markName, c.markNameCn from tbl_product a inner join tbl_goodsclass b on a.classIdx = b.classIdx left join tbl_brandMark c on a.markIndex = c.markIndex $strExe where b.classIdx='$classIdx' $strExe2 and a.visibleStatus=0 and a.delStatus=0 and ";
        else
            $strsql = "select distinct a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.classID, c.markName, c.markNameCn from tbl_product a inner join tbl_goodsClass b on a.classIdx = b.classIdx left join tbl_brandMark c on a.markIndex = c.markIndex $strExe where a.delStatus=0 $strExe2 and a.visibleStatus=0 and ";
            
        $strFldName1 = "concat(productCode, productName, productType, productColor, productOriginPlace, classID, markName, markNameCn)";
        $strFldName = $strFldName1;
        $searchKeywordArr = explode(" ",  $s_keyword);
        
        for($i=0; $i<count($searchKeywordArr); $i++){
            if($i) $strsql .= " and ";
            $strsql .= "((UCASE(".$strFldName1.") LIKE '%".strtoupper($searchKeywordArr[$i])."%') or (".$strFldName." LIKE '%".$searchKeywordArr[$i]."%') or (replace(".$strFldName.", ' ', '') LIKE '%".$searchKeywordArr[$i]."%') or (replace(".$strFldName.", ' ', '') LIKE '%".strtoupper($searchKeywordArr[$i])."%'))";
        }              
        if($orderFldName == "") 
            $strsql .= " order by b.parentIdx, b.orderNum";
        else 
            $strsql .= " order by ".$orderFldName;
        $strsql .= $limitStr;
        return Yii::$app->db->createCommand($strsql)->query()->readAll();
    }
    
    function SearchProductCountForCategory($genre=-1, $class=-1, $s_keyword='')
    {
        $strExe = "";
        $strExe2 = "";
        if($genre != -1){
            switch($genre){
                case "2":
                    $dateFldName = "5";
                    break;
                case "3":
                    $dateFldName = "4";
                    break;
                case "4":
                    $dateFldName = "3";
                    break;
                default:
                    $dateFldName = $genre;
            }
            $strExe = " inner join tbl_productselectdb g on a.productIndex=g.productIndex and pageTypeIndex=".$dateFldName;
        }
        
        if($class != -1)
            $strExe2 .= " and a.classIdx LIKE " . "'" . $class . "%'";
        
        $strsql = "select count(distinct a.productIndex) cn, b.classID, b.classIdx from tbl_product a inner join tbl_goodsclass b on a.classIdx = b.classIdx left join tbl_brandMark c on a.markIndex = c.markIndex $strExe where a.delStatus=0 $strExe2  and a.visibleStatus=0 and ";
        $strFldName1 = "concat(productCode, productName, productType, productColor, productOriginPlace, classID, markName, markNameCn)";
        $strFldName = $strFldName1;
        $searchKeywordArr = explode(" ",  $s_keyword);
        for($i=0; $i<count($searchKeywordArr); $i++){
            if($i) $strsql .= " and ";
            $strsql .= "((UCASE(".$strFldName1.") LIKE '%".strtoupper($searchKeywordArr[$i])."%') or (".$strFldName." LIKE '%".$searchKeywordArr[$i]."%') or (replace(".$strFldName.", ' ', '') LIKE '%".$searchKeywordArr[$i]."%') or (replace(".$strFldName.", ' ', '') LIKE '%".strtoupper($searchKeywordArr[$i])."%')) ";
        }  
        $strsql .= "group by b.classID, b.classIdx";
        
        return Yii::$app->db->createCommand($strsql)->queryAll();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    function GetProductItem($productIndex)
    {   
        $strsql = sprintf("select a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.markName, b.markNameCn from %s a left join %s b on a.markIndex=b.markIndex where productIndex = $productIndex", 'tbl_product', 'tbl_brandmark');
        return Yii::$app->db->createCommand($strsql)->queryOne();
    }    
    
    function GetProducts()
    {   
        $result = 0;                   
        
        $strsql = "select * from tbl_product";
        
        $result =  Yii::$app->db->createCommand($strsql)->query();
        
        foreach($result as $row)
        {                                
            return $row;                   
        }
        return null;
    }           
    
    function GetProductPackagePrice($productIndex, $packNum)
    {
      
       $strsql = "select * from tbl_productPackage where productIndex = '$productIndex' and packNum= '$packNum'";
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();

       $productIndexStr = 0;
       $minusMoney = 0;
       foreach ($result as $row)
       {
           $productIndexStr = $row['productIndexStr'];
           $minusMoney = $row['minusMoney'];           
       }   
                                      
       $strsql = "select SUM(productPriceNow) sumMoney from tbl_product where productIndex in ('$productIndexStr')";
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();
       foreach ($result as $row)           
        return $row['sumMoney'] - $minusMoney;
       return null;
    }
    
    function GetProductPackageWeight($productIndex, $packNum)
    {
       
       $strsql = "select * from tbl_productPackage where productIndex = '$productIndex' and packNum='$packNum'";
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();
       foreach ($result as $row)
            $productIndexStr = $row['productIndexStr'];

       $strsql = "select SUM(productWeight*weightUnit) sumWeight from tbl_product where productIndex in ($productIndexStr)";
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();
       foreach ($result as $row)
            return $row['sumWeight'];
       return null;
    }    
                  
    function GetProductPackageNumber($productIndex, $packNum)
    {
       
       $strsql = "select count(*) cn from tbl_productPackage where productIndex = '$productIndex' and packNum<='$packNum' order by packNum";
       $result =  Yii::$app->db->createCommand($strsql)->queryScalar();
       
       return $result;
    }               
    
    function GetProductPackageProductArr($productIndex, $packNum)
    {        
       
        $strsql = "select * from tbl_productPackage where productIndex = '$productIndex' and packNum='$packNum'";
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();
       
       return $result;
    }
    
    public function getRecent($id)
	{
		$sql = sprintf("select a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.markName, b.markNameCn from tbl_product a left join tbl_brandmark b on a.markIndex=b.markIndex where productIndex = %d;" , $id);
		$data = Yii::$app->db->createCommand($sql)->queryOne();
        if(count($data) > 0) 
		    return $data;
		else
        return false;
	}
	
	public function getProductsOrderByDate($selmethod ,$limitAmount=0, $conditionStr= "", $orderStr="" , $orderDirection="desc")
	{
    	$strsql = sprintf("select a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.classID, c.markName, c.markNameCn from tbl_product a inner join tbl_goodsclass b on a.classIdx = b.classIdx left join tbl_brandmark c on a.markIndex = c.markIndex where delStatus=0 and visibleStatus=0");
    	if($conditionStr) $strsql .= " and ".$conditionStr;
		$orderStr2 = "";
    	switch($selmethod){
    		case "selDatePromotion":
    			$orderStr2 = "orderNumPromotion desc, ";
    			break;
    		case "selDateBestSells":
    			$orderStr2 = "orderNumBestSells desc, ";
    			break;
    		case "selDateNews":
    			$orderStr2 = "orderNumNews desc, ";
    			break;
    		case "selDateDiscount":
    			$orderStr2 = "orderNumDiscount desc, ";
    			break;
    		case "selDateDiscount":
    			$orderStr2 = "orderNumDiscount desc, ";
    			break;
    	}
    	$strsql .= " order by ".$orderStr2.$selmethod." ".$orderDirection.$orderStr.", b.parentIdx, b.orderNum ";
    	if($limitAmount) $strsql .= " limit ".$limitAmount.";";
    	$result = Yii::$app->db->createCommand($strsql)->queryAll();
    	return $result;	
	}
	
	public function getArrayFellProduct($pageTypeIndex, $selKindIndex, $pageDetailIndex, $limitNum=0)
	{
		if($limitNum>0) 
			$strsql = sprintf("SELECT a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.orderNum thisOrderNum from tbl_product a inner join tbl_productselectdb b on a.productIndex=b.productIndex where pageTypeIndex='$pageTypeIndex' and selKindIndex='$selKindIndex' and pageDetailIndex='$pageDetailIndex' order by b.orderNum limit $limitNum");
		else 
			$strsql = sprintf("SELECT a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.orderNum thisOrderNum from tbl_product a inner join tbl_productselectdb b on a.productIndex=b.productIndex where pageTypeIndex='$pageTypeIndex' and selKindIndex='$selKindIndex' and pageDetailIndex='$pageDetailIndex' order by b.orderNum");
		$result = Yii::$app->db->createCommand($strsql)->queryAll();
		return $result;
	}
    
    function GetFriendProducts($productIndex)
    {
        $strsql = "select a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2 from tbl_product a inner join tbl_product b on a.productIndex<>b.productIndex and a.productName=b.productName and a.productType=b.productType and a.productColor<>b.productColor and a.delStatus=0 and a.visibleStatus=0 where b.productIndex='$productIndex'";
        
        $result = Yii::$app->db->createCommand($strsql)->query();
        
        return $result;
    }
    
    public function getProductByBrandaaa($markIndex)
	{
		$retarray = array();
		$sqlstr = sprintf("SELECT * from tbl_product WHERE markIndex = '$markIndex';");
		$retarray = Yii::$app->db->createCommand($sqlstr)->queryAll();
		return $retarray;
	}
    
    function GetProductArr1($markIndex, $orderStr, $n, $curPage, $classIdx)
    {
        $strsql = "select a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.classID, c.markName, c.markNameCn, d.unionName from tbl_product a inner join tbl_goodsclass b on a.classIdx = b.classIdx left join tbl_brandMark c on a.markIndex = c.markIndex inner join tbl_userUnion d on a.masterIndex = d.unionIndex";
        
        $searchKeyword = " where a.delStatus=0 and visibleStatus=0 and a.markIndex='".$markIndex."' and (a.classIdx='".$classIdx."' or '0'='".$classIdx."') order by ".$orderStr;
        $limitStr = " limit ".$n*($curPage-1).",".$n;
        
        $strsql .= $searchKeyword;
        $strsql .= $limitStr;
        $result =  Yii::$app->db->createCommand($strsql)->query();
        
        return $result;
    }
    
    function GetTotalProductCount1($markIndex, $classIdx)
    {
        $searchKeyword = "markIndex='".$markIndex."' and (classIdx='".$classIdx."' or '0'='".$classIdx."')";
        
        $strsql = "select count(*) cn from tbl_product where delStatus=0 and visibleStatus=0 and ".$searchKeyword;
        $result =  Yii::$app->db->createCommand($strsql)->queryScalar();
        return $result;
    }
    
    function GetProductCountsForBrand($markIndex)
    {
        $strsql = "select count(*) cn, a.classIdx, b.classID from tbl_product a inner join tbl_goodsclass b on a.classIdx = b.classIdx where markIndex = '$markIndex' and delStatus=0 and visibleStatus=0 group by a.classIdx, b.classID";
        
        $result =  Yii::$app->db->createCommand($strsql)->queryAll();
        
        return $result;
    }
    
    public function GetProductFilterBrandForCategory($classIdx)
    {
        $strsql = sprintf("select distinct a.markIndex, markNameCn from tbl_brandmark a inner join tbl_product b on a.markIndex = b.markIndex where classIdx = '$classIdx'");
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        return $result;
    }
    
    public function GetProductFilterPriceForCategory($classIdx)
    {
        $strsql = sprintf("select max(productPriceNow) priceVal from tbl_product where classIdx = '$classIdx'");
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row)
            return $row['priceVal'];
        return false;
    }
    
    public function GetProductFilterPriceForCategory2($classIdx)
    {
        $strsql = sprintf("select min(productPriceNow) priceVal from tbl_product where classIdx = '$classIdx'");
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach( $result as $row)
            return $row['priceVal'];
        return false;
    }
    
    public function GetProductFilterForCategory($classIdx)
    {
        $strsql = sprintf("select distinct productKindPropertyName, b.filterValue, productKindPropertyUnit from tbl_product a inner join tbl_productsearchfilter b on a.productIndex = b.productIndex inner join tbl_productkindproperty c on b.productKindPropertyIndex = c.productKindPropertyIndex where classIdx = '$classIdx' order by productKindPropertyName, b.filterValue, productKindPropertyUnit");
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        return $result;
    }
    
    public function GetProductIndexSetFromFilterValue($fldName, $fldValue, $productIndexSet="")
    {
        if($productIndexSet != "")
            $strsql = sprintf("select productIndex from tbl_productsearchfilter b inner join tbl_productkindproperty c on b.productKindPropertyIndex = c.productKindPropertyIndex where productKindPropertyName = '$fldName' and filterValue='$fldValue' and productIndex in ($productIndexSet)", 'tbl_productSearchFilter', 'tbl_productKindProperty');
        else
            $strsql = sprintf("select productIndex from tbl_productsearchfilter b inner join tbl_productkindproperty c on b.productKindPropertyIndex = c.productKindPropertyIndex where productKindPropertyName = '$fldName' and filterValue='$fldValue'");
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        $productIndexSet = "0";
        foreach($result as $row) 
            $productIndexSet .= ",".$row['productIndex'];
        return $productIndexSet;
    }
    
    public function GetTotalProductCount($searchKeyword)
    {
        $strsql = sprintf("select count(*) cn from tbl_product where delStatus=0 and visibleStatus=0 and ").$searchKeyword;
        $result = Yii::$app->db->createCommand($strsql)->queryScalar();
        return $result;
    }
    
    public function GetProductArr($searchKeyword, $limitStr="")
    {
        $strsql = sprintf("select a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.classID, c.markName, c.markNameCn, d.unionName from tbl_product a inner join tbl_goodsclass b on a.classIdx = b.classIdx left join tbl_brandmark c on a.markIndex = c.markIndex inner join tbl_userunion d on a.masterIndex = d.unionIndex");
        $strsql .= $searchKeyword;
        $strsql .= $limitStr;
        $result =  Yii::$app->db->createCommand($strsql)->queryAll();
        return $result;
    }
    
    public function getProductOrderArr($OkCancel, $curPage, $n)
    {
        $guestIndex = Yii::$app->user->id;   
       
        if ($OkCancel == 0)
            $sql = sprintf("select B.orderIndex,orderTicketNumber, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, productName, recvName, totalOrderMoney, orderDate,orderCancelDate ,payKind,confirmDate , payCompleteDate , productOutDate , sendDate ,recvDate, C.productIndex ,orderPrice , A.productType from tbl_product as A, tbl_productorder as B, tbl_productorderdetail as C where B.orderIndex = C.orderIndex and C.productIndex = A.productIndex and B.guestIndex = %d and orderCancelDate = '0000-00-00' order by orderDate desc limit %s, $n" , $guestIndex, ($curPage-1)*$n);
        else
           $sql = sprintf("select B.orderIndex,orderTicketNumber, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, productName, recvName, totalOrderMoney, orderDate,orderCancelDate ,payKind,confirmDate , payCompleteDate , productOutDate , sendDate ,recvDate , C.productIndex ,orderPrice , A.productType from tbl_product as A, tbl_productorder as B, tbl_productorderdetail as C where B.orderIndex = C.orderIndex and C.productIndex = A.productIndex and B.guestIndex = %d and orderCancelDate <> '0000-00-00' order by orderDate desc limit %s, $n" , $guestIndex, ($curPage-1)*$n);
            
        $dataReader = Yii::$app->db->createCommand($sql)->queryAll(); 
        
        $recentTicket = 0;
        $count_array = array();
        $count = 0;   
        $data = array();
        
        foreach($dataReader as $row) {
            array_unshift($data , $row);
            if ($recentTicket != $row['orderTicketNumber']){
                
                array_unshift($count_array , $count);
                $count = 1;                        
                $recentTicket = $row['orderTicketNumber'];                    
            }else
            {
                $count++;
            }      
        }
        
        array_unshift($count_array , $count);
        
        return array('count_array' => $count_array, 'data' => $data);
    }
	
	public function GetProductPackageReceiptPrice($productIndex, $packNum, $reciptExistVal, $reciptTypeVal)
    {
    	$strsql = sprintf("select * from tbl_productpackage where productIndex = '$productIndex' and packNum='$packNum'");
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();
	   foreach($result as $row){
       		$productIndexStr = $row['productIndexStr'];
       		$minusMoney = $row['minusMoney'];
       }
       
       $sumMoney = 0;
       $strsql = sprintf("select * from %s where productIndex in ($productIndexStr)", $this->tableName());
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();
       foreach($result as $row){
       		$productPriceNow = $row['productPriceNow'];
			if(($reciptExistVal==0)&&($row['chkTicket'] == 0)) 
				$productPriceNow = $row['productPriceNow'] * (100 - $row['receiptGeneralRate']) /100;
			if(($reciptExistVal)&&($row['chkTicket'] == 2)){
				if($reciptTypeVal == 1) $productPriceNow = $row['productPriceNow'] * (100 + $row['receiptGeneralRate']) /100;
				else $productPriceNow = $row['productPriceNow'] * (100 + $row['receiptVATRate']) /100;
			}
			$sumMoney += $productPriceNow;
		}
       
       $sumMoney -= $minusMoney;
       return $sumMoney;
    }
	
	public function GetProductPackageCarriageCharge($productIndex, $packNum)
    {
    	$strsql = sprintf("select * from tbl_productpackage where productIndex = '$productIndex' and packNum='$packNum'");
		$result =  Yii::$app->db->createCommand($strsql)->queryAll();
		foreach($result as $row){
			$productIndexStr = $row['productIndexStr'];
       }
       $strsql = sprintf("select SUM(carriageCharge) sumMoney from tbl_product where productIndex in ($productIndexStr)");
       $result =  Yii::$app->db->createCommand($strsql)->queryAll();
	   
       if(count($result) > 0 ) 
		foreach($result as $row)
			return $row['sumMoney'];
       return false;
    }
    
     function GetProductArrayForDates($dateFldName, $limitAmount=0, $conditionStr="", $orderStr="", $orderDirection="desc")
    {
        $strsql = sprintf("select a.*, IF(a.productColor<>'无',concat(a.productName, ' ', a.productColor), a.productName) productName2, b.classID, c.markName, c.markNameCn from tbl_product a inner join tbl_goodsClass b on a.classIdx = b.classIdx left join tbl_brandMark c on a.markIndex = c.markIndex where delStatus=0 and visibleStatus=0 ");
        if($conditionStr) $strsql .= " and ".$conditionStr;
        $orderStr2 = "";
        switch($dateFldName){
            case "selDatePromotion":
                $orderStr2 = "orderNumPromotion desc, ";
                break;
            case "selDateBestSells":
                $orderStr2 = "orderNumBestSells desc, ";
                break;
            case "selDateNews":
                $orderStr2 = "orderNumNews desc, ";
                break;
            case "selDateDiscount":
                $orderStr2 = "orderNumDiscount desc, ";
                break;
            case "selDateDiscount":
                $orderStr2 = "orderNumDiscount desc, ";
                break;
        }
        $strsql .= " order by ".$orderStr2.$dateFldName." ".$orderDirection.$orderStr.", b.parentIdx, b.orderNum ";
        if($limitAmount) $strsql .= " limit ".$limitAmount;
        $result =  yii::$app->db->createCommand($strsql)->queryAll();
        return $result;
    }
    
    	public function Register($productIndex, $guestIndex)
	{
		$strsql = sprintf("select count(*) cn from tbl_guestfavorite where productIndex='$productIndex' and guestIndex='%s'", $guestIndex);
		$result = Yii::$app->db->createCommand($strsql)->queryScalar();
		if($result) return false;
		$sqlstr = sprintf("insert into tbl_guestfavorite values('$guestIndex', '$productIndex' , '', NOW())");
		$result = Yii::$app->db->createCommand($sqlstr)->execute();
		return true;
	}
	
    public function changeProductIndex($productIndex)
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        $productObj = $this->GetProductItem($productIndex);
		if(count($productObj) > 0){			
            $categoryIndex = $productObj['classIdx'];
            $permitData = GlobalFunc::CheckUserPermitForCategory($categoryIndex); 
            if($permitData)
            {
                $strCondition = " productIndex='".$productIndex."'";
                if($_MYSESS['friendCheck']) $strCondition .= " and masterIndex='".$_MYSESS['unionIndex']."'";

                $strsql = sprintf("select count(*) cn from %s where $strCondition", 'tbl_product');
                $cn =  Yii::$app->db->createCommand($strsql)->queryScalar();
                if($cn == 1)
                    return $productIndex;
            }
        }
        return false;
    }	
}


