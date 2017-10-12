<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.1
 */

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;

?>

<div class="menu-items-form">

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

                <div class="col-lg-4">

                    <?= $model->getTitleWidget($form) ?>

                    <?= $form->field($model, 'menutypeid')->widget(Select2::classname(), [
                        'data' => $model->getTypesSelect2(),
                        'addon' => [
                            'prepend' => [
                                'content'=>'<i class="fa fa-list"></i>'
                            ]
                        ],
                    ]); ?>

                    <?= $form->field($model, 'link', [
                        'addon' => [
                            'prepend' => [
                                'content'=>'<i class="glyphicon glyphicon-link"></i>'
                            ]
                        ]
                    ])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'linkOptions', [
	                    'addon' => [
		                    'prepend' => [
			                    'content'=>'<i class="fa fa-external-link-square"></i>'
		                    ]
	                    ],
                    ])->textarea(['rows' => 4]) ?>

                </div>

                <div class="col-lg-4">

                    <?= $model->getAliasWidget($form) ?>

                    <?= $form->field($model, 'parentid')->widget(Select2::classname(), [
                        'data' => $model->getItemsSelect2(),
                        'addon' => [
                            'prepend' => [
                                'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
                            ]
                        ],
                    ]); ?>

                    <?= $form->field($model, 'class', [
	                    'addon' => [
		                    'prepend' => [
			                    'content'=>'<i class="fa fa-css3"></i>'
		                    ]
	                    ]
                    ])->textInput(['maxlength' => true]) ?>

                </div>

                <div class="col-lg-4">

                    <?= $model->getStateWidget($form) ?>

                    <?= $model->getAccessWidget($form) ?>

                    <?= $model->getLanguageWidget($form) ?>

                </div>

            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
