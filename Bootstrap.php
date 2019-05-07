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
use cinghie\menu\models\Types;
use cinghie\menu\models\Items;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\db\ActiveRecord;

/**
 * Bootstrap class
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @var array
     */
    private $_modelMap = [
        'Items' => Items::class,
        'Types' => Types::class,
    ];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        /**
         * @var Module $module
         * @var ActiveRecord $modelName
         */
        if ($app->hasModule('menu') && ($module = $app->getModule('menu')) instanceof Module)
        {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);

            foreach ($this->_modelMap as $name => $definition)
            {
                $class = "cinghie\\menu\\models\\" . $name;

                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;

                if (in_array($name,['Items','Types']))
                {
                    Yii::$container->set($name . 'Query', function () use ($modelName) {
                        return $modelName::find();
                    });
                }
            }
        }
    }
}
