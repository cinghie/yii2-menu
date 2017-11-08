<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.3
 */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('menu', 'Menu Items');
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

<div class="menu-items-index">

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
                    'attribute' => 'title',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($model) {
                        $url = urldecode(Url::toRoute(['/menu/items/update', 'id' => $model->id]));
                        return Html::a($model->title,$url);
                    }
                ],
                [
                    'attribute' => 'link',
                    'hAlign' => 'center',
                    'width' => '20%',
                ],
                [
                    'attribute' => 'alias',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'menutype_id',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($model) {
                        $url = urldecode(Url::toRoute(['types/update', 'id' => $model->menutype_id]));
                        return Html::a($model->menutype->title,$url);
                    },
                    'width' => '10%',
                ],
                [
                    'attribute' => 'parent_id',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($model) {
	                    /** @var $model cinghie\menu\models\Items */
	                    return $model->getParentGridView('title','/menu/items/update', 1);
                    },
                    'width' => '10%',
                ],
                [
                    'attribute' => 'access',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($model) {
                        /** @var $model cinghie\menu\models\Items */
                        return $model->getAccessGridView();
                    }
                ],
                [
                    'attribute' => 'language',
                    'width' => '5%',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'state',
                    'format' => 'raw',
                    'hAlign' => 'center',
                    'width' => '5%',
                    'value' => function ($model) {
                        /** @var $model cinghie\menu\models\Items */
                        return $model->getStateGridView();
                    }
                ],
                [
                    'attribute' => 'id',
                    'width' => '4%',
                    'hAlign' => 'center',
                ],
            ],
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'heading'    => '<h3 class="panel-title"><i class="fa fa-list"></i></h3>',
                'type'       => 'success',
                'showFooter' => false
            ],
        ]); ?>

    <?php Pjax::end(); ?>

</div>
