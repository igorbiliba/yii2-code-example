<?php

use yii\db\Migration;

class m160309_143417_create_menu extends Migration
{
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'is_active' => $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Активность"',
            'type' => 'ENUM ("inner", "default") NOT NULL DEFAULT "inner" COMMENT "Тип, вложенное, или нет"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
    }

    public function down()
    {
        $this->dropTable('menu');
    }
}
