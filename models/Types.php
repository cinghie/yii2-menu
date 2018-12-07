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
use cinghie\traits\StateTrait;
use cinghie\traits\TitleAliasTrait;
use cinghie\traits\UserHelpersTrait;
use cinghie\traits\ViewsHelpersTrait;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu_types}}".
 *
 * @property string $id
 * @property string $menutype
 * @property string $description
 */
class Types extends ActiveRecord
{

    use TitleAliasTrait, StateTrait, UserHelpersTrait, ViewsHelpersTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menutype', 'title'], 'required'],
            [['menutype','theme'], 'string', 'max' => 24],
            [['title'], 'string', 'max' => 48],
            [['description'], 'string', 'max' => 255],
            [['menutype'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('traits', 'ID'),
            'menutype' => Yii::t('menu', 'Menutype'),
            'description' => Yii::t('traits', 'Description'),
            'theme' => Yii::t('traits', 'Theme'),
        ];
    }

	/**
	 * @return string
	 */
	public function getThemeClass()
    {
    	switch($this->theme)
	    {
		    case 'vertical':
		    	return 'nav-pills nav-stacked';
		    	break;
		    default:
		    	return 'navbar-nav';
	    }
    }

	/**
	 * @return array
	 */
	public function getThemeSelect2()
	{
		return [
			'horizontal' => Yii::t('traits','Horizontal'),
			'vertical' => Yii::t('traits','Vertical')
		];
	}

    /**
     * @inheritdoc
     *
     * @return TypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypesQuery(static::class);
    }

}
