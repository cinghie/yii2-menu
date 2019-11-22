<?php

/**
 * @var Types $model
 */

use cinghie\menu\models\Types;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

?>

<div class="menu-types-form">

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

                    <div class="separator"></div>

                </div>

                <div class="row">

                    <div class="col-lg-6">

                        <?= $model->getTitleWidget($form) ?>

                        <div class="row">

                            <div class="col-lg-6">

	                            <?= $form->field($model, 'menutype', [
		                            'addon' => [
			                            'prepend' => [
				                            'content'=>'<i class="glyphicon glyphicon-plus"></i>'
			                            ]
		                            ],
	                            ])->textInput(['maxlength' => true]) ?>

                            </div>

                            <div class="col-lg-6">

	                            <?= $form->field($model, 'theme')->widget(Select2::class, [
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

                    <div class="col-lg-6">

                        <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => '5']) ?>

                    </div>

                </div>

            </div>

        </div>

    <?php ActiveForm::end() ?>

</div>
