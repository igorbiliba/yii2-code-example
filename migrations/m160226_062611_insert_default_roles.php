<?php

use yii\db\Migration;

class m160226_062611_insert_default_roles extends Migration
{
    public function up()
    {
        $this->insert('roles', [
            'name' => 'guest'
        ]);

        $this->insert('roles', [
            'name' => 'user'
        ]);

        $this->insert('roles', [
            'name' => 'admin'
        ]);
    }

    public function down()
    {
        $this->delete('roles', [
            'name' => 'guest'
        ]);

        $this->delete('roles', [
            'name' => 'user'
        ]);

        $this->delete('roles', [
            'name' => 'admin'
        ]);
    }
}
