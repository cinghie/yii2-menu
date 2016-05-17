<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.8.0
 */

namespace cinghie\menu\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Types]].
 *
 * @see Types
 */
class TypesQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Types[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Types|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
