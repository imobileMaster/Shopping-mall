<?php
namespace app\models;

use Yii;
use app\models\UserMenu;

class GlobalFunc
{
    static public function resPath()
    {
        return realpath('/resources/');
    }
    
    public static function trailCode($reload, $checkChange=false, $frmName='')
    {
        global $errObj;

        echo "<script language='javascript'>";

        if($errObj['errNumber'] > 0){
            echo "alert('".$errObj['errMsg']."');";
            PutErrObj("", 0);
        } else {
            echo "alert('操作成功!');";
        }
        
        if($frmName){
            echo "parent.frmContent.".$frmName.".submit();";
        } else {
            switch($reload)
            {
                case 1:
                    echo "parent.frmContent.location.reload(true);";
                    break;
                case 2:
                    echo "parent.frmContent.frmlist.submit();";
                    break;
                case 3:
                    echo "parent.frmContent.frmDetail.frmlist.submit();";
                    break;
                case 4:
                    echo "parent.frmContent.frmSearch.submit();";
                    break;
                case 5:
                    echo "parent.location.reload(true);";
                    break;
            }
        }
        echo "</script>";
    }
    
    // @@@ special
    public static function checkPermission($pageUrl, $action = '')
    {
        return true; //@@@
        $_MYSESS = Yii::$app->session->get('MYSESS');
        $MYSESS['userIndex'] = $_MYSESS['userIndex'];
        $MYSQL['_userDB2'] = 'tbl_userdb2';
        $MYSQL['_userPMenu'] = "tbl_userpermitmenu";
        $MYSQL['_userMenu'] = "tbl_usermenu";
        $MYSQL['_userDB'] = "tbl_userdb2";
        $MYSQL['_userGroup'] = "tbl_usergroup";

        $exSql = ($action == '') ? '' : " and a.menuName = '$action'";

        if($pageUrl == "s_UserInfo/login")
            return true;

        if(Yii::$app->user->isGuest || $MYSESS['userIndex'] == '')
            return false;

        // for anomyous actions
        $strsql = "select count(*) from tbl_userpermitmenu where homeUrl = '$pageUrl'";
        $result = Yii::$app->db->createCommand($strsql)->queryScalar();
        if(!$result) return true;

        $strsql = sprintf("select permitDB from %s where userIndex='%s'", $MYSQL['_userDB2'], $MYSESS['userIndex']);
        $result = Yii::$app->db->createCommand($strsql)->queryScalar();

        if($result)
            $strsql = sprintf("select distinct b.menuIndex from %s a inner join %s b on a.homeURL = b.homeURL left join %s c on c.userIndex = %s where INSTR(c.permitDB, concat('E',a.menuIndex,'E')) and b.homeUrl = '$pageUrl'", $MYSQL['_userPMenu'], $MYSQL['_userMenu'], $MYSQL['_userDB'], $MYSESS["userIndex"]);
        else
            $strsql = sprintf("select distinct b.menuIndex from %s a inner join %s b on a.homeURL = b.homeURL left join %s c on c.userIndex = %s inner join %s d on c.groupIndex = d.groupIndex where INSTR(d.permitDB, concat('E',a.menuIndex,'E')) and b.homeUrl = '$pageUrl'", $MYSQL['_userPMenu'], $MYSQL['_userMenu'], $MYSQL['_userDB'], $MYSESS["userIndex"], $MYSQL['_userGroup']);

        $strsql .= $exSql;
        return Yii::$app->db->createCommand($strsql)->queryScalar();
    }

    public static function GetPayKindStr($payKindIndex)
    {
        $payKindIndex *= 1;
        if($payKindIndex > 4)
            return "使用网上账户";
        else
            return Yii::$app->params['payKindStrArr'][$payKindIndex];
    }
    
    public static function GetSendKindStr($sendKindIndex)
    {
        return Yii::$app->params['sendKindStrArr'][(int)$sendKindIndex];
    }

    public static function GetMenuContent($parentIndex = 0)
    {
        $menuproc = new UserMenu();
        $menuproc->arrUserMenu = array();
        $menuproc->MakeMenuArray(0);
        $strMenuIndex = $menuproc->strParentIndex;
        $baseUrl = Yii::$app->request->baseUrl."/index.php/";
        $menuproc->listChild($parentIndex, $strMenuIndex, '', $baseUrl);
        return $menuproc->menuContent;
    }
    
