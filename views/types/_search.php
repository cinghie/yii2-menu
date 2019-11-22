<?php

/**
 * @var Types $model
 */

use cinghie\menu\models\Types;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="menu-types-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]) ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'menutype') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('traits', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('traits', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
