<?php

use yii\db\Migration;

class m160303_071047_create_post_events_templates extends Migration
{
    public function up()
    {
        $this->createTable('post_events_templates', [
            'id' => $this->primaryKey(),            
            'is_active' => $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Активен"',
            'type_event' => $this->string(31)->notNull() . ' COMMENT "Тип события"',
            'delay' => $this->integer()->notNull()->defaultValue(0) . ' COMMENT "Задержка для отправки"',            
            'content_type' => ' ENUM("text/html", "text/plain") NOT NULL DEFAULT "text/html" COMMENT "Тип контента"',                        
            'from_email' => $this->string(63) . ' COMMENT "E-Mail отправителя"',            
        ]);
        
        //$this->createIndex('post_events_templates_type_for_language_idx', 'post_events_templates', 'type_event', true);
    }

    public function down()
    {
        $this->dropTable('post_events_templates');
    }
}
