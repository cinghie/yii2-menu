<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.4
 */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('menu', 'Menu Types');
$this->params['breadcrumbs'][] = $this->title;

// Register action buttons js
$this->registerJs('$(document).ready(function()
    {'
    .$searchModel->getUpdateButtonJavascript('#w1')
    .$searchModel->getDeleteButtonJavascript('#w1')
    .$searchModel->getActiveButtonJavascript('#w1')
    .$searchModel->getDeactiveButtonJavascript('#w1').
    '});
');

?>

<div class="row">

    <!-- action menu -->
    <div class="col-md-6">

        <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-menu/views/default/_menu.php'); ?>

    </div>

    <!-- action buttons -->
    <div class="col-md-6">

        <?= $searchModel->getDeactiveButton() ?>

        <?= $searchModel->getActiveButton() ?>

        <?= $searchModel->getResetButton() ?>

        <?= $searchModel->getDeleteButton() ?>

        <?= $searchModel->getUpdateButton() ?>

        <?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>

<div class="menu-types-index">

    <?php if(Yii::$app->getModule('menu')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjaxSettings'=>[
                'neverTimeout'=>true,
            ],
            'columns' => [
                [
                    'class' => '\kartik\grid\CheckboxColumn'
                ],
                [
                    'attribute' => 'menutype',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($model) {
                        $url = urldecode(Url::toRoute(['/menu/types/update', 'id' => $model->id]));
                        return Html::a($model->menutype,$url);
                    }
                ],
                [
                    'attribute' => 'title',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'description',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'id',
                    'width' => '5%',
                    'hAlign' => 'center',
                ],
            ],
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'heading'    => '<h3 class="panel-title"><i class="fa fa-sitemap"></i></h3>',
                'type'       => 'success',
                'showFooter' => false
            ],
        ]); ?>

    <?php Pjax::end(); ?>

</div>
