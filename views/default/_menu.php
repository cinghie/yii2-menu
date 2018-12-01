<?php

use yii\bootstrap\Nav;

echo Nav::widget([
	'options' => [
		'class' => 'nav-tabs',
		'style' => 'margin-bottom: 15px',
	],
	'items' => [
		[
			'label'   => Yii::t('menu', 'Menu Items'),
			'url'     => ['/menu/items/index'],
		],
		[
			'label'   => Yii::t('menu', 'Menu Types'),
			'url'     => ['/menu/types/index'],
		],
	],
]);
