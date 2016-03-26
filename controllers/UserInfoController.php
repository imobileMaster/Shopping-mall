<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UserDB2;
use yii\helpers\Url;

class UserInfoController extends Controller
{
	public $layout='//layouts/column2';
	public $breadCrumbArr = array();
    public $defaultAction = 'login';
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'userLog',
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function filterUserLog($filterChain)
    {
        UserHistory::model()->userLog($this, $filterChain);
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new UserInfo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $mode = new CInputWidget();
        widget($mode);
       
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
		if(isset($_POST['Userinfo']))
		{
			$model->attributes=$_POST['Userinfo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->guestIndex));
		}

		return $this->render('update',array(
			'model'=>$model,
		));
	}
    public function actiondataSave()
    {
        $model=new UserInfo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        if(isset($_POST['Userinfo']))
        {
            $model->attributes = $_POST['Userinfo'];
            $id = $model['userID'];
            $model["userPassword"] = crypt($model["userPassword"]);
            $model["regDate"] =Date("Y-m-d h-m-s");
			$model->regStatus = 1;
			$regionCode = 0;
			if($_POST['UserNprov'] != -1) $regionCode = $_POST['UserNprov'];
			if($_POST['UserNcity'] != -1) $regionCode = $_POST['UserNcity'];
			if($_POST['UserNcounty'] != -1) $regionCode = $_POST['UserNcounty'];
			$model->regionIndex = $regionCode;
            if((!$model->findModel($id)) && ($id!="") && $model->save())
				UserInfo::model()->CheckUserDegree($model->guestIndex);
            
        }
    }
    
    public function actionRegister()
    {
        
        $model = new UserInfo;
        if(isset($_POST['index']))
        {
            
            $guestIndex = $_POST['index'];
            $model1 =$this->loadModel($guestIndex);
            return $this->renderPartial('register',array(
            'model'=>$model1,
        ));
        }
        else
            return $this->renderPartial('register',array(
                'model'=>$model,
				'UserRegionCode'=>RegionCode::model()->GetChildClass(0),
            ));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
    
    public function actiondbupdate()
    {
		$regioncode = new RegionCode;
        if(isset($_GET['index'])){
            $guestIndex = $_GET['index'];
         }
		
          if(isset($_POST['index'])){
            $guestIndex = $_POST['index'];
         }
		 
		 $model = $this->loadModel($guestIndex);
		 $giftCardArray = UserGiftCard::model()->GetGiftCardArrayForGuest($guestIndex);
		 
		 $orderMoneySum = ProductOrder::model()->GetOrderTotalInfo($guestIndex);
		 $orderMoneySum = $orderMoneySum['orderMoneySum'];
		 
		 $row = UserInfoSend::model()->GetDefaultRecv($guestIndex);
		 
		$globalRgnCode = $regioncode->GetRegionCodeArray($model->regionIndex);
		$UserRgnCode = explode(",", $globalRgnCode);
		
		$UserRegionCode = $regioncode->GetChildClass(0);
		$UserRegionCode1 = $regioncode->GetChildClass($UserRgnCode[0]);
		$UserRegionCode2 = array();
		if(isset($UserRgnCode[1]))
		{
			$UserRegionCode2 = $regioncode->GetChildClass($UserRgnCode[1]);
			
		}
		
		 if($row == false)
			$defaultItem = 0;
		 else
			$defaultItem = 1;
		 
        $userAddrBook = UserInfoSend::model()->GetGuestInfos($guestIndex);
        
        $regionCodeArray2 = array();
		$rgnCodeArrTmp = array();
		$regionCodeArrayTmp= array();
		$regionCodeArray1Tmp = array();
		$regionCodeArray2Tmp = array();
		
        for($i=0; $i<count($userAddrBook); $i++){
            $regionIndex = $userAddrBook[$i]["regionIndex"];
            $globalRgnCode = $regioncode->GetRegionCodeArray($regionIndex);
            $rgnCodeArr = explode(",", $globalRgnCode);
			array_push($rgnCodeArrTmp, $rgnCodeArr);
            $regionCodeArray = $regioncode->GetChildClass(0);
			array_push($regionCodeArrayTmp, $regionCodeArray);
            $regionCodeArray1 = $regioncode->GetChildClass($rgnCodeArr[0]);
			array_push($regionCodeArray1Tmp, $regionCodeArray1);
            if(isset($rgnCodeArr[1]))
			{
				$regionCodeArray2 = $regioncode->GetChildClass($rgnCodeArr[1]);
				array_push($regionCodeArray2Tmp, $regionCodeArray2);
			}
                
			
        }
        
        
       
		
		/*$globalRgnCode = $regioncode->GetRegionCodeArray($regionIndex);
		$rgnCodeArr = explode(",", $globalRgnCode);*/
		
		if(count($userAddrBook)>0)
		{

            return $this->renderPartial('Dataupdate',array(
			 'model'=>$model,
			 'defaultItem'=>$defaultItem,
			 'giftCardArray'=>$giftCardArray,
			 'userAddrBook'=>$userAddrBook,
			 'count'=>count($userAddrBook),
			 'orderMoneySum'=>$orderMoneySum,
			 'rgnCodeArr'=>$rgnCodeArrTmp,
			 'regionCodeArray1'=>$regionCodeArray1Tmp,
			 'regionCodeArray'=>$regionCodeArrayTmp,
			 'regionCodeArray2'=>$regionCodeArray2Tmp,
			 'userRgnCodeArr'=>$UserRgnCode,
			 'UserRegionCode'=>$UserRegionCode,
			 'UserRegionCode1'=>$UserRegionCode1,
			 'UserRegionCode2'=>$UserRegionCode2,
			));
		}
		else
		{
            return $this->renderPartial('Dataupdate',array(
				'model'=>$model,
				'defaultItem'=>$defaultItem,
				'giftCardArray'=>$giftCardArray,
				'userAddrBook'=>$userAddrBook,
				'count'=>count($userAddrBook),
				'orderMoneySum'=>$orderMoneySum,
				'userRgnCodeArr'=>$UserRgnCode,
				'UserRegionCode'=>$UserRegionCode,
				'UserRegionCode1'=>$UserRegionCode1,
				'UserRegionCode2'=>$UserRegionCode2,
			));
		}
		return;
	
     
    }
    public function actionupdateInfo()
    {
        
        $model = new UserInfoSend;
		
        if(isset($_POST['state']))
        {
			
            $model->ToDefault($_POST['recvIndex'],$_POST['guestIndex'],$_POST['state']);
        }
        else
            $model->ToDefault($_POST['recvIndex'],$_POST['guestIndex']);
        $this->redirect(array('dbupdate','index'=>$_POST['guestIndex']));
    }
    public function actionDataupdate()
    {
         
         if(isset($_POST['index'])){
            $guestIndex = $_POST['index'];
         }
         else
         {
             $guestIndex = 0;
         }
         $model=$this->loadModel($guestIndex);
        
         if(isset($_POST['pointAmount']))
            $model['pointAmount'] = $_POST['pointAmount'];

         
         if(isset($_POST['password'])){
            $data = $_POST['password'];
            $model['userPassword'] = crypt($data);
         }
         if(isset($_POST['userLock'])){
             if($_POST['userLock']!="")
             {
                if($model['userLock'] == "0")
                    $model['userLock'] = "1";
                else
                    $model['userLock'] = "0";
             }
         }
         
         $model->save();
    }
     public function actiondataupdate1()
    {
         if(isset($_POST['index'])){
            $guestIndex = $_POST['index'];
            $model=$this->loadModel($guestIndex);
         }
		 
		 $regionCode = 0;
		 if($_POST['UserNprov'] != -1) $regionCode = $_POST['UserNprov'];
		 if($_POST['UserNcity'] != -1) $regionCode = $_POST['UserNcity'];
		 if($_POST['UserNcounty'] != -1) $regionCode = $_POST['UserNcounty'];
         
         if(isset($_POST['Userinfo']))           {
            $model->attributes = $_POST['Userinfo'];
			$model->regionIndex = $regionCode;
            $model->save();
         }
		 
		
		 
		UserInfo::model()->CheckUserDegree($model->guestIndex);
		
		$relUrl = UserHistory::model()->getUrlFormat($_SERVER['REQUEST_URI']);
		$pmsDelete = GlobalFunc::checkPermission('s_UserInfo/guestManage', '添加用户');
        $pmsCreate = GlobalFunc::checkPermission('s_UserInfo/guestManage', '添加用户');
        $pmsUpdate = GlobalFunc::checkPermission('s_UserInfo/guestManage', '添加用户');
		
		if($strData = $_POST['strData'])
		{
			$sendDataArr = explode("#EXE#",$strData);
			for($i=0; $i<(count($sendDataArr)-1)/9; $i++){
				$recvIndex = $sendDataArr[9*$i];
				$recvName = $sendDataArr[9*$i+1];
				$prov = $sendDataArr[9*$i+2];
				$city = $sendDataArr[9*$i+3];
				$county = $sendDataArr[9*$i+4];
				$regionIndex = 0;
				if(isset($prov)&&($prov>0)) $regionIndex = $prov;
				if(isset($city)&&($city>0)) $regionIndex = $city;
				if(isset($county)&&($county>0)) $regionIndex = $county;
				$recvAddress = $sendDataArr[9*$i+5];
				$recvPostBox = $sendDataArr[9*$i+6];
				$recvPhoneNumber = $sendDataArr[9*$i+7];
				$recvTelNumber = $sendDataArr[9*$i+8];
				
				if($recvIndex){
					if($pmsUpdate) UserInfoSend::model()->UpdateSend($guestIndex, $recvIndex, $recvName, $recvAddress, $recvPostBox,  $regionIndex, $recvPhoneNumber, $recvTelNumber);
				} else {
					if($pmsCreate) UserInfoSend::model()->Register($guestIndex, $recvIndex, $recvName, $recvAddress, $recvPostBox,  $regionIndex, $recvPhoneNumber, $recvTelNumber);
				}
			}
		}
         
    }
    public function actiondatasearch()
    {
       
        $model = new UserInfo();
        if(isset($_POST['userID'])) $userID = $_POST['userID'];
        else
            $userID = "";
             
        if(isset($_POST['userName'])) $userName = $_POST['userName'];
        else
            $userName = "";
            
        if(isset($_POST['userSex'])) $userSex = $_POST['userSex'];
        else
            $userSex = 0;
        
        if(isset($_POST['regStatus'])) $regStatus = $_POST['regStatus'];
        else
            $regStatus = 0;
        
        if(isset($_POST['userLock'])) $userLock = $_POST['userLock'];
        else
            $userLock = 0;
        
        $retArray = $model->GetUserInfoArrayForPage($userID, $userName, $userSex, $regStatus, $userLock);
        
        $model1 = new UserGiftCard;
        for($i=0; $i<count($retArray); $i++){
            $retArray[$i]['No'] = $i+1;
             $retArray[$i]['userGiftCard'] = $model1->GetGiftCardArrayForGuestMoney($retArray[$i]['guestIndex']);
        }
        $model2 = new ProductOrder;
        for($i=0; $i<count($retArray); $i++){
             $row = $model2->GetOrderTotalInfo($retArray[$i]['guestIndex']);
             $retArray[$i]['orderMoneySum'] = $row['orderMoneySum'];
        }
        $regioncode = new RegionCode;
        
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Userinfo']))
            $model->attributes=$_GET['Userinfo'];



        return $this->renderPartial('item',array(
            'model'=>$retArray,
        ));
        
    }
	public function actionguestManage()
	{
		$model=new UserInfo('search');
        /*$curPage = $_POST['curPage'] ? $_POST['curPage'] : 1;
        $userID = $_POST['userID'] ? $_POST['userID'] : "";
        $userName = $_POST['userName'] ? $_POST['userName'] : "";
        $userSex = $_POST['userSex'] ? $_POST['userSex'] : 0;
        $regStatus = $_POST['regStatus'] ? $_POST['regStatus'] : 0;
        $userLock = $_POST['userLock'] ? $_POST['userLock'] : 0;*/
      
        if(isset($_POST['userID'])) $userID = $_POST['userID'];
        else
            $userID = "";
             
        if(isset($_POST['userName'])) $userName = $_POST['userName'];
        else
            $userName = "";
            
        if(isset($_POST['userSex'])) $userSex = $_POST['userSex'];
        else
            $userSex = 0;
        
        if(isset($_POST['regStatus'])) $regStatus = $_POST['regStatus'];
        else
            $regStatus = 0;
        
        if(isset($_POST['userLock'])) $userLock = $_POST['userLock'];
        else
            $userLock = 0;
        
        if(isset($_POST['ajaxForm'])) $ajaxForm = $_POST['ajaxForm'];
        else
            $ajaxForm = '0';
            
        if(isset($_POST['delUser'])) $delUser = $_POST['delUser'];
        else
            $delUser = '0';
        
        if($delUser != '0')
        {
            $delModel = $this->loadModel($delUser);
            $delModel->delete();
        }
       
        $retArray = $model->GetUserInfoArrayForPage($userID, $userName, $userSex, $regStatus, $userLock);
        
        $model1 = new UserGiftCard;
        for($i=0; $i<count($retArray); $i++){
            $retArray[$i]['No'] = $i+1;
             $retArray[$i]['userGiftCard'] = $model1->GetGiftCardArrayForGuestMoney($retArray[$i]['guestIndex']);
        }
        $model2 = new ProductOrder;
        for($i=0; $i<count($retArray); $i++){
             $row = $model2->GetOrderTotalInfo($retArray[$i]['guestIndex']);
             $retArray[$i]['orderMoneySum'] = $row['orderMoneySum'];
        }
		
		$relUrl = UserHistory::model()->getUrlFormat($_SERVER['REQUEST_URI']);
        $pmsDelete = GlobalFunc::checkPermission($relUrl, '添加用户');
        $pmsCreate = GlobalFunc::checkPermission($relUrl, '添加用户');
        $pmsUpdate = GlobalFunc::checkPermission($relUrl, '添加用户');
           
        if($ajaxForm == '1')
        {
            return $this->renderPartial('item',array(
                'model'=>$retArray,
				'pmsCreate'=>$pmsCreate,
				'pmsUpdate'=>$pmsUpdate,
				'pmsDelete'=>$pmsDelete,
            ));
			
            return;
        }

        return $this->render('guestManage',array(
			'model'=>$retArray,
            'userID'=>$userID,
            'userName'=>$userName,
            'userSex'=>$userSex,
            'regStatus'=>$regStatus,
            'userLock'=>$userLock,
            'pmsCreate'=>$pmsCreate,
            'pmsUpdate'=>$pmsUpdate,
            'pmsDelete'=>$pmsDelete,
            'dataProvider'=>new CArrayDataProvider($retArray,array(
                                    'keyField'=>'guestIndex',
                                    'pagination'=>array(
                                        'pageSize'=>8,
            ))),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Userinfo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UserInfo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Userinfo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='userinfo-form')
		{
			echo CActiveForm::validate($model);
			Yii::$app->end();
		}
	}

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest)
            $this->redirect(Url::to(["product-order/after-service"]));

        $model = new UserDB2();
        $alertKind = 0;

        if ($model->load(Yii::$app->request->post()) && ($alertKind = $model->login()) == 1)
            $this->redirect(Url::to(["product-order/after-service"]));
        else
            echo $this->renderPartial("/admin", ['alertKind'=>$alertKind, 'model' => $model]);
    }

    function actionLogout()
    {
        $model = new UserDB2();
        $model->logout();
        $this->redirect(Url::to(['login']));
    }
    
    function actionUpdateAdminOnlineTime()
    {
        $model = new UserDB2();
        $model->updateOnlineTime();
    }
	
	function actionGuestLicense()
	{
		$data = " ";
		if(file_exists(Yii::$app->basePath."\\views\\s_UserInfo\\guestLicense.html"))
			$data = file_get_contents(Yii::$app->basePath."\\views\\s_UserInfo\\guestLicense.html");
		
		$this->render("guestLicense", array('data'=>$data));
	}
	
	function actionGuestLicenseSave()
	{
		$data = $_POST['articleContent'];
		$data = file_put_contents(Yii::$app->basePath."\\views\\s_UserInfo\\guestLicense.html", $data);
	}
	
}
