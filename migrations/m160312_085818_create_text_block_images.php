<?php

use yii\db\Migration;

class m160312_085818_create_text_block_images extends Migration
{
    public function up()
    {
        $this->createTable('text_block_images', [
            'id' => $this->primaryKey(),
            'text_block_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на блок"',
            'name' => $this->string(31)->notNull() . ' COMMENT "Имя типа 480x280"',
            'align' => $this->string(63) . ' COMMENT "Выравнивание"',
            'width' => $this->integer()->notNull() . ' COMMENT "Ширина"',
            'height' => $this->integer()->notNull() . ' COMMENT "Высота"',
            'min_width' => $this->integer()->notNull()->defaultValue(0) . ' COMMENT "Минимальная ширина"',
            'image' => $this->string(127) . ' COMMENT "Путь к изобржению"',
        ]);
        
        $this->addForeignKey('text_block_images_fk', 'text_block_images', 'text_block_id', 'text_block', 'id');
    }

    public function down()
    {
        $this->dropTable('text_block_images');
    }
}
