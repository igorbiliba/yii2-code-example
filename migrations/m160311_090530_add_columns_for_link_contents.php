<?php

use yii\db\Migration;

class m160311_090530_add_columns_for_link_contents extends Migration
{
    public function up()
    {
        $this->addColumn('link_contents', 'menu_id', $this->integer() . ' COMMENT "Ссылка на меню"');
        $this->addColumn('link_contents', 'template', $this->string() . ' COMMENT "Шаблон для элемента"');        
        $this->addForeignKey('link_contents_menu_id_fk', 'link_contents', 'menu_id', 'menu', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('link_contents_menu_id_fk', 'link_contents');
        $this->dropColumn('link_contents', 'menu_id');
        $this->dropColumn('link_contents', 'template');
    }
}