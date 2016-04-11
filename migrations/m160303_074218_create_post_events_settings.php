<?php

use yii\db\Migration;

class m160303_074218_create_post_events_settings extends Migration
{
    public function up()
    {
        $this->createTable('post_events_settings', [
            'id' => $this->primaryKey(),
            'language_id' => $this->integer()->notNull()->unique() . ' COMMENT "Ссылка на язык"',            
            'from_name' => $this->string(127)->notNull()->defaultValue('') . ' COMMENT "Имя отправителя"',
            'from_email' => $this->string(63)->notNull()->defaultValue('') . ' COMMENT "E-Mail отправителя"',            
            'header' => $this->text() . ' COMMENT "Шапка письма"',
            'footer' => $this->text() . ' COMMENT "Подвал письма"',
        ]);
        
        $this->addForeignKey('post_events_settings_languages_fk', 'post_events_settings', 'language_id', 'languages', 'id');
        $this->createIndex('post_events_settings_language_idx', 'post_events_settings', 'language_id', true);
    }

    public function down()
    {
        $this->dropTable('post_events_settings');
    }
}
