<?php

use yii\db\Migration;

class m160309_144115_create_menu_language extends Migration
{
    public function up()
    {
        $this->createTable('menu_language', [
            'id' => $this->primaryKey(),
            
            'language_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на язык"',
            'menu_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на меню"',
            'name' => $this->string(63)->notNull()->unique() . ' COMMENT "Название меню"',
            
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
        
        $this->addForeignKey('menu_language_menu_fk', 'menu_language', 'menu_id', 'menu', 'id');
        $this->addForeignKey('menu_language_language_fk', 'menu_language', 'language_id', 'languages', 'id');
        
        $this->createIndex('menu_language_refs_idx', 'menu_language', [
            'language_id', 'menu_id',
        ], true);
    }

    public function down()
    {
        $this->dropTable('menu_language');
    }
}
