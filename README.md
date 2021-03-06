Yii2 Menù
=============

![License](https://img.shields.io/packagist/l/cinghie/yii2-menu.svg)
![Latest Stable Version](https://img.shields.io/github/release/cinghie/yii2-menu.svg)
![Latest Release Date](https://img.shields.io/github/release-date/cinghie/yii2-menu.svg)
![Latest Commit](https://img.shields.io/github/last-commit/cinghie/yii2-menu.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/cinghie/yii2-menu.svg)](https://packagist.org/packages/cinghie/yii2-menu)

Yii2 Menu to create, manage, and delete menù in a Yii2 site

Installation
--------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require cinghie/yii2-menu "*"
```

or add

```
"cinghie/yii2-menu": "*"
```

Configuration
--------------

### 1. Update yii2 menu database schema

Make sure that you have properly configured `db` application component and run the following command:
```
$ php yii migrate/up --migrationPath=@vendor/cinghie/yii2-menu/migrations
```

### 2. Install Yii2 Multilanguage

https://github.com/cinghie/yii2-multilanguage

### 3. Set configuration file

Set on your configuration file

```
'modules' => [ 

	// Yii2 Menu
	'menu' => [
		'class' => 'cinghie\menu\Menu',
		'menuRoles' => ['admin'],
	],
	
]	
```

## Overrides

Override controller example, on modules config

```
'modules' => [ 

	'menu' => [
		'class' => 'cinghie\menu\Menu',
		'controllerMap' => [
			'items' => 'app\controllers\ItemsController',
			'types' => 'app\controllers\TypesController',
		]
	]
	
],
```

Override models example, on modules config

```
'modules' => [ 

	'menu' => [
		'class' => 'cinghie\menu\Menu',
		'modelMap' => [
			'Items' => 'app\models\menu\Items',
			'Types' => 'app\models\menu\Types',
		]
	]
	
],
```

Override view example, on components config

```
'components' => [ 

	'view' => [
		'theme' => [
			'pathMap' => [
				'@cinghie/menu/views/items' => '@app/views/menu/items',
				'@cinghie/menu/views/types' => '@app/views/menu/types',
			],
		],
	],
	
],
```

URLS
--------------
<ul> 
  <li>Menù Types: PathToApp/index.php?r=menu/types/index</li>
  <li>Menù Types with Pretty Urls: PathToApp/menu/types/index</li>
  <li>Menù Items: PathToApp/index.php?r=menu/items/index</li>
  <li>Menù Items with Pretty Urls: PathToApp/menu/items/index</li>
</ul>
