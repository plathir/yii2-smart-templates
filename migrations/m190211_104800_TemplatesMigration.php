<?php

use yii\db\Migration;

/**
 * Class m190210_141936_BaseMigration
 */
class m190211_104800_TemplatesMigration extends Migration {

    public function up() {

        $this->CreateTemplatesTypesTable();
        $this->CreateTemplatesTable();
    }

    public function down() {

        $this->dropIfExist('templates');
        $this->dropIfExist('templates_types');
    }

    public function CreateTemplatesTypesTable() {
        $this->dropIfExist('templates_types');

        $this->createTable('templates_types', [
            'name' => $this->string(50)->notNull(),
            'descr' => $this->string()->notNull(),
        ]);

        $this->addPrimaryKey('pk_name', 'templates_types', ['name']);
    }

    public function CreateTemplatesTable() {
        $this->dropIfExist('templates');

        $this->createTable('templates', [
            'id' => $this->integer(11)->notNull(),
            'type' => $this->string(50)->notNull(),
            'descr' => $this->string(255)->notNull(),
            'text' => $this->string()->notNull(),
        ]);

        $this->addPrimaryKey('pk_id', 'templates', ['id']);
        $this->addForeignKey('fk_type', 'templates', 'type', 'templates_types', 'name', 'CASCADE', 'CASCADE');
    }

    public function dropIfExist($tableName) {
        if (in_array($tableName, $this->getDb()->schema->tableNames)) {
            $this->dropTable($tableName);
        }
    }

}
