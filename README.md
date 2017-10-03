Yii2 Menù
=============

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

URL
--------------
<ul> 
  <li>Menù Types: PathToApp/index.php?r=menu/types/index</li>
  <li>Menù Types with Pretty Urls: PathToApp/menu/types/index</li>
  <li>Menù Items: PathToApp/index.php?r=menu/items/index</li>
  <li>Menù Items with Pretty Urls: PathToApp/menu/items/index</li>
</ul>

Changelog
--------------

<ul>
  <li>Version 0.8.1 - Purge code</li>
  <li>Version 0.8.0 - Initial Releases</li>
</ul>

Libraries Needed
--------------

<ul> 
  <li>Yii2 Grid: https://github.com/kartik-v/yii2-grid</li>
  <li>Yii2 Multilanguage: https://github.com/cinghie/yii2-multilanguage</li>
  <li>Yii2 Widgets: https://github.com/kartik-v/yii2-widgets</li>
</ul>
