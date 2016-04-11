<?php

use yii\db\Migration;

class m160222_154610_create_widgets extends Migration
{
    public function up()
    {
        $this->createTable('widgets', [
            'id' => $this->primaryKey(),
            'module_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на модуль"',
            'name' => $this->string(63)->notNull() . ' COMMENT "Название виджета"',
            'version' => $this->double()->notNull() . ' COMMENT "Версия виджета"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
        $this->addForeignKey('widget_to_module_fk', 'widgets', 'module_id', 'modules', 'id');
        $this->createIndex('widget_module_name_version', 'widgets', [
            'module_id', 'name', 'version',
        ], true);
    }

    public function down()
    {
        $this->dropForeignKey('widget_to_module_fk', 'widgets');
        $this->dropIndex('widget_module_name_version', 'widgets');
        $this->dropTable('widgets');
    }
}
