<?php

use yii\db\Migration;

class m160226_063102_create_link_credentials extends Migration
{
    public function up()
    {
        $this->createTable('link_credentials', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на ссылку страницы"',
            'role_id' => $this->integer()->notNull() . ' COMMENT "Ссылка на роль"',
            'access' => $this->integer()->notNull()->defaultValue(0) . ' COMMENT "Параметры доступа"',
            'created_at' => $this->timestamp()->notNull() . ' COMMENT "Дата создания"',
            'updated_at' => $this->timestamp()->notNull() . ' COMMENT "Дата обновления"',
        ]);

        $this->addForeignKey('page_credentials_link_id_fk', 'link_credentials', 'link_id', 'links', 'id');
        $this->addForeignKey('page_credentials_role_id_fk', 'link_credentials', 'role_id', 'roles', 'id');

        $this->createIndex('page_credentials_page_and_role_idx', 'link_credentials', [
            'link_id', 'role_id',
        ], true);
    }

    public function down()
    {
        $this->dropTable('link_credentials');
    }
}
