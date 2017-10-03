<?php

use yii\db\Migration;

class m160103_115801_create_menu_types extends Migration
{

    public function up()
    {
        // Create Table menu_types
        $this->createTable('{{%menu_types}}', [
            'id' => $this->primaryKey(),
            'menutype' => $this->string(24)->notNull(),
            'title' => $this->string(48)->notNull(),
            'description' => $this->string(255)->notNull()
        ]);

        // Add Main Menu Example
        $this->insert('{{%menu_types}}', [
            'id' => 1,
            'menutype' => 'mainmenu',
            'title' => 'Main Menu',
            'description' => 'Main Menu',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%menu_types}}');
    }
}
