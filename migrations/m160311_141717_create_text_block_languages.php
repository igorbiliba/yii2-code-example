<?php

use yii\db\Migration;

class m160311_141717_create_text_block_languages extends Migration
{
    public function up()
    {
        $this->createTable('text_block_languages', [
            'id' => $this->primaryKey(),
            'text_block_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на текстовый/контентный блок"',
            'language_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на язык"',
            'title' => $this->string(127) . ' COMMENT "Заголовок"',
            'text' => $this->text() . ' COMMENT "Содержание"',
        ]);
        
        $this->addForeignKey('text_block_languages_fk', 'text_block_languages', 'language_id', 'languages', 'id');
        $this->addForeignKey('text_block_languages_tb_fk', 'text_block_languages', 'text_block_id', 'text_block', 'id');
    }

    public function down()
    {
        $this->dropTable('text_block_languages');
    }
}
