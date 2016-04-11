<?php

use yii\db\Migration;

class m160224_133546_create_links extends Migration
{
    public function up()
    {
        $this->createTable('links', [
            'id' => $this->primaryKey(),
            'url' => $this->string(255)->notNull()->unique(). ' COMMENT "Урл станицы"',
            'template' => $this->string(127) . ' COMMENT "Шаблон страницы, если пустой- то шаблон по умолчанию"',
            'redirect_link' => $this->string(255). ' COMMENT "Урл станицы для редиректа"',
            'show_in_menu' => $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Отображать в меню"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);

        $this->createIndex('links_url_idx', 'links', 'url', true);
    }

    public function down()
    {
        $this->dropIndex('links_url_idx', 'links');
        $this->dropTable('links');
    }
}
