<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.9.4
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
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property integer $menutype_id
 * @property string $link
 * @property string $class
 * @property string $linkOptions | example: [{"data-method":"post"}]
 * @property string $params | example: [{"id":"1","alias":"my-alias"}]
 *
 * @property ActiveQuery $menuitems
 * @property ActiveQuery $types
 * @property Types $menutype
 * @property array[] $itemsSelect2
 * @property array[] $typesSelect2
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
        return array_merge(AccessTrait::rules(), LanguageTrait::rules(), ParentTrait::rules(), TitleAliasTrait::rules(), StateTrait::rules(), [
            [['menutype_id', 'parent_id', 'title', 'access', 'language', 'link', 'state'], 'required'],
            [['menutype_id'], 'integer'],
            [['class'], 'string', 'max' => 24],
            [['link'], 'string', 'max' => 1024],
	        [['params','linkOptions'], 'string'],
            [['menutype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Types::className(), 'targetAttribute' => ['menutype_id' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(AccessTrait::attributeLabels(), LanguageTrait::attributeLabels(), ParentTrait::attributeLabels(), TitleAliasTrait::attributeLabels(), StateTrait::attributeLabels(), [
	        'id' => Yii::t('traits', 'ID'),
	        'menutype_id' => Yii::t('menu', 'Menutypeid'),
	        'class' => Yii::t('menu', 'Link Class'),
	        'link' => Yii::t('traits', 'Link'),
	        'linkOptions' => Yii::t('menu', 'Link Options'),
	        'params' => Yii::t('traits', 'Params'),
        ]);
    }

	/**
	 * @return ActiveQuery
	 */
	public function getMenutype()
	{
		return $this->hasOne(Types::className(), ['id' => 'menutype_id']);
	}

	/**
	 * @return ActiveQuery
	 */
	public function getTypes()
	{
		return Types::find()->asArray()->all();
	}

	/**
	 * @return ActiveQuery
	 */
	public function getMenuitems()
	{
		return self::find()->asArray()->all();
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

	    /** @var array $menuTypes */
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

	    /** @var array $menuItems */
	    foreach($menuItems as $menuItem)
        {
        	if($menuItem['id'] !== $this->id) {
		        $array[$menuItem['id']] = ucwords($menuItem['title']);
	        }
        }

        return $array;
    }

    /**
     * @inheritdoc
     *
     * @return ItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemsQuery(static::class);
    }

}
