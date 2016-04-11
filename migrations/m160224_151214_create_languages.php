<?php

use yii\db\Migration;

class m160224_151214_create_languages extends Migration
{
    public function up()
    {
        $this->createTable('languages', [
            'id' => $this->primaryKey(),
            'enable' => $this->boolean()->notNull()->defaultValue(false) . ' COMMENT "Включен язык"',
            'key' => $this->string(7)->notNull()->unique() . ' COMMENT "Ключ языка, например RU"',
            'title' => $this->string(31)->notNull()->unique() . ' COMMENT "Название языка"',
            'is_default' => $this->boolean()->notNull()->defaultValue(false) . ' COMMENT "Язык по умолчанию"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);

        $this->createIndex('language_key_idx', 'languages', 'key', true);
        $this->createIndex('language_title_idx', 'languages', 'title', true);

        //добавим русский по умолчанию
        $this->insert('languages', [
            'enable' => 1,
            'key' => 'ru-RU',
            'title' => 'Русский',
            'is_default' => 1,
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()',
        ]);
    }

    public function down()
    {
        $this->dropIndex('language_key_idx', 'languages');
        $this->dropIndex('language_title_idx', 'languages');

        $this->dropTable('languages');
    }
}
