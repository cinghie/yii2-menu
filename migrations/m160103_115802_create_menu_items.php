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

use cinghie\traits\migrations\Migration;

class m160103_115802_create_menu_items extends Migration
{

    public function up()
    {
        // Create Table menu_items
        $this->createTable('{{%menu_items}}', [
            'id' => $this->primaryKey(),
            'menutype_id' => $this->integer(11)->notNull(),
            'parent_id' => $this->integer(11)->defaultValue(1),
            'title' => $this->string(255)->notNull(),
            'alias' => $this->string(255)->notNull()->unique(),
            'link' => $this->string(1024)->notNull(),
            'state' => $this->boolean()->notNull()->defaultValue(0),
            'access' => $this->string(64)->notNull()->defaultValue('public'),
            'language' => $this->string(7)->notNull()->defaultValue('all'),
            'linkOptions' => $this->text(),
            'params' => $this->text(),
        ]);

        // Add Index and Foreign Key access
        $this->createIndex(
            "index_menu_type",
            "{{%menu_items}}",
            "menutype_id"
        );

        $this->addForeignKey("fk_menu_type",
            '{{%menu_items}}', "menutype_id",
            '{{%menu_types}}', "id",
            "CASCADE", "RESTRICT");

	    // Add Index and Foreign Key access
	    $this->createIndex(
		    "index_menu_parent_id",
		    "{{%menu_items}}",
		    "parent_id"
	    );

	    $this->addForeignKey("fk_menu_parent_id",
		    '{{%menu_items}}', "parent_id",
		    '{{%menu_items}}', "id",
		    "SET NULL", "CASCADE"
	    );

        // Add Menu Item Root
        $this->insert('{{%menu_items}}', [
            'id' => 1,
            'menutype_id' => 1,
            'parent_id' => NULL,
            'title' => 'Menu_Item_Root',
            'alias' => 'root',
            'state' => 1,
        ]);

        // Adding initial Yii2 Menu
        $this->insert('{{%menu_items}}', [ 'id' => 2, 'menutype_id' => 1, 'title' => 'Home', 'alias' => 'home', 'link' => '/', 'parent_id' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 3, 'menutype_id' => 1, 'title' => 'About', 'alias' => 'about', 'link' => '/site/about', 'parent_id' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 4, 'menutype_id' => 1, 'title' => 'Contact', 'alias' => 'contact', 'link' => '/site/contact', 'parent_id' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 5, 'menutype_id' => 1, 'title' => 'Register', 'alias' => 'register', 'link' => '/register', 'access' => 'only guest', 'parent_id' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 6, 'menutype_id' => 1, 'title' => 'Login', 'alias' => 'login', 'link' => '/login', 'access' => 'only guest', 'parent_id' => 1, 'state' => 1 ]);
        $this->insert('{{%menu_items}}', [ 'id' => 7, 'menutype_id' => 1, 'title' => 'Logout', 'alias' => 'logout', 'link' => '/logout', 'access' => 'registered', 'linkOptions' => '[{"data-method":"post"}]', 'parent_id' => 1, 'state' => 1 ]);
    }

    public function down()
    {
        $this->dropTable('{{%menu_items}}');
    }

}
