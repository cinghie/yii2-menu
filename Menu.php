<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.5
 */

namespace cinghie\menu;

use Yii;
use yii\base\Module;
use yii\i18n\PhpMessageSource;

/**
 * Class Menu
 */
class Menu extends Module
{
    // Menu Rules
    public $menuRoles = ['admin'];
    
    // Slugify Options
    public $slugifyOptions = [
        'separator' => '-',
        'lowercase' => true,
        'trim' => true,
        'rulesets'  => [
            'default'
        ]
    ];

    // Show Titles in the views
    public $showTitles = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
	    $this->registerTranslations();

        parent::init();
    }

    /**
     * Translating module message
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['menu*']))
        {
            Yii::$app->i18n->translations['menu*'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
