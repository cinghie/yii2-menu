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

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="menu-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-lg-12">

            <div class="col-lg-6">

                <?= $form->field($model, 'menutype', [
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-plus"></i>'
                        ]
                    ],
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'title', [
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-pencil"></i>'
                        ]
                    ]
                ])->textInput(['maxlength' => true]) ?>

            </div>

            <div class="col-lg-6">

                <?= $form->field($model, 'description')->textArea(['maxlength' => true, 'rows' => '4']) ?>

            </div>

            <div class="col-lg-12">

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('menu', 'Create') : Yii::t('menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
