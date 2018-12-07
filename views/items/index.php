<?php

/**
 * @var \cinghie\menu\models\Items $model
 * @var \cinghie\menu\models\ItemsSearch $searchModel
 */

use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('menu', 'Menu Items');
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

<div class="menu-items-index">

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
				'attribute' => 'title',
				'format' => 'html',
				'hAlign' => 'center',
				'value' => function ($model) {
					$url = urldecode(Url::toRoute(['/menu/items/update', 'id' => $model->id]));
					return Html::a($model->title,$url);
				}
			],
			[
				'attribute' => 'parent_id',
				'format' => 'html',
				'hAlign' => 'center',
				'value' => function ($model) {
					/** @var $model cinghie\menu\models\Items */
					return $model->getParentGridView('title','/menu/items/update', 1);
				},
				'width' => '10%',
			],
			[
				'attribute' => 'link',
				'hAlign' => 'center',
				'width' => '20%',
			],
			[
				'attribute' => 'alias',
				'hAlign' => 'center',
			],
			[
				'attribute' => 'menutype_id',
				'format' => 'html',
				'hAlign' => 'center',
				'value' => function ($model) {
					$url = urldecode(Url::toRoute(['types/update', 'id' => $model->menutype_id]));
					return Html::a($model->menutype->title,$url);
				},
				'width' => '10%',
			],
			[
				'attribute' => 'access',
				'format' => 'html',
				'hAlign' => 'center',
				'value' => function ($model) {
					/** @var $model cinghie\menu\models\Items */
					return $model->getAccessGridView();
				}
			],
			[
				'attribute' => 'theme',
				'hAlign' => 'center',
				'value' => function ($model) {
					/** @var $model cinghie\menu\models\Items */
					if($model->theme) {
						return Yii::t('traits',ucwords($model->theme));
                    }
				}
			],
			[
				'attribute' => 'language',
				'width' => '5%',
				'hAlign' => 'center',
			],
			[
				'attribute' => 'state',
				'format' => 'raw',
				'hAlign' => 'center',
				'width' => '5%',
				'value' => function ($model) {
					/** @var $model cinghie\menu\models\Items */
					return $model->getStateGridView();
				}
			],
			[
				'attribute' => 'id',
				'width' => '4%',
				'hAlign' => 'center',
			],
		],
		'responsive' => true,
		'responsiveWrap' => true,
		'hover' => true,
		'panel' => [
			'heading'    => '<h3 class="panel-title"><i class="fa fa-list"></i></h3>',
			'type'       => 'success',
			'showFooter' => false
		],
	]) ?>

</div>
