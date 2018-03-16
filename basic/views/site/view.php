<?php

/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
//use app\models\User;

$this->title = 'View Profile';
$this->params['breadcrumbs'][] = $this->title;

?>
            
<div class="site-viewprofile">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('signupSuccess')): ?>

        <div class="alert alert-success">
            Sign up Sucessfully
        </div>

    <?php else: ?>

<div class="row">
    <div class="col-lg-2">
        <div class="input-group">
            <?php
                echo  Html::a(
                '<button types="button" class="btn btn-success">Create User here</button>',
                Url::to('basic/web/site/signup', true)
            );
            ?>
        </div>
    </div>
    
<!--     <div class="col-lg-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">

           <?= Html::beginForm(['/site/view'], 'get')?>
                <?= Html::input('text',  ['class' => 'form-control', 'placeholder' => 'Search for...'])?>
                <?= Html::submitButton('Search', ['class' => 'btn btn-default']) ?>
                <?= Html::endForm() ?>
            </span>
        </div>
    </div> -->
    
    <?php $form = ActiveForm::begin(['method' => 'get', 'layout' => 'inline']); ?>
        <div class="col-lg-3">
                <?= $form->field($searchModel, 'username')->textInput(['placeholder' => 'Please Enter Any Info']) ?>
        </div>
        <div class="col-lg-3">
                <?= Html::submitButton('Search', ['class' => 'btn btn-default']) ?>
        </div>    
    <?php ActiveForm::end(); ?>

</div>
<!--     <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('successs'); ?>
    </div> -->
    <?php
    //     echo GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'columns' => [
    //         ['class' => 'yii\grid\SerialColumn'],
    //         'id',
    //         'username',
    //         'role',
    //         'name',
    //         'email',
    //         [
    //             'class' => 'yii\grid\ActionColumn',
    //             'template' => '{update} {delete} {profilexxx}',
    //             'buttons' => [
    //                 'update' => function ($url,$model) {
    //                     //$url = Url::to(['site/SiteController', 'id' => $model->id]);
    //                     return Html::a(
    //                         '<span class="glyphicon glyphicon-user"></span>', 
    //                         $url ='');
    //                 },
    //             'buttons' => [
    //                 'delete' => function ($url,$model) {
    //                     $url = Url::to(['site/SiteController', 'id' => $model->id]);
    //                     return Html::a(
    //                         '<span class="glyphicon glyphicon-user"></span>', 
    //                         $url ='');
    //                 }]
    //             ],
    //         ],
    //     ]]
    // );
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'role',
            'name',
            'email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {link} {urlCreator}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-user"></span>', 
                            Url::to('basic/web/site/update?id=' . $model->id, true)
                            );
                    },
                    'delete' => function ($url,$model) {
                        //$url = Url::to(['site/SiteController', 'id' => $model->id]);
                        return Html::a(
                            '<span class="glyphicon glyphicon-remove"></span>', 
                            Url::to('basic/web/site/delete?id=' . $model->id, true)
                            );
                    },
                    // 'link' => function ($url,$model) {
                    //     return HtmL::a(
                    //         '<span class="glyphicon glyphicon-link"></span>', 
                    //         UrL::to('basic/web/site/view?id=' . $model->id, true)
                    //         );
                    ],
                    'urlCreator' => function($action, $model, $key, $index) {
                        // if ($action === 'update') {
                        //     $url = 'site/update?id'.$model->id;
                        //     return $url;
                        // }
                         return Html::a(
                            '<span class="glyphicon glyphicon-user"></span>', 
                            Url::to('site/viewwwww', true)
                            );
                    }
                ],
            ],
        ]
    );

    ?>	
        <?php endif; ?>
</div>

