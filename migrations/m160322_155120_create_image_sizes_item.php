<?php

use yii\db\Migration;

class m160322_155120_create_image_sizes_item extends Migration
{
    public function up()
    {
        $this->createTable('image_sizes_item', [
            'id' => $this->primaryKey(),
            'image_size_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на ид адаптивности"',
            'name' => $this->string(63)->notNull() . ' COMMENT "Название адаптивности типа 480x280"',
            'width' => $this->integer()->notNull() . ' COMMENT "Ширина картинки"',
            'height' => $this->integer()->notNull() . ' COMMENT "Высота картинки"',
            'min_width' => $this->integer()->notNull() . ' COMMENT "Минимальная ширина картинки"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);
        
        $this->addForeignKey('image_sizes_item_fk', 'image_sizes_item', 'image_size_id', 'image_sizes', 'id');
        
        $this->createIndex('image_sizes_item_idx', 'image_sizes_item', [
            'image_size_id', 'name'
        ]);
    }

    public function down()
    {
        $this->dropTable('image_sizes_item');
    }
}
