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

/**
 * This is the ActiveQuery class for [[Items]].
 *
 * @see Items
 */
class ItemsQuery extends \yii\db\ActiveQuery
{

    /**
 * @inheritdoc
 * @return Items[]|array
 */
    public function active()
    {
        $this->andWhere('[[id]]!=1');
        $this->andWhere('[[state]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Items[]|array
     */
    public function inactive()
    {
        $this->andWhere('[[id]]!=1');
        $this->andWhere('[[state]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Items[]|array
     */
    public function findByMenuType($id)
    {
        $this->andWhere('[[id]]!=1');
        $this->andWhere(['state' => 1]);
        $this->andWhere(['menutypeid' => $id]);
        $this->andWhere(['parentid' => 1]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return Items[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Items|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
