<?php

use yii\db\Migration;

class m160310_154151_add_column_link_contents extends Migration
{
    public function up()
    {
        $this->addColumn('link_contents', 'key', $this->string()->notNull().' COMMENT "Место для вставки контента"');
        $this->addColumn('link_contents', 'sort', $this->integer()->notNull()->defaultValue(1000).' COMMENT "Порядок контентов одного блока"');
    }

    public function down()
    {
        $this->dropColumn('link_contents', 'key');
        $this->dropColumn('link_contents', 'sort');
    }
}
