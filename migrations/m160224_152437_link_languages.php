<?php

use yii\db\Migration;

class m160224_152437_link_languages extends Migration
{
    public function up()
    {
        $this->createTable('link_languages', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на url-ссылку"',
            'language_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на язык"',
            'title' => $this->string(127) . ' COMMENT "Заголовок вкладки браузера"',
            'h1' => $this->string(127) . ' COMMENT "Заголовок страницы"',
            'description' => $this->string(127) . ' COMMENT "Описание (description) для сео"',
            'head_tags' => $this->text() . ' COMMENT "Теги в HEAD"',
            'canonical_link' => $this->string(255) . ' COMMENT "Признак страницы canonical"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);

        $this->addForeignKey('link_fk', 'link_languages', 'link_id', 'links', 'id');
        $this->addForeignKey('language_fk', 'link_languages', 'language_id', 'languages', 'id');

        $this->createIndex('link_and_language_idx', 'link_languages', [
            'link_id', 'language_id'
        ], true);
    }

    public function down()
    {
        $this->dropTable('link_languages');
    }
}
