<?php

use yii\db\Migration;

class m160311_111521_update_content_types extends Migration
{
    public function up()
    {
        $this->alterColumn('link_contents', 'content_type', $this->string(63)->notNull()->defaultValue('text') . ' COMMENT "Тип блока"');
    }

    public function down()
    {
        
    }
}
