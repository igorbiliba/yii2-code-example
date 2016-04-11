<?php

use yii\db\Migration;

class m160309_084445_add_colums_is_serch_for_links extends Migration
{
    public function up()
    {
        $this->addColumn('links', 'is_serch', $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Участвовать в поиске"');
    }

    public function down()
    {
        $this->dropColumn('links', 'is_serch');
    }
}
