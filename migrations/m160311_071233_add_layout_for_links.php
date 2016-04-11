<?php

use yii\db\Migration;

class m160311_071233_add_layout_for_links extends Migration
{
    public function up()
    {
        $this->addColumn('links', 'layout', $this->string(127) . ' COMMENT "layout для виртуальной страницы"');
    }

    public function down()
    {
        $this->dropColumn('links', 'layout');
    }
}
