<?php

use yii\db\Migration;

class m160309_145919_create_menu_item extends Migration
{
    public function up()
    {
        $this->createTable('menu_item', [
            'id' => $this->primaryKey(),
            
            'menu_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на меню"',
            'link_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на url-ссылку"',
            'href' => $this->string(255) .             ' COMMENT "url-ссылка"',
            'html_class' => $this->string(63) .        ' COMMENT "HTML класс элемента"',
            'css_style' => $this->string(255) .        ' COMMENT "CSS стиль элемента"',            
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
        
        $this->addForeignKey('menu_item_menu_fk', 'menu_item', 'menu_id', 'menu', 'id');        
        $this->addForeignKey('menu_item_link_fk', 'menu_item', 'link_id', 'links', 'id');
    }

    public function down()
    {
        $this->dropTable('menu_item');
    }
}
