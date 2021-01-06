<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use app\magic\MobileMagic;

\app\assets\CovidAsset::register($this);
$menu_contracted = isset($_SESSION['menu_' . Yii::$app->user->id]) ? $_SESSION['menu_' . Yii::$app->user->id] : false;

?>

<?php $this->beginPage() ?>

<!doctype html>

<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>

    <title>INFOVISU - <?= Html::encode($this->title) ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    <script src="/js/jquery.min.js"></script>
    
    <script src="/js/tether.min.js"></script>
    
    <script src="/js/bootstrap.min.js"></script>
    
    <?php $this->head() ?>

</head>

    <body>

        <?php $this->beginBody() ?>

            <div id="wrapper" class="h-100 mh-100 pl-0">

                <div id="page-content-wrapper " class="h-100 mh-100 ">

                    <div class="page-content inset h-100 mh-100">

                        <div class="container-fluid pt-3 justify-content-between" id="content--container">

                            <?= $content ?>

                        </div>

                    </div>

                </div>

            </div>

        <?php $this->endBody() ?>

    </body>

</html>

<?php $this->endPage() ?>

