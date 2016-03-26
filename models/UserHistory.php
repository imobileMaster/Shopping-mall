<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_userhistory".
 *
 * The followings are the available columns in table 'tbl_userhistory':
 * @property string $userName
 * @property string $historyDate
 * @property string $historyContent
 */
class UserHistory extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'tbl_userhistory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userName', 'length', 'max'=>255),
			array('historyDate, historyContent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userName, historyDate, historyContent', 'safe', 'on'=>'search'),
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
			'userName' => 'User Name',
			'historyDate' => 'History Date',
			'historyContent' => 'History Content',
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

		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('historyDate',$this->historyDate,true);
		$criteria->compare('historyContent',$this->historyContent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    function logUserHistory($logCase, $logClass=1, $trueMember=true, $detailInfo="")
    {
        $_MYSESS = Yii::$app->session->get('MYSESS');
        $logHistory = "";
        $prevLogHistory = "";
        switch($logClass){
            case "1": $prevLogHistory = "浏览"; break;
            case "2": $prevLogHistory = "追加"; break;
            case "3": $prevLogHistory = "删除"; break;
            case "4": $prevLogHistory = "更新"; break;
            case "5": $prevLogHistory = "处理"; break;
            case "6": $prevLogHistory = "印刷"; break;
            case "7": $prevLogHistory = "登录"; break;
            case "8": $prevLogHistory = "退出"; break;
            case "9": $prevLogHistory = "确认"; break;
            case "10": $prevLogHistory = "开票"; break;
            case "11": $prevLogHistory = "作废"; break;
            case "12": $prevLogHistory = "完成"; break;
            case "13": $prevLogHistory = "发送"; break;
            case "14": $prevLogHistory = "出庫取消"; break;
            case "15": $prevLogHistory = "出庫"; break;
            case "16": $prevLogHistory = "充值"; break;
        }
        switch($logCase){
            case "1": $logHistory = "帮助中心分类"; break;
            case "2": $logHistory = "礼品卡帮助分类"; break;
            case "3": $logHistory = "尾部演示项目"; break;
            case "4": $logHistory = "店名"; break;
            case "5": $logHistory = "地址名"; break;
            case "6": $logHistory = "流画像"; break;
            case "7": $logHistory = "协议内容"; break;
            case "8": $logHistory = "修改密码"; break;
            case "9": $logHistory = "商品分类"; break;
            case "10": $logHistory = "按分类推荐商品"; break;
            case "11": $logHistory = "品牌"; break;
            case "12": $logHistory = "推荐品牌"; break;
            case "13": $logHistory = "商品定义属性"; break;
            case "14": $logHistory = "商品选择"; break;
            case "15": $logHistory = "会员等级"; break;
            case "16": $logHistory = "用户"; break;
            case "17": $logHistory = "商城快报"; break;
            case "18": $logHistory = "短信息"; break;
            case "19": $logHistory = "商品"; break;
            case "20": $logHistory = "商品画像"; break;
            case "21": $logHistory = "商品介绍"; break;
            case "22": $logHistory = "商品包"; break;
            case "23": $logHistory = "商品入库"; break;
            case "24": $logHistory = "商品入出库帳簿"; break;
            case "25": $logHistory = "商品出库"; break;
            case "26": $logHistory = "退款申请"; break;
            case "27": $logHistory = "售后服务"; break;
            case "28": $logHistory = "投诉"; break;
            case "29": $logHistory = "商品评价"; break;
            case "30": $logHistory = "购买咨询"; break;
            case "31": $logHistory = "销售统计"; break;
            case "32": $logHistory = "订单统计"; break;
            case "33": $logHistory = "商品销售排行统计"; break;
            case "34": $logHistory = "网络信息系统"; break;
            case "35": $logHistory = "网络信息系统主"; break;
            case "36": $logHistory = "商品订单"; break;
            case "37": $logHistory = "发票"; break;
            case "38": $logHistory = "付款"; break;
            case "39": $logHistory = "配送"; break;
            case "40": $logHistory = "安排图片管理"; break;
            case "41": $logHistory = "图片安排页名"; break;
            case "42": $logHistory = "公司介绍分类"; break;
            case "43": $logHistory = "公司联系"; break;
            case "44": $logHistory = "单据管理"; break;
            case "45": $logHistory = "电子邮件"; break;
            case "46": $logHistory = "网站流量统计"; break;
            case "47": $logHistory = "问卷调查"; break;
            case "48": $logHistory = "友情链接"; break;
            case "49": $logHistory = "礼品卡信息"; break;
            case "50": $logHistory = "付款方式帮助"; break;
            case "51": $logHistory = "账户充值"; break;
            case "52": $logHistory = "商城活动"; break;
            case "53": $logHistory = "邮件发送模板"; break;
            default: $logHistory = $logCase; break;
        }
        $logHistory = $prevLogHistory.$logHistory;
        if($logClass == 1) $logHistory .= "页";
        $logHistory .= $detailInfo;
        $logHistory .= "。";
        if(isset($_MYSESS['userName'])) $userName = $_MYSESS['userName'];
        if((!isset($userName))||($userName == "")) $userName = $_SERVER["REMOTE_ADDR"]; 
        
        if(!($trueMember)) $logHistory = "尝试".$logHistory;
        $strsql = sprintf("select count(*) chkEq from tbl_userhistory where (userName='$userName' and historyContent='$logHistory') and DATE_ADD(historyDate, INTERVAL 1 MINUTE) >= NOW()");
        $result = Yii::$app->db->createCommand($strsql)->queryAll();
        foreach($result as $row){
            if($row['chkEq']) return false;
        }
        
        $strsql = sprintf("insert into tbl_userhistory values ('%s', NOW(), '%s')", $userName, $logHistory);
        Yii::$app->db->createCommand($strsql)->execute();
        return true;
    }
    
    public static function getUrlFormat($url)
    {
        $temp = explode("/", $url);
        $relUrl = $temp[count($temp) - 2]."/".$temp[count($temp) - 1];
        return $relUrl;
    }
    
    function userLog($controller, $filterChain)
    {
        $relUrl = UserHistory::model()->getUrlFormat($_SERVER['REQUEST_URI']);
        
        $logCase = -1;
        $logClass = 0;
        if(isset(Yii::$app->params['userLog'][$relUrl]))
        {
            $logCase = Yii::$app->params['userLog'][$relUrl]['logCase'];
            $logClass = Yii::$app->params['userLog'][$relUrl]['logClass'];
            Yii::$app->user->setState('returnUrl', $_SERVER['REQUEST_URI']);
        }

        if(GlobalFunc::checkPermission($relUrl))
        {
            if($logCase != -1) UserHistory::model()->logUserHistory($logCase, $logClass);
            $filterChain->run();
        }
        else
        {
            if($logCase != -1) UserHistory::model()->logUserHistory($logCase, $logClass, false);
            $controller->redirect($controller->createUrl("/s_UserInfo/login"));
        }
    }
}
