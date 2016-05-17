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

use Yii;

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
class Items extends Menu
{
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
            [['menutypeid', 'parentid', 'state'], 'integer'],
            [['link'], 'string', 'max' => 1024],
            [['title', 'alias'], 'string', 'max' => 255],
            [['access'], 'string', 'max' => 64],
            [['language'], 'string', 'max' => 7],
            [['params','linkOptions'], 'string'],
            [['alias'], 'unique'],
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
            'title' => Yii::t('menu', 'Title'),
            'alias' => Yii::t('menu', 'Alias'),
            'parentid' => Yii::t('menu', 'Parentid'),
            'state' => Yii::t('menu', 'State'),
            'access' => Yii::t('menu', 'Access'),
            'language' => Yii::t('menu', 'Language'),
            'link' => Yii::t('menu', 'Link'),
            'linkOptions' => Yii::t('menu', 'Link Options'),
            'params' => Yii::t('menu', 'Params'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
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
     * @return \yii\db\ActiveQuery
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
