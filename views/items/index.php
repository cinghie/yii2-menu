<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.8.0
 */

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-menu/views/default/_menu_items.php');

$this->title = Yii::t('menu', 'Menu Items');
$this->params['breadcrumbs'][] = $this->title;

// Register action buttons js
$this->registerJs('
    $(document).ready(function()
    {
        $("a.btn-update").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("essentials", "Select at least one item").'");
            } else if(selectedId.length>1){
                alert("'.Yii::t("essentials", "Select only 1 item").'");
            } else {
                var url = "'.Url::to(['items/update']).'?id="+selectedId[0];
                window.location.href= url;
            }
        });
        $("a.btn-active").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("essentials", "Select at least one item").'");
            } else {
                $.ajax({
                    type: \'POST\',
                    url : "'.Url::to(['items/activemultiple']).'?id="+selectedId,
                    data : {ids: selectedId},
                    success : function() {
                        $.pjax.reload({container:"#w2"});
                    }
                });
            }
        });
        $("a.btn-deactive").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("essentials", "Select at least one item").'");
            } else {
                $.ajax({
                    type: \'POST\',
                    url : "'.Url::to(['items/deactivemultiple']).'?id="+selectedId,
                    data : {ids: selectedId},
                    success : function() {
                        $.pjax.reload({container:"#w2"});
                    }
                });
            }
        });
        $("a.btn-delete").click(function() {
            var selectedId = $("#w2").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("essentials", "Select at least one item").'");
            } else {
                var choose = confirm("'.Yii::t("essentials", "Do you want delete selected items?").'");

                if (choose == true) {
                    $.ajax({
                        type: \'POST\',
                        url : "'.Url::to(['items/deletemultiple']).'?id="+selectedId,
                        data : {ids: selectedId},
                        success : function() {
                            $.pjax.reload({container:"#w2"});
                        }
                    });
                }
            }
        });
    });
');

?>
<div class="menu-items-index">

    <?php if(Yii::$app->getModule('essentials')->showTitles): ?>
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
                        $url = urldecode(Url::toRoute(['items/update', 'id' => $model->id]));
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
                /*
                [
                    'attribute' => 'params',
                    'hAlign' => 'center',
                ],*/
                [
                    'attribute' => 'menutypeid',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($data) {
                        $url = urldecode(Url::toRoute(['types/update', 'id' => $data->menutypeid]));

                        return Html::a($data->menutype->title,$url);
                    },
                    'width' => '10%',
                ],
                [
                    'attribute' => 'parentid',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($data) {
                        $url = urldecode(Url::toRoute(['items/update', 'id' => $data->parentid]));
                        $mid = isset($data->parentid) ? $data->parentid : "";

                        if($mid!="") {
                            return Html::a($data->parent->title,$url);
                        } else {
                            return Yii::t('articles', 'Nobody');
                        }
                    },
                    'width' => '10%',
                ],
                [
                    'attribute' => 'access',
                    'width' => '8%',
                    'hAlign' => 'center',
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
                    'width' => '4%',
                    'value' => function ($model) {
                        if($model->state) {
                            return Html::a('<span class="glyphicon glyphicon-ok text-success"></span>', ['changestate', 'id' => $model->id], [
                                'data-method' => 'post',
                            ]);
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-remove text-danger"></span>', ['changestate', 'id' => $model->id], [
                                'data-method' => 'post',
                            ]);
                        }
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
                'before'     => '<span style="margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('menu', 'New'),
                        ['create'], ['class' => 'btn btn-success']
                    ).'</span><span style="margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-pencil"></i> '.Yii::t('menu', 'Update'),
                        '#', ['class' => 'btn btn-update btn-warning']
                    ).'</span><span style="margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-minus-sign"></i> '.Yii::t('menu', 'Delete'),
                        '#', ['class' => 'btn btn-delete btn-danger']
                    ).'</span><span style="float: right; margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-remove"></i> '.Yii::t('menu', 'Deactive'),
                        '#', ['class' => 'btn btn-deactive btn-danger']
                    ).'</span><span style="float: right; margin-right: 5px;">'.
                    Html::a('<i class="glyphicon glyphicon-ok"></i> '.Yii::t('menu', 'Active'),
                        ['#'], ['class' => 'btn btn-active btn-success']
                    ).'</span>',
                'after' => Html::a(
                    '<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('menu', 'Reset Grid'), ['index'], ['class' => 'btn btn-info']
                ),
                'showFooter' => false
            ],
        ]); ?>

    <?php Pjax::end(); ?>

</div>
