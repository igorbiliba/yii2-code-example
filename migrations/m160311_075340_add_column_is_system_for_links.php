<?php

use yii\db\Migration;

class m160311_075340_add_column_is_system_for_links extends Migration
{
    public function up()
    {
        $this->addColumn('links', 'is_system', $this->boolean()->notNull()->defaultValue(0).' COMMENT "Служебная запись"');
    }

    public function down()
    {
        $this->dropColumn('links', 'is_system');
    }
}
