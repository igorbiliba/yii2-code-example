<?php

use yii\db\Migration;

class m160222_153400_create_roles extends Migration
{
    const DEFAULT_ROLE = 'guest';

    public function up()
    {
        $this->createTable('roles', [
            'id' => $this->primaryKey(),
            'name' => $this->string(15)->unique()->notNull()->defaultValue(self::DEFAULT_ROLE) . ' COMMENT "Название роли"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);

        $this->createIndex('name_role_idx', 'roles', 'name', true);
    }

    public function down()
    {
        $this->dropIndex('name_role_idx', 'roles');
        $this->dropTable('roles');
    }
}
