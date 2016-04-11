<?php

use yii\db\Migration;

class m160309_151246_create_menu_item_language extends Migration
{
    public function up()
    {
        $this->createTable('menu_item_language', [
            'id' => $this->primaryKey(),
            
            'language_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на язык"',
            'menu_item_id' => $this->integer()->notNull() . ' COMMENT "Ссылка элемент меню"',
            'name' => $this->string(63)->notNull() . ' COMMENT "Название элемента меню"',
            
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
        
        $this->addForeignKey('menu_item_language_fk', 'menu_item_language', 'language_id', 'languages', 'id');
        $this->addForeignKey('menu_item_fk', 'menu_item_language', 'menu_item_id', 'menu_item', 'id');
    }

    public function down()
    {
        $this->dropTable('menu_item_language');
    }
}
