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
 * @property string $icon | example: fa fa-bars
 * @property integer $icon_type | 0 as Only Text, 1 as Icon + Text, 2 as Text + Icon, 3 Only Icon
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
            [['menutype_id','icon_type'], 'integer'],
            [['class'], 'string', 'max' => 24],
            [['icon'], 'string', 'max' => 32],
            [['link'], 'string', 'max' => 1024],
	        [['params','linkOptions'], 'string'],
            [['menutype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Types::class, 'targetAttribute' => ['menutype_id' => 'id']],
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
	        'icon' => Yii::t('traits', 'Icon'),
	        'icon_type' => Yii::t('menu', 'Icon Type'),
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
		return $this->hasOne(Types::class, ['id' => 'menutype_id']);
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
	 * @return string
	 */
	public function getMenuLabel()
	{
		if($this->icon_type === 1  && $this->icon !== null) {
			return '<i class="fa '.$this->icon.'" aria-hidden="true"></i> '.$this->title;
		}

		if($this->icon_type === 2  && $this->icon !== null) {
			return $this->title.' <i class="fa '.$this->icon.'" aria-hidden="true"></i>';
		}

		if($this->icon_type === 3  && $this->icon !== null) {
			return '<i class="fa '.$this->icon.'" aria-hidden="true"></i>';
		}

		return $this->title;
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
	        if((int)$menuItem['id'] === 1) {
		        $array[$menuItem['id']] = Yii::t('menu','Main Item');
	        } elseif($menuItem['id'] !== $this->id) {
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
