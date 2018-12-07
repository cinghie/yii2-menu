<?php

/**
 * @var \cinghie\menu\models\Items $model
 */

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use cinghie\iconpicker\Iconpicker;

?>

<div class="menu-items-form">

    <?php $form = ActiveForm::begin() ?>

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

                </div>

                <div class="separator"></div>

                <div class="row">

                    <div class="col-lg-4">

	                    <?= $model->getTitleWidget($form) ?>

                    </div>

                    <div class="col-lg-4">

                        <div class="row">

                            <div class="col-lg-6">

	                            <?= $model->getParentWidget($form,$model->getItemsSelect2()) ?>

                            </div>

                            <div class="col-lg-6">

	                            <?= $form->field($model, 'theme')->widget(Select2::className(), [
		                            'data' => $model->getThemeSelect2(),
		                            'addon' => [
			                            'prepend' => [
				                            'content'=>'<i class="glyphicon glyphicon-blackboard"></i>'
			                            ]
		                            ]
	                            ]) ?>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="row">

                            <div class="col-lg-6">

	                            <?= $form->field($model, 'menutype_id')->widget(Select2::className(), [
		                            'data' => $model->getTypesSelect2(),
		                            'addon' => [
			                            'prepend' => [
				                            'content'=>'<i class="fa fa-list"></i>'
			                            ]
		                            ]
	                            ]) ?>

                            </div>

                            <div class="col-lg-6">

	                            <?= $model->getStateWidget($form) ?>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-4">

	                    <?= $model->getAliasWidget($form) ?>

                    </div>

                    <div class="col-lg-4">

                        <div class="row">

                            <div class="col-lg-6">

			                    <?= $model->getAccessWidget($form) ?>

                            </div>

                            <div class="col-lg-6">

			                    <?= $model->getLanguageWidget($form) ?>

                            </div>

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="row">

                            <div class="col-lg-2">

			                    <?= $form->field($model, 'icon')->widget(Iconpicker::class, [
				                    'iconset' => 'fontawesome',
				                    'clientOptions' => [
					                    'rows' => 12,
					                    'cols' => 12,
					                    'placement' => 'left'
				                    ]
			                    ]) ?>

                            </div>

                            <div class="col-lg-4">

		                        <?= $form->field($model, 'icon_type')->widget(Select2::className(), [
			                        'data' => [
			                            0 => Yii::t('menu','Only Text'),
			                            1 => Yii::t('menu','Icon + Text'),
			                            2 => Yii::t('menu','Text + Icon'),
			                            3 => Yii::t('menu','Only Icon')
                                    ]
		                        ])  ?>

                            </div>

                            <div class="col-lg-6">

			                    <?= $form->field($model, 'class', [
				                    'addon' => [
					                    'prepend' => [
						                    'content'=>'<i class="fa fa-css3"></i>'
					                    ]
				                    ]
			                    ])->textInput(['maxlength' => true]) ?>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-4">

                        <?= $form->field($model, 'link', [
	                        'addon' => [
		                        'prepend' => [
			                        'content'=>'<i class="glyphicon glyphicon-link"></i>'
		                        ]
	                        ]
                        ])->textInput(['maxlength' => true]) ?>

                    </div>

                    <div class="col-lg-4">

                        <?= $form->field($model, 'linkOptions', [
                            'addon' => [
                                'prepend' => [
                                    'content'=>'<i class="fa fa-external-link-square"></i>'
                                ]
                            ],
                        ])->textarea(['rows' => 4]) ?>

                        <div class="alert alert-info">
                            <?= Yii::t('traits','Example') ?>: [{"data-method":"post"}]
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <?= $form->field($model, 'params', [
                            'addon' => [
                                'prepend' => [
                                    'content'=>'<i class="fa fa-filter"></i>'
                                ]
                            ]
                        ])->textarea(['rows' => 4]) ?>

                        <div class="alert alert-info">
		                    <?= Yii::t('traits','Example') ?>: [{"id":"1","alias":"my-alias","cat":"mycategory"}]
                        </div>

                    </div>

                </div>

            </div>

        </div>

    <?php ActiveForm::end() ?>

</div>
