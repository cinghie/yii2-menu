<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.3
 */

namespace cinghie\menu;

use Yii;

class Menu extends \yii\base\Module
{
    // Controller Namespace
    public $controllerNamespace = 'cinghie\menu\controllers';

    // Menu Rules
    public $menuRoles = ['admin'];

    // Show Titles in the views
    public $showTitles = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Translating module message
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['menu*']))
        {
            Yii::$app->i18n->translations['menu*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }

}
