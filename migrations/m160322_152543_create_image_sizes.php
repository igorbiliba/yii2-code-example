<?php

use yii\db\Migration;

class m160322_152543_create_image_sizes extends Migration
{
    public function up()
    {
        $this->createTable('image_sizes', [
            'id' => $this->primaryKey(),
            'key' => $this->string(63)->unique()->notNull() . ' COMMENT "Ид набора адаптивности"',
            'is_system' => $this->boolean()->notNull()->defaultValue(0). ' COMMENT "Системный набор, нельзя удалять"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
    }

    public function down()
    {
        $this->dropTable('image_sizes');
    }
}
