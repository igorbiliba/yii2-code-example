<?php

use yii\db\Migration;

class m160309_090519_add_colums_type_event_for_post_events extends Migration
{
    public function up()
    {
        $this->addColumn('post_events', 'type_event', $this->string(63)->notNull() . ' COMMENT "Тип события"');
    }

    public function down()
    {
        $this->dropColumn('post_events', 'type_event');
    }
}
