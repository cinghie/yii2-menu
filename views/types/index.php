<?php

/**
 * @var Types $model
 * @var TypesSearch $searchModel
 */

use cinghie\menu\models\Types;
use cinghie\menu\models\TypesSearch;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('menu', 'Menu Types');
$this->params['breadcrumbs'][] = $this->title;

// Register action buttons js
$this->registerJs('$(document).ready(function()
    {'
    .$searchModel->getUpdateButtonJavascript('#w1')
    .$searchModel->getDeleteButtonJavascript('#w1')
    .$searchModel->getActiveButtonJavascript('#w1')
    .$searchModel->getDeactiveButtonJavascript('#w1').
    '});
');

?>

<div class="row">

    <!-- action menu -->
    <div class="col-md-6">

        <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-menu/views/default/_menu.php') ?>

    </div>

    <!-- action buttons -->
    <div class="col-md-6">

        <?= $searchModel->getDeactiveButton() ?>

        <?= $searchModel->getActiveButton() ?>

        <?= $searchModel->getResetButton() ?>

        <?= $searchModel->getDeleteButton() ?>

        <?= $searchModel->getUpdateButton() ?>

        <?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>

<div class="menu-types-index">

    <?php if(Yii::$app->getModule('menu')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]) ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'pjax' => true,
		'pjaxSettings'=>[
			'neverTimeout'=>true,
		],
		'columns' => [
			[
				'class' => CheckboxColumn::class
			],
			[
				'attribute' => 'menutype',
				'format' => 'html',
				'hAlign' => 'center',
				'value' => function ($model) {
					$url = urldecode(Url::toRoute(['/menu/types/update', 'id' => $model->id]));
					return Html::a($model->menutype,$url);
				}
			],
			[
				'attribute' => 'title',
				'hAlign' => 'center',
			],
			[
				'attribute' => 'theme',
				'hAlign' => 'center',
				'value' => function ($model) {
					return Yii::t('traits',ucwords($model->theme));
				}
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
		'responsiveWrap' => true,
		'hover' => true,
		'panel' => [
			'heading'    => '<h3 class="panel-title"><i class="fa fa-sitemap"></i></h3>',
			'type'       => 'success',
			'showFooter' => false
		],
	]) ?>

</div>
