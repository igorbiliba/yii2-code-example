<?php

use yii\db\Migration;

class m160222_155458_create_widget_credentials extends Migration
{
    public function up()
    {
        $this->createTable('widget_credentials', [
            'id' => $this->primaryKey(),
            'widget_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на виджет"',
            'role_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на роль"',
            'access' => $this->boolean()->notNull()->defaultValue(0) . ' COMMENT "Есть доступ?"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
        $this->addForeignKey('role_credentials_fk', 'widget_credentials', 'role_id', 'roles', 'id');
        $this->addForeignKey('widget_credentials_fk', 'widget_credentials', 'widget_id', 'widgets', 'id');
        $this->createIndex('widget_role_idx', 'widget_credentials', [
            'widget_id', 'role_id',
        ], true);
    }

    public function down()
    {
        $this->dropForeignKey('role_credentials_fk', 'widget_credentials');
        $this->dropForeignKey('widget_credentials_fk', 'widget_credentials');
        $this->dropIndex('widget_role_idx', 'widget_credentials');
        $this->dropTable('widget_credentials');
    }
}