    // File Upload Settings
    public static function get_settings_str($proc_url, $str_url, $upload_id, $progress_id, $filetypes="*.gif;*.jpg;*.jpeg;*.png;*.mp4;*.txt", $button_text="追加图片", $button_width=100, $button_height=30, $button_img="swfupload_button.png")
    {
        $baseUrl = Yii::$app->request->baseUrl;
        $settings_str = 'flash_url : "'.$baseUrl.'/include/swfupload.swf",';
        
        if(strtolower(substr($proc_url, 0, 4)) == "http")
            $settings_str .= 'upload_url: "'.$proc_url.'?'.$str_url.'",';
        else
            $settings_str .= 'upload_url: "'.Yii::$app->baseUrl."/".$proc_url.'",';
                                                          
        $settings_str .= 'file_size_limit : "1000 MB",';
        $settings_str .= 'file_types : "'.$filetypes.'",';
        $settings_str .= 'file_types_description : "All Files",';
        $settings_str .= 'file_upload_limit : 1000,';
        $settings_str .= 'file_queue_limit : 0,';
        $settings_str .= 'custom_settings : { progressTarget : "'.$progress_id.'"},';
        $settings_str .= 'debug: false,';
        $settings_str .= 'button_width: "'.$button_width.'",';
        $settings_str .= 'button_height: "'.$button_height.'",';
        $settings_str .= 'button_placeholder_id: "'.$upload_id.'",';
        $settings_str .= 'button_image_url: "'.$baseUrl.'/images/'.$button_img.'",';
        $settings_str .= 'button_text: "<span class=\"text\">'.$button_text.'</span>",';
        $settings_str .= 'button_text_top_padding: "'.(($button_height - 20) / 2 + 1).'",';
        $settings_str .= 'button_text_left_padding: "0",';
        $settings_str .= 'button_text_style: ".text { color: #ffffff; font-weight: bold; text-align: center; font-size: 15px; font-family: 천리마, PRK P Gothic; }",';
        $settings_str .= 'file_queued_handler : fileQueued,';
        $settings_str .= 'file_queue_error_handler : fileQueueError,';
        $settings_str .= 'file_dialog_complete_handler : fileDialogComplete,';
        $settings_str .= 'upload_start_handler : uploadStart,';
        $settings_str .= 'upload_progress_handler : uploadProgress,';
        $settings_str .= 'upload_error_handler : uploadError,';
        $settings_str .= 'upload_success_handler : uploadSuccess,';
        $settings_str .= 'upload_complete_handler : uploadComplete,';
        $settings_str .= 'queue_complete_handler : queueComplete';
               // print_r("###".$settings_str);
        return $settings_str;
    }
    
    public static function GetFilterValue($retArr, $fldName, $fldUnit)
    {
        $ret = "";
        for($i = 0; $i < count($retArr); $i++){
            $curFldArr = explode("###EXE###", $retArr[$i]);
            $curFldName = $curFldArr[0];
            $curFldValue = "";
            if(count($curFldArr) > 1)
                $curFldValue = $curFldArr[1];
                
            if($curFldName == $fldName)
            {
                $ret = $curFldValue;
                if($fldUnit != "")
                {
                    $fldArr = explode($fldUnit, $curFldValue);
                    $ret = $fldArr[0];
                }
                return $ret;
            }
        }
        return $ret;
    }
    
    public static function CheckUserPermitForCategory($classIDx)
    {
		$_MYSESS = Yii::$app->session->get('MYSESS');
        if(strpos($_MYSESS["masterCategoryStr"]." ,", ",".$classIDx." ,")>0)
        {
            $strsql = sprintf("select count(*) cn from %s where userIndex='%s'", 'tbl_useruserpermit', $_MYSESS['userIndex']);
            $cn = Yii::$app->db->createCommand($strsql)->queryScalar();
            if($cn)
                $strsql = sprintf("select permit from %s where userIndex='%s' and classIDx='%s'", 'tbl_useruserpermit', $_MYSESS['userIndex'], $classIDx);
            else
                $strsql = sprintf("select permit from %s where groupIndex='%s' and classIDx='%s'", 'tbl_usergrouppermit', $_MYSESS['groupIndex'], $classIDx);
            $result = Yii::$app->db->createCommand($strsql)->queryScalar();
            if($result)
                return $result;
        }
        return false;
    }

    public static function getNewIndex($tableName)
    {
        $strsql = "show table status from ectianlong_updated like '$tableName'";
		$_tmp = Yii::$app->db->createCommand($strsql)->queryOne(); 
        return $_tmp['Auto_increment'];
    }
	
	public static function GetMaxIndexFromTable($tblName, $fldName, $chkNext = false){
		$maxIndex = 0;
		$sql_query = sprintf("select max($fldName) nowIndex from $tblName");
		$result = Yii::$app->db->createCommand($sql_query)->queryAll();
			foreach($result as $row)
				if(isset($row['nowIndex']))
					$maxIndex = $row['nowIndex'];
		
		if($chkNext) $maxIndex++;
		return $maxIndex;
	}
                             
    public static function renderChat()
    {
        $controller = new CController('chat');
        $controller->renderPartial('//s_BbsChat/chat');
    }

    public static function getPureArrFromQuery($field, $table, $cond)
    {
        $strsql = "select $field from {$table} where {$cond}";
        $fields = Yii::$app->db->createCommand($strsql)->queryAll();
        $result = array();
        foreach($fields as $row)
            array_push($result, $row[$field]);

        return $result;
    }
}  
