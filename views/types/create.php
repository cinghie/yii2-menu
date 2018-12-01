<?php

/**
 * @var \cinghie\menu\models\Types $model
 */

use yii\helpers\Html;

$this->title = Yii::t('menu', 'Create Menu Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-types-create">

    <?php if(Yii::$app->getModule('menu')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
