<?php

use yii\db\Migration;

class m160304_060843_add_colums_from_for_post_events extends Migration
{
    public function up()
    {
        $this->addColumn('post_events', 'from_name',  $this->string(127)->notNull()->defaultValue('') . ' COMMENT "Имя отправителя"');
        $this->addColumn('post_events', 'from_email', $this->string(63)->notNull()->defaultValue('')  . ' COMMENT "E-Mail отправителя"');
        $this->addColumn('post_events', 'content_type', 'ENUM("text/html", "text/plain") NOT NULL DEFAULT "text/html" COMMENT "Тип контента"');
    }

    public function down()
    {
        $this->dropColumn('post_events', 'from_name');
        $this->dropColumn('post_events', 'from_email');
        $this->dropColumn('post_events', 'content_type');
    }
}
