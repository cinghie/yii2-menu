<?php

/**
 * @var \cinghie\menu\models\Items $model
 */

use yii\helpers\Html;

$this->title = Yii::t('menu', 'Update Menu Items: ', [
    'modelClass' => 'Menu Items',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('menu', 'Update');
?>

<div class="menu-items-update">

    <?php if(Yii::$app->getModule('menu')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
