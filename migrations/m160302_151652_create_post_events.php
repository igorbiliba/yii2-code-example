<?php

use yii\db\Migration;

class m160302_151652_create_post_events extends Migration
{
    public function up()
    {
        $this->createTable('post_events', [
            'id'         => $this->primaryKey(),
            'email'      => $this->string(127)->notNull() . ' COMMENT "E-Mail, кому отправим"',
            'subject'    => $this->string(255)->notNull() . ' COMMENT "Тема сообщения"',
            'text'       => $this->text()->notNull()->defaultValue('') . ' COMMENT "Текст письма"',
            'expire'     => $this->integer() . ' COMMENT "Время для отложенной отправки"',
            'status'     => 'ENUM("is_send", "wait", "trouble") NOT NULL COMMENT "Статус оправки письма"',
            'is_copy'    => $this->boolean()->notNull()->defaultValue(0) . ' COMMENT "Это копия письма"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
    }

    public function down()
    {
        $this->dropTable('post_events');
    }
}
