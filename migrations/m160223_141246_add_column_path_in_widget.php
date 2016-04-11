<?php

use yii\db\Migration;

class m160223_141246_add_column_path_in_widget extends Migration
{
    public function up()
    {
        $this->addColumn(
            'widgets',
            'path',
            $this->string(255)->notNull()->unique() . ' COMMENT "Путь к виджету"'
        );
        $this->createIndex('widget_path_idx', 'widgets', 'path', true);
    }

    public function down()
    {
        $this->dropIndex('widget_path_idx', 'widgets');
        $this->dropColumn('widgets', 'path');
    }
}
