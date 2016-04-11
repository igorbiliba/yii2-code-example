<?php

use yii\db\Migration;

class m160229_101833_add_column_type_content extends Migration
{
    public function up()
    {
        $this->addColumn('link_contents', 'content_type', 'ENUM("widget", "html", "text", "image", "other") NOT NULL DEFAULT "text" COMMENT "Тип контента"');
    }

    public function down()
    {
        $this->dropColumn('link_contents', 'content_type');
    }
}
