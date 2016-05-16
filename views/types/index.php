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

$this->title = Yii::t('menu', 'Menu Types');
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
                var url = "'.Url::to(['types/update']).'?id="+selectedId[0];
                window.location.href= url;
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
                        url : "'.Url::to(['types/deletemultiple']).'?id="+selectedId,
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
<div class="menu-types-index">

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
                    'attribute' => 'menutype',
                    'format' => 'html',
                    'hAlign' => 'center',
                    'value' => function ($model) {
                        $url = urldecode(Url::toRoute(['types/update', 'id' => $model->id]));
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
                    ).'</span>',
                'after' => Html::a(
                    '<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('menu', 'Reset Grid'), ['index'], ['class' => 'btn btn-info']
                ),
                'showFooter' => false
            ],
        ]); ?>

    <?php Pjax::end(); ?>

</div>
