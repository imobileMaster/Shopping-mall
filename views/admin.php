<?php
$baseUrl = Yii::$app->request->baseUrl.'/../../assets';
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\UserDB2 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="<?=$baseUrl?>/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="<?=$baseUrl?>/js/jquery.validate.js" type="text/javascript"></script>
        <script type="text/javascript" src='<?=$baseUrl?>/js/myAjax.js'></script>
        <title>丹东商城</title>
    </head>
    <body>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal', 'name'=>'frmCheck'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

            <div style="position:relative; top:100px; margin: 0px auto; background: url(<?=$baseUrl?>/images/passwordBack.gif) no-repeat;width:348px;height:205px;">
                <input type=text id=userName name="UserDB2[userID]" onkeypress="login(event)" style="border:0;position:absolute; left:158px; top:76px;width:134px; height:17px;" data-rule-required=true data-msg-required=" ">
                <span id="userName-error" style="border:0;position:absolute; left:298px; top:76px;"></span>
                <input type=password id=userPassword name="UserDB2[userPassword]" onkeypress="login(event)" style="border:0;position:absolute; left:158px; top:122px;width:134px; height:17px;" data-rule-required=true data-msg-required=" ">
                <span id="userPassword-error" style="border:0;position:absolute; left:298px; top:122px;"></span>
            </div>
    <?php ActiveForm::end(); ?>
    </body>
</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#userName').focus();
        alertKind = parseInt('<?=$alertKind?>');
        if(alertKind == 2)
            alert('This page is not allowed to anonymous users!');
        else if(alertKind == 3)
            alert('The account is already used by others!');

        addValidation("#frmCheck", "#userName", "#userName-error", "keyup", '<?=$baseUrl?>');
        addValidation("#frmCheck", "#userPassword", "#userPassword-error", "keyup", '<?=$baseUrl?>');

    });

    function checkInput()
    {
        check = 0;
        check = isValid("#userName", "#userName-error", '<?=$baseUrl?>') + isValid("#userPassword", "#userPassword-error", '<?=$baseUrl?>');
        if(!check) return;
        document.frmCheck.submit();
    }

    function login(e)
    {
        e = e || window.event;
        if(e.which==13) checkInput();
    }
</script>
