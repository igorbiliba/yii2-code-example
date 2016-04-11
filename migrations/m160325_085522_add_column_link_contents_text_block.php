<?php

use yii\db\Migration;

class m160325_085522_add_column_link_contents_text_block extends Migration
{
    public function up()
    {
        $this->addColumn('link_contents', 'text_block_id', $this->integer() . ' COMMENT "Ссылка на текстовый блок"');        
        $this->addForeignKey('link_contents_tb_fk', 'link_contents', 'text_block_id', 'text_block', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('link_contents', 'link_contents_tb_fk');
        $this->dropColumnColumn('link_contents', 'text_block_id');
    }
}
