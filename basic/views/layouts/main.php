<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
// throw new \Exception(var_export(Yii::$app->user->identity->role, true));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Transfer', 'url' => ['/site/transfer']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                ['label' => Yii::$app->user->identity->username, 'items' => [
                ['label' => 'View All Profile', 'url' => ['/site/view'], 'visible' => Yii::$app->user->identity->role==='admin'],
                ['label' => 'Edit Profile', 'visible' => Yii::$app->user->identity->role !== 'admin' ,'url' => ['/site/update', 'id' => Yii::$app->user->identity->id]],
                ['label' => 'Change Password', 'url' => '#'],
                '<li class="divider"></li>',
                //problem for post 
                ['label' => 'Logout', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{label}</a>'],
            ]]    
            )]]);
            // Yii::$app->user->isGuest ? (
            //     ['label' => 'Login', 'url' => ['/site/login']]
            // ) : (
            //     '<div class="navbar-nav navbar-right">'
            //         .'<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.Yii::$app->user->identity->username
            //             .'<span class="caret"></span>'
            //         .'</button>'
            //         .'<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">'
            //             .'<li><a href="update">Edit Profile</a></li>'
            //             .'<li><a href="#">Change Password</a></li>'
            //             .'<li role="separator" class="divider"></li>'
            //             //PROBLEM
            //             . Html::beginForm(['/site/logout'], 'post')
            //             . Html::submitButton(
            //                 'Logout'
            //                 //['class' => 'btn btn-link logout']
            //             )
            //             . Html::endForm()

            //             //.'<li><a href="#">Logout</a></li>'
            //         .'</ul>'
            //     .'</div>'
            // )
         
            // Yii::$app->user->isGuest ? (
            //     ['label' => 'Login', 'url' => ['/site/login']]
            // ) : (
            //     '<div>'
            //     . Html::beginForm(['/site/logout'], 'post')
                // . Html::submitButton(
                //     'Babi (' . Yii::$app->user->identity->username . ')',
                //     ['class' => 'btn btn-default dropdown-toggle']
                // )

            //     . Html::endForm()
            //     . '</div>'
            // )
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
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
