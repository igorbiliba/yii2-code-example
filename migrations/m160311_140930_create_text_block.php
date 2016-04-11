<?php

use yii\db\Migration;

class m160311_140930_create_text_block extends Migration
{
    public function up()
    {
        $this->createTable('text_block', [
            'id' => $this->primaryKey(),
            'type' => 'ENUM ("content_block", "text_page") NOT NULL DEFAULT "text_page" COMMENT "Тип блока (контентный блок/текстовая страница)"',
            'is_active' => $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Активность"',
            'image' => $this->string(127) . ' COMMENT "Кртинка блока"',
            'is_use_editor' => $this->boolean()->notNull()->defaultValue(0) . ' COMMENT "Использовать/нет визивиг, по умолчанию нет"',
            'js' => $this->text() . ' COMMENT "js-код"',
            'account_id' => $this->integer() . ' COMMENT "Ссылка на пользователя, который создал"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
    }

    public function down()
    {
        $this->dropTable('text_block');
    }
}
