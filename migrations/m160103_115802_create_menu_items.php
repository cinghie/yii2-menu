<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-menu
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-menu
 * @version 0.8.1
 */

use cinghie\traits\migrations\Migration;

class m160103_115802_create_menu_items extends Migration
{

    public function up()
    {
        // Create Table menu_items
        $this->createTable('{{%menu_items}}', [
            'id' => $this->primaryKey(),
            'menutypeid' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'alias' => $this->string(255)->notNull()->unique(),
            'parentid' => $this->integer(11)->notNull()->defaultValue(1),
            'link' => $this->string(1024)->notNull(),
            'state' => $this->boolean()->notNull()->defaultValue(0),
            'access' => $this->string(64)->notNull()->defaultValue('public'),
            'params' => $this->text(),
            'linkOptions' => $this->text(),
            'language' => $this->string(7)->notNull()->defaultValue('all'),
        ]);

        // Add Index and Foreign Key access
        $this->createIndex(
            "index_menu_type",
            "{{%menu_items}}",
            "menutypeid"
        );

        $this->addForeignKey("fk_menu_type",
            '{{%menu_items}}', "menutypeid",
            '{{%menu_types}}', "id",
            "CASCADE", "RESTRICT");

        // Add Menu Item Root
        $this->insert('{{%menu_items}}', [
            'id' => 1,
            'menutypeid' => 1,
            'title' => 'Menu_Item_Root',
            'alias' => 'root',
            'parentid' => 0,
            'state' => 1,
        ]);

        // Adding initial Yii2 Menu
        $this->insert('{{%menu_items}}', [ 'id' => 2, 'menutypeid' => 1, 'title' => 'Home', 'alias' => 'home', 'link' => '/', 'parentid' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 3, 'menutypeid' => 1, 'title' => 'About', 'alias' => 'about', 'link' => '/site/about', 'parentid' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 4, 'menutypeid' => 1, 'title' => 'Contact', 'alias' => 'contact', 'link' => '/site/contact', 'parentid' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 5, 'menutypeid' => 1, 'title' => 'Register', 'alias' => 'register', 'link' => '/register', 'access' => 'only guest', 'parentid' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 6, 'menutypeid' => 1, 'title' => 'Login', 'alias' => 'login', 'link' => '/login', 'access' => 'only guest', 'parentid' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 7, 'menutypeid' => 1, 'title' => 'Logout', 'alias' => 'logout', 'link' => '/logout', 'access' => 'registered', 'linkOptions' => '[{"data-method":"post"}]', 'parentid' => 1, 'state' => 1 ]);
    }

    public function down()
    {
        $this->dropTable('{{%menu_items}}');
    }

}
