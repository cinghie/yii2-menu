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

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="menu-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-lg-12">

            <div class="row">

                <div class="col-md-6">

                    <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-menu/views/default/_menu.php') ?>

                </div>

                <div class="col-md-6">

                    <?= $model->getExitButton() ?>

                    <?= $model->getCancelButton() ?>

                    <?= $model->getSaveButton() ?>

                </div>

                <div class="separator"></div>

            </div>

            <div class="row">

                <div class="col-lg-6">

                    <?= $model->getTitleWidget($form) ?>

                    <?= $form->field($model, 'menutype', [
                        'addon' => [
                            'prepend' => [
                                'content'=>'<i class="glyphicon glyphicon-plus"></i>'
                            ]
                        ],
                    ])->textInput(['maxlength' => true]) ?>

                </div>

                <div class="col-lg-6">

                    <?= $form->field($model, 'description')->textArea(['maxlength' => true, 'rows' => '4']) ?>

                </div>

            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
