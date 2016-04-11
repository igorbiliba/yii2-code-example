<?php

use yii\db\Migration;

class m160311_075524_insert_system_link extends Migration
{
    public function up()
    {
        $this->insert('links', [            
            'url' => '#',
            'show_in_menu' => 0,
            'show_in_breadcrumbs' => 0,
            'is_serch' => 0,
            'is_system' => 1,
        ]);
    }

    public function down()
    {
        $this->delete('links', [
            'url' => '#',
            'is_system' => 1,
        ]);
    }
}
