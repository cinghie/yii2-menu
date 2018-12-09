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

namespace cinghie\menu\widgets;

use Exception;
use Yii;
use cinghie\menu\models\Items;
use cinghie\menu\models\Types;
use yii\bootstrap\Nav;
use yii\bootstrap\Widget;
use yii\helpers\Url;

class NavMenuItems extends Widget
{
	/** @var int $menuId */
    public $menuId;

	/** @var Types $menuType */
    public $menuType;

	/** @var array $menuItems */
    public $menuItems;

	/** @var string $menuOrderBy */
    public $menuOrderBy;

	/** @var string $menuOrderType */
    public $menuOrderType;

	/** @var string $childOrderBy */
    public $childOrderBy;

	/** @var string $childOrderType */
    public $childOrderType;

	/**
	 * @inheritdoc
	 *
	 * @throws Exception
	 */
    public function init()
    {
        parent::init();

        // Set Menu Type
		if($this->menuId) {
			$menu = new Types();
			$this->menuType = $menu::findOne($this->menuId);
		}

        // Set default Menu Orderby
        if($this->menuOrderBy === '' || $this->menuOrderBy === null) { $this->menuOrderBy = 'id'; }

        // Set default Menu Order Type
        if($this->menuOrderType === '' || $this->menuOrderType === null) { $this->menuOrderType = SORT_ASC; }

        // Set default Child Orderby
        if($this->childOrderBy === '' || $this->childOrderBy === null) { $this->childOrderBy = 'id'; }

        // Set default Child Order Type
        if($this->childOrderType === '' || $this->childOrderType === null) { $this->childOrderType = SORT_ASC; }

        if($this->menuId === null)
        {
            $this->options   = ['class' => 'navbar-nav navbar-right'];
            $this->menuItems = [
                ['label' => 'Home', 'url' => ['/']],
                ['label' => 'About', 'url' => ['/site/about']],
	            ['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'Login', 'url' => ['/site/login'], 'visible' => Yii::$app->user->isGuest],
                ['label' => 'Logout', 'url' => ['/site/logout'], 'visible' => !Yii::$app->user->isGuest],
            ];

        } else {

            $menuItems = new Items();
	        $menuItems = $menuItems::find()->findByMenuType($this->menuId)->orderBy([ $this->menuOrderBy => $this->menuOrderType])->all();

            if(count($menuItems) !== 0)
            {
                foreach($menuItems as $menuItem)
                {
                    // Check language
                    if($this->checkLanguageMenu($menuItem->language))
                    {
	                    /** @var Items $menuItem */
                        $childs = $menuItem->getChilds()->orderBy([$this->childOrderBy => $this->childOrderType])->asArray()->all();

	                    // Check if item has childs
                        if(count($childs)) {
                            $this->createMenuItem($menuItem,$childs);
                        } else {
	                        $this->createMenuItem($menuItem,[]);
                        }
                    }
                }

            } else {

                $this->menuItems[] = [
                    'label' => 'Menu Empty',
                    'url' => '#'
                ];
            }
        }
    }

	/**
	 * Check menu item language
	 *
	 * @param string $lang
	 *
	 * @return bool
	 * @throws Exception
	 */
    private function checkLanguageMenu($lang)
    {
	    return $lang === Yii::$app->language || $lang === 'all' || $lang === 'All';
    }

	/**
	 * Create single item childs
	 *
	 * @param array $menuItems
	 *
	 * @return array
	 * @throws Exception
	 */
    private function createMenuItemChilds($menuItems)
    {
        $i = 0;
        $array = [];

        foreach($menuItems as $menuItem)
        {
        	// Load MenuItems Object
	        $menuItemObject = Items::findOne($menuItem['id']);

            // Check language
            if($menuItemObject !== null && $this->checkLanguageMenu($menuItem['language']))
            {
                $array[$i]['label'] = $menuItemObject->getMenuLabel();
                $array[$i]['url'] = $this->getUrl([$menuItem['link']],$menuItem['params']);
                $array[$i]['linkOptions'] = $this->getLinkOptions($menuItem['title'],json_decode($menuItem['linkOptions'], true));
                $i++;
            }
        }

        return $array;
    }

	/**
	 * Create single menu item with childs
	 *
	 * @param Items $menuItem
	 * @param array $childs
	 *
	 * @return void
	 * @throws Exception
	 */
    private function createMenuItem($menuItem,array $childs)
    {
        // Generate URL
        $link = [$menuItem->link];
	    $url = $this->getUrl($link,$menuItem->params);

        // Generate linkOptions
        $linkOptions  = json_decode($menuItem->linkOptions, true);
        $arrayOptions = $this->getLinkOptions($menuItem->title,$linkOptions);

        if(!empty($childs)) {
            $childs = $this->createMenuItemChilds($childs);
        }

        $this->menuItems[] = [
            'label' => $menuItem->getMenuLabel(),
            'linkOptions' => $arrayOptions,
            'items' => $childs,
            'url' => $url,
            'visible' => $this->getVisibility($menuItem->access)
        ];
    }

	/**
	 * Create url from $params
	 *
	 * @param $link
	 * @param $params
	 *
	 * @return string
	 * @throws Exception
	 */
	private function getUrl($link,$params)
    {
        $params = json_decode($params, true);

        if(!empty($params))
        {
            while($param = array_shift($params)) {
	            /** @var array $param */
	            foreach ($param as $key => $value) {
                    $link[$key] = $value;
                }
            }
        }

        return Url::to($link);
    }

    /**
     * Get array of $linkOptions
     *
     * @param string $title
     * @param array $linkOptions
     *
     * @return array
     */
    private function getLinkOptions($title,$linkOptions)
    {
        $arrayOptions = [];

        if(!empty($linkOptions))
        {
	        while($linkOption = array_shift($linkOptions))
	        {
		        foreach ($linkOption as $key => $value) {
                    $arrayOptions[$key] = $value;
                }
            }
        }

	    $arrayOptions['title'] = $title;

        return $arrayOptions;
    }

	/**
	 * Get menu item visibility
	 *
	 * @param $access
	 *
	 * @return bool
	 */
	private function getVisibility($access)
    {
        switch ($access)
        {
            case 'only guest':
                return Yii::$app->user->isGuest;
                break;
            case 'public':
                return true;
                break;
            case 'registered':
                return !Yii::$app->user->isGuest;
                break;
            default:
                return Yii::$app->user->can($access);
        }
    }

	/**
	 * @inheritdoc
	 *
	 * @throws Exception
	 */
    public function run()
    {
    	$options = $this->options;
    	$options['class'] = $this->menuType->getThemeClass().' '.$options['class'];

        return Nav::widget([
            'options' => $options,
            'items' => $this->menuItems,
            'encodeLabels' => false,
        ]);
    }

}
