<?php

use yii\db\Migration;

class m160225_094320_insert_root_link_in_links extends Migration
{
    public function up()
    {
        $this->insert('links', [
            'id' => \app\models\Languages::ROOT_ID,
            'url' => '/',
            'show_in_menu' => 0,
        ]);
    }

    public function down()
    {
        \app\models\Links::deleteAll(['id' => \app\models\Languages::ROOT_ID]);
    }
}
