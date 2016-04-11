<?php

use yii\db\Migration;

class m160224_160649_create_link_contents extends Migration
{
    public function up()
    {
        $this->createTable('link_contents', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на страницу"',
            'widget_id' => $this->integer() . ' COMMENT "Ссылка на виджет"',
            'content' => $this->text() . ' COMMENT "Статичный text/html контент станицы"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);

        $this->addForeignKey('link_contents_id_fk', 'link_contents', 'link_id', 'links', 'id');
        $this->addForeignKey('link_contents_widget_id_fk', 'link_contents', 'widget_id', 'widgets', 'id');
    }

    public function down()
    {
        $this->dropTable('link_contents');
    }
}
