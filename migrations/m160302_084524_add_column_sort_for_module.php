<?php

use yii\db\Migration;

class m160302_084524_add_column_sort_for_module extends Migration
{
    public function up()
    {
        $this->addColumn('modules',
                'sort',
                $this->integer()->notNull()->defaultValue(\app\models\Modules::DEFAULT_SORT).
                ' COMMENT "Поле сортировки, '.\app\models\Modules::DEFAULT_SORT.'- значит, без сортировки"');
    }

    public function down()
    {
        $this->dropColumn('modules', 'sort');
    }
}
