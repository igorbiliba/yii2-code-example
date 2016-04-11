<?php

use yii\db\Migration;

class m160224_155952_add_column_in_link_show_in_breadcrumbs extends Migration
{
    public function up()
    {
        $this->addColumn(
            'links',
            'show_in_breadcrumbs',
            $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Показывать в хлебных крошках"'
        );
    }

    public function down()
    {
        $this->dropColumn('links', 'show_in_breadcrumbs');
    }
}