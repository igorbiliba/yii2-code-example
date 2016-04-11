<?php

use yii\db\Migration;

class m160303_080643_create_post_events_templates_languages extends Migration
{
    public function up()
    {
        $this->createTable('post_events_templates_languages', [
            'id' => $this->primaryKey(),
            'language_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на язык"',
            'template_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на тип шаблона"',            
            'subject' => $this->string(127)->notNull()->defaultValue('') . ' COMMENT "Тема письма"',
            'from_name' => $this->string(127) . ' COMMENT "Имя отправителя"',            
            'content' => $this->text()->notNull() . ' COMMENT "Шаблон письма"',
        ]);
        
        $this->createIndex('post_events_templates_languages_idx', 'post_events_templates_languages', [
            'language_id', 'template_id'
        ], true);
        
        $this->addForeignKey('post_events_templates_languages_fk', 'post_events_templates_languages', 'language_id', 'languages', 'id');
        $this->addForeignKey('post_events_templates_languages_template_fk', 'post_events_templates_languages', 'template_id', 'post_events_templates', 'id');
    }

    public function down()
    {
        $this->dropTable('post_events_templates_languages');
    }
}
