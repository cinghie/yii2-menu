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
use dektrium\user\models\User;

class Menus extends \yii\db\ActiveRecord
{

    /**
     * Active item setting 'state' = 1
     * @return bool
     */
    public function active()
    {
        return (bool)$this->updateAttributes([
            'state' => 1
        ]);
    }

    /**
     * Inactive item setting 'state' = 0
     * @return bool
     */
    public function inactive()
    {
        return (bool)$this->updateAttributes([
            'state' => 0
        ]);
    }

    /**
     * Return array for State status
     */
    public function getStates()
    {
        return [ 1 => Yii::t('menu', 'Actived'), 0 => Yii::t('menu', 'Unactived') ];
    }

    /**
     * Return languages Select
     */
    public function getLanguages()
    {
        $languages = Yii::$app->urlManager->languages;
        $languagesSelect = array('All' => Yii::t('menu', 'All'));

        foreach($languages as $language) {
            $languagesSelect[$language] = ucwords($language);
        }

        return $languagesSelect;
    }

    /**
     * Generate URL alias
     * @return string alias
     */
    public function generateAlias($name)
    {
        // remove any '-' from the string they will be used as concatonater
        $name = str_replace('-', ' ', $name);
        $name = str_replace('_', ' ', $name);

        // remove any duplicate whitespace, and ensure all characters are alphanumeric
        $name = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $name);

        // lowercase and trim
        $name = trim(strtolower($name));

        return $name;
    }

    /**
     * Return an array with the user roles
     * @return array
     */
    public function getRoles()
    {
        $sql = 'SELECT name FROM {{%auth_item}} WHERE type = 1 ORDER BY name ASC';
        $roles = Items::findBySql($sql)->asArray()->all();
        $array = ['public' => 'Public', 'only guest' => 'Only Guest'];

        foreach($roles as $role) {
            $array[$role['name']] = ucwords($role['name']);
        }

        return $array;
    }

    /**
     * Return languages Select
     * @return array
     */
    public function getLanguagesSelect2()
    {
        $languages = Yii::$app->urlManager->languages;
        $languagesSelect = array('All' => Yii::t('menu', 'All'));

        foreach($languages as $language) {
            $languagesSelect[$language] = ucwords($language);
        }

        return $languagesSelect;
    }

    /**
     * Return array for User Select2 with current user selected
     * @return array
     */
    public function getUsersSelect2($userid,$username)
    {
        $sql   = 'SELECT id,username FROM {{%user}} WHERE id != '.$userid;
        $users = User::findBySql($sql)->asArray()->all();

        $array[$userid] = ucwords($username);

        foreach($users as $user) {
            $array[$user['id']] = ucwords($user['username']);
        }

        return $array;
    }

}
