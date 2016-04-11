<?php

use yii\db\Migration;

class m160223_085705_add_column_path_in_module extends Migration
{
    public function up()
    {
        $this->addColumn(
            'modules',
            'path',
            $this->string(255)->notNull()->unique() . ' COMMENT "Путь к модулю"'
        );
        $this->createIndex('module_path_idx', 'modules', 'path', true);
    }

    public function down()
    {
        $this->dropIndex('module_path_idx', 'modules');
        $this->dropColumn('modules', 'path');
    }
}
