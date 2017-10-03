<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-menu
* @version 0.8.1
*/

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
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
]) ?>
