<?php

use yii\db\Migration;

class m160225_123407_add_column_for_tree extends Migration
{
    public $tableName = 'links';

    public function up()
    {
        $this->addColumn($this->tableName, 'root', \yii\db\mysql\Schema::TYPE_INTEGER . ' UNSIGNED DEFAULT NULL');
        $this->addColumn($this->tableName, 'lft', \yii\db\mysql\Schema::TYPE_INTEGER . ' UNSIGNED');
        $this->addColumn($this->tableName, 'rgt', \yii\db\mysql\Schema::TYPE_INTEGER . ' UNSIGNED');
        $this->addColumn($this->tableName, 'level', \yii\db\mysql\Schema::TYPE_SMALLINT . ' UNSIGNED');
        $this->addColumn($this->tableName, 'type', \yii\db\mysql\Schema::TYPE_STRING . '(64)');
        $this->addColumn($this->tableName, 'name', \yii\db\mysql\Schema::TYPE_STRING . '(128)');

        $this->createIndex('root', $this->tableName, 'root');
        $this->createIndex('lft', $this->tableName, 'lft');
        $this->createIndex('rgt', $this->tableName, 'rgt');
        $this->createIndex('level', $this->tableName, 'level');

        $this->update($this->tableName, [
            'root' => 1,
            'lft' => 1,
            'rgt' => 2,
            'level' => 0,
            'type' => 'default',
            'name' => '/'
        ]);
    }

    public function down()
    {
        $this->dropIndex('root', $this->tableName);
        $this->dropIndex('lft', $this->tableName);
        $this->dropIndex('rgt', $this->tableName);
        $this->dropIndex('level', $this->tableName);

        $this->dropColumn($this->tableName, 'root');
        $this->dropColumn($this->tableName, 'lft');
        $this->dropColumn($this->tableName, 'rgt');
        $this->dropColumn($this->tableName, 'level');
        $this->dropColumn($this->tableName, 'type');
        $this->dropColumn($this->tableName, 'name');
    }
}
