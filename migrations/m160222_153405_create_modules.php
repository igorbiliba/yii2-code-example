<?php

use yii\db\Migration;

class m160222_153405_create_modules extends Migration
{
    public function up()
    {
        $this->createTable('modules', [
            'id' => $this->primaryKey(),
            'name' => $this->string(63)->notNull() . ' COMMENT "Название модуля"',
            'version' => $this->double()->notNull() . ' COMMENT "Версия модуля"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);

        $this->createIndex('module_name_version_idx', 'modules', [
            'name', 'version'
        ], true);
    }

    public function down()
    {
        $this->dropIndex('module_name_version_idx', 'modules');
        $this->dropTable('modules');
    }
}
