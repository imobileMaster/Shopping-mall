<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\GlobalFunc;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$baseUrl = Yii::$app->request->baseUrl.'/../../assets';

$MYSESS = Yii::$app->session->get('MYSESS');
$userName = $MYSESS['userName'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- blueprint CSS framework -->
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/ie.css" media="screen, projection" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/print.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/screen.css" />
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/css/menu.css"  />
    <!--Yii custom css-->
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/yii_custom/pager.css" />
    <link rel="stylesheet" type="text/css" href="<?=$baseUrl?>/yii_custom/yiitab/jquery.yiitab.css" />

    <script type="text/javascript" src="<?=$baseUrl?>/js/jquery-1.6.4.js"></script>
    <script type="text/javascript" src="<?=$baseUrl?>/js/ajaxupload.3.5.js" ></script>
    <script type="text/javascript" src='<?=$baseUrl?>/js/myAjax.js'></script>
    <style type="text/css">
        div#menu {margin:50px 0 0 95px;position:absolute; z-index:10;}
        div#topLeft{background:url(<?=$baseUrl?>/images/newTopLeft.gif) no-repeat; height:83px; width:483px;float:left;}
        div#topMiddle{background:url(<?=$baseUrl?>/images/newTopMiddle.gif) no-repeat; height:83px; width:413px;float:left;}
    </style>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <div class="container" id="page">
            <div style="position:absolute; top:30px; width:80%; text-align:right;z-index:11">[ <?=$userName?>]&nbsp;&nbsp;&nbsp;<a href="<?=Url::to(["user-info/logout"])?>" target="_top">[退出]</a></div>
            <div style="position:absolute;top:0px;left:0px;background-color:#E9E6D3;width:100%">
                <div id="topLeft"></div>
                <div id="topMiddle"></div>
                <div id="menu">
                    <ul class="menu">
                        <li><a title2="首页" href="<?=Url::to(['product-order/after-service'])?>" class="clickItem "><span>首 页</span></a></li>
                        <?=GlobalFunc::GetMenuContent();?>
                    </ul>
                </div>

                <div style="position:absolute;top:83px;left:0px; width:100%;">
<!--                    --><?php //Globalfunc::renderChat();?>
                    <?php echo $content; ?>
                </div>

            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script type="text/javascript">
    $(document).ready(function(){
        setInterval("reloadHeaderInfo();", 50000);
//        $(".breadcrumbs").addClass("new_breadcrumbs");
    });

    function reloadHeaderInfo(){
        $.ajax({
            type: "POST",
            url: '<?=Url::to(['user-info/update-admin-online-time'])?>',
            success: function(msg){},
            error: function(x,e){alert(x.responseText);}
        });
    }
</script>