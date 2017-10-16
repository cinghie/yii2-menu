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
use cinghie\traits\ParentTrait;
use cinghie\traits\StateTrait;
use cinghie\traits\TitleAliasTrait;
use cinghie\traits\UserHelpersTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property integer $menutype_id
 * @property integer $parent_id
 * @property string $title
 * @property string $alias
 * @property integer $state
 * @property string $access
 * @property string $link
 * @property string $language
 * @property string $class
 * @property string $linkOptions | example: [{"data-method":"post"}]
 * @property string $params | example: [{"id":"1","alias":"my-alias"}]
 *
 * @property Types $menutype
 */
class Items extends ActiveRecord
{

    use AccessTrait, LanguageTrait, ParentTrait, TitleAliasTrait, StateTrait, UserHelpersTrait, ViewsHelpersTrait;

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
            [['menutype_id', 'parent_id', 'title', 'language', 'link', 'state'], 'required'],
            [['menutype_id'], 'integer'],
            [['class'], 'string', 'max' => 24],
            [['link'], 'string', 'max' => 1024],
	        [['params','linkOptions'], 'string'],
            [['menutype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Types::className(), 'targetAttribute' => ['menutype_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
	        'id' => Yii::t('menu', 'ID'),
	        'menutype_id' => Yii::t('menu', 'Menutypeid'),
	        'parent_id' => Yii::t('traits', 'Parentid'),
	        'title' => Yii::t('traits', 'Title'),
	        'alias' => Yii::t('traits', 'Alias'),
	        'state' => Yii::t('traits', 'State'),
	        'access' => Yii::t('traits', 'Access'),
	        'language' => Yii::t('traits', 'Language'),
	        'class' => Yii::t('menu', 'Class'),
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

        foreach($menuItems as $menuItem)
        {
        	if($menuItem['id'] != $this->id) {
		        $array[$menuItem['id']] = ucwords($menuItem['title']);
	        }
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
        return $this->hasOne(Types::className(), ['id' => 'menutype_id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(Items::className(), ['id' => 'parent_id']);
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getChilds()
	{
		return $this->hasMany(Items::className(), ['parent_id' => 'id']);
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
