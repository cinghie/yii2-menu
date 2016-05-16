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
use kartik\widgets\Select2;
use yii\helpers\Html;

?>

<div class="menu-items-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-lg-12">

            <div class="col-lg-4">

                <?= $form->field($model, 'title', [
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-plus"></i>'
                        ]
                    ]
                ])->textInput(['maxlength' => true]) ?>

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

                <?= $form->field($model, 'language')->widget(Select2::classname(), [
                    'data' => $model->getLanguages(),
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-globe"></i>'
                        ]
                    ],
                ]); ?>

            </div>

            <div class="col-lg-4">

                <?= $form->field($model, 'alias', [
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-bookmark"></i>'
                        ]
                    ]
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'parentid')->widget(Select2::classname(), [
                    'data' => $model->getItemsSelect2(),
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-folder-open"></i>'
                        ]
                    ],
                ]); ?>

                <?= $form->field($model, 'params', [
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="fa fa-filter"></i>'
                        ]
                    ]
                ])->textarea(['rows' => 4]) ?>

            </div>

            <div class="col-lg-4">

                <?= $form->field($model, 'state')->widget(Select2::classname(), [
                    'data' => $model->getStates(),
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-check"></i>'
                        ]
                    ],
                ]); ?>

                <?= $form->field($model, 'access')->widget(Select2::classname(), [
                    'data' => $model->getRoles(),
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="glyphicon glyphicon-log-in"></i>'
                        ]
                    ],
                ]); ?>

                <?= $form->field($model, 'linkOptions', [
                    'addon' => [
                        'prepend' => [
                            'content'=>'<i class="fa fa-external-link-square"></i>'
                        ]
                    ],
                ])->textarea(['rows' => 4]) ?>

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
