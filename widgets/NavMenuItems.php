<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-essentials
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.8.0
 */

namespace cinghie\menu\widgets;

use cinghie\menu\models\Items;
use Yii;
use yii\bootstrap\Nav;
use yii\bootstrap\Widget;
use yii\helpers\Url;

class NavMenuItems extends Widget
{
    public $menuId;
    public $menuItems;
    public $menuOrderBy;
    public $menuOrderType;
    public $childOrderBy;
    public $childOrderType;
    public $options;
    public function init()
    {
        parent::init();
        // set default Orderby
        if($this->menuOrderBy == "") { $this->menuOrderBy = "id"; }
        // set default Orderby
        if($this->menuOrderType == "") { $this->menuOrderType = SORT_ASC; }
        // set default Orderby
        if($this->childOrderBy == "") { $this->childOrderBy = "id"; }
        // set default Orderby
        if($this->childOrderType == "") { $this->childOrderType = SORT_ASC; }
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
            $menuItems = $menuItems->find()->findByMenuType($this->menuId)->orderBy([$this->menuOrderBy => $this->menuOrderType])->all();
            if(count($menuItems) != 0)
            {
                foreach($menuItems as $menuItem)
                {
                    // Check language
                    if($this->checkLanguageMenu($menuItem->language))
                    {
                        // Check if item has childs
                        $childs = $menuItem->getChilds($menuItem->id)->orderBy([$this->childOrderBy => $this->childOrderType])->asArray()->all();
                        if(count($childs))
                        {
                            $this->createMenuItem($menuItem,$childs);
                        } else {
                            $this->createMenuItem($menuItem);
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
    /*
     * return
     */
    private function checkLanguageMenu($lang)
    {
        if($lang == Yii::$app->language || $lang == 'All')
        {
            return true;
        } else {
            return false;
        }
    }
    /*
     * return single item childs
     */
    private function createMenuItemChilds($menuItems)
    {
        $i = 0;
        $array = [];
        foreach($menuItems as $menuItem)
        {
            // Check language
            if($this->checkLanguageMenu($menuItem['language']))
            {
                $link = [$menuItem['link']];
                $url  = $this->getUrl($link,$menuItem['params']);
                $array[$i]['label'] = $menuItem['title'];
                $array[$i]['url']   = $url;
                $i++;
            }
        }
        return $array;
    }
    /*
     * return single menu item with childs
     */
    private function createMenuItem($menuItem,$childs = [])
    {
        // Generate URL
        $link = [$menuItem->link];
        $url  = $this->getUrl($link,$menuItem->params);
        // Generate linkOptions
        $linkOptions  = json_decode($menuItem->linkOptions, true);
        $arrayOptions = $this->getLinkOptions($linkOptions);
        if(!empty($childs))
        {
            $childs = $this->createMenuItemChilds($childs);
            //echo "<pre>"; var_dump($url); echo "</pre>";
            //echo "<pre>"; var_dump(json_decode($childs[0]['params'])); echo "</pre>";
        }
        $this->menuItems[] = [
            'label' => $menuItem->title,
            'linkOptions' => $arrayOptions,
            'items' => $childs,
            'url' => $url,
            'visible' => $this->getVisibility($menuItem->access)
        ];
    }
    /*
     * return url from $params
     */
    private function getUrl($link,$params)
    {
        $params = json_decode($params, true);
        if(!empty($params))
        {
            while($param = array_shift($params)) {
                foreach ($param as $key => $value) {
                    $link[$key] = $value;
                }
            }
        }
        return Url::to($link);
    }
    /*
     * return array of $linkOptions
     */
    private function getLinkOptions($linkOptions)
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
        return $arrayOptions;
    }
    /*
     * return menu item visibility
     */
    private function getVisibility($access)
    {
        switch ($access)
        {
            case "only guest":
                return Yii::$app->user->isGuest;
                break;
            case "public":
                return true;
                break;
            case "registered":
                return !Yii::$app->user->isGuest;
                break;
            default:
                return Yii::$app->user->can($access);
        }
    }
    public function run()
    {
        return Nav::widget([
            'options' => $this->options,
            'items' => $this->menuItems
        ]);
    }
}
