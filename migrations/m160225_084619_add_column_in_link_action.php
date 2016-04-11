<?php

use yii\db\Migration;

class m160225_084619_add_column_in_link_action extends Migration
{
    public function up()
    {
        $this->addColumn('links', 'action', $this->string(127) . ' COMMENT "Ссылка на экшен в коде"');
    }

    public function down()
    {
        $this->dropColumn('links', 'action');
    }
}
