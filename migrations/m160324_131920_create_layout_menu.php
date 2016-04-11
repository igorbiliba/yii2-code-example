<?php

use yii\db\Migration;

class m160324_131920_create_layout_menu extends Migration
{
    public function up()
    {
        $this->createTable('layout_menu', [
            'id' => $this->primaryKey(),
            'layout_path' => $this->string(255)->notNull() . ' COMMENT "Путь к шаблону layout"',
            'is_default' => $this->boolean()->notNull()->defaultValue(0). ' COMMENT "Шаблон по умолчанию"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
    }

    public function down()
    {
        $this->dropTable('layout_menu');
    }
}
