<?php

use yii\db\Migration;

class m160324_131926_create_layout_menu_items extends Migration
{
    public function up()
    {
        $this->createTable('layout_menu_items', [
            'id' => $this->primaryKey(),
            'layout_menu_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на шаблон"',
            'variable' => $this->string(63)->notNull() . ' COMMENT "Переменная, для вставки меню"',
            'menu_template' =>  $this->string(255) . ' COMMENT "Путь к шаблону"',
            'menu_id' => $this->integer() . ' COMMENT "Ссылка на меню"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
        
        $this->addForeignKey('layout_menu_items_fk', 'layout_menu_items', 'layout_menu_id', 'layout_menu', 'id');
        $this->addForeignKey('layout_menu_items_menu_fk', 'layout_menu_items', 'menu_id', 'menu', 'id');
        $this->createIndex('layout_menu_items_fk_idx', 'layout_menu_items', [
            'layout_menu_id', 'variable', 'menu_id',
        ], true);
    }

    public function down()
    {
        $this->dropTable('layout_menu_items');
    }
}
