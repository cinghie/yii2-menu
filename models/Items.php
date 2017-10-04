<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.1
 */

namespace cinghie\menu\models;

use Yii;
use cinghie\traits\AccessTrait;
use cinghie\traits\LanguageTrait;
use cinghie\traits\StateTrait;
use cinghie\traits\TitleAliasTrait;
use cinghie\traits\UserHelpersTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property integer $menutypeid
 * @property string $title
 * @property string $alias
 * @property integer $parentid
 * @property integer $state
 * @property string $access
 * @property string $link
 * @property string $language
 * @property string $linkOptions | example [{"data-method":"post"}]
 * @property string $params | example [{"id":"1","alias":"my-alias"}]
 *
 * @property Types $menutype
 */
class Items extends ActiveRecord
{

    use AccessTrait, LanguageTrait, TitleAliasTrait, StateTrait, UserHelpersTrait, ViewsHelpersTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menutypeid', 'title', 'language', 'link'], 'required'],
            [['menutypeid', 'parentid'], 'integer'],
            [['link'], 'string', 'max' => 1024],
            [['params','linkOptions'], 'string'],
            [['menutypeid'], 'exist', 'skipOnError' => true, 'targetClass' => Types::className(), 'targetAttribute' => ['menutypeid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('menu', 'ID'),
            'menutypeid' => Yii::t('menu', 'Menutypeid'),
            'parentid' => Yii::t('menu', 'Parentid'),
            'link' => Yii::t('menu', 'Link'),
            'linkOptions' => Yii::t('menu', 'Link Options'),
            'params' => Yii::t('menu', 'Params'),
        ];
    }

    /**
     * Return Types Select2
     *
     * @return array[]
     */
    public function getTypesSelect2()
    {
        $menuTypes = $this->getTypes();
        $array = array();

        foreach($menuTypes as $menuType) {
            $array[$menuType['id']] = ucwords($menuType['title']);
        }

        return $array;
    }

    /**
     * Return Items Select2
     *
     * @return array[]
     */
    public function getItemsSelect2()
    {
        $menuItems = $this->getMenuitems();
        $array = array();

        foreach($menuItems as $menuItem) {
            $array[$menuItem['id']] = ucwords($menuItem['title']);
        }

        return $array;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return Types::find()->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuitems()
    {
        return Items::find()->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenutype()
    {
        return $this->hasOne(Types::className(), ['id' => 'menutypeid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Items::className(), ['id' => 'parentid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return $this->hasMany(Items::className(), ['parentid' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemsQuery(get_called_class());
    }

}
