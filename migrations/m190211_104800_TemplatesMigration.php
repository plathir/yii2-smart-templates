<?php

use yii\db\Migration;

/**
 * Class m190210_141936_BaseMigration
 */
class m190211_104800_TemplatesMigration extends Migration {

    public function up() {

        $this->CreateTemplatesTypesTable();
        $this->CreateTemplatesTable();
        $this->CreateTemplatesThemesTable();
    }

    public function down() {

        $this->dropIfExist('templates_themes');
        $this->dropIfExist('templates');
        $this->dropIfExist('templates_types');
    }

    public function CreateTemplatesTypesTable() {
        $this->dropIfExist('templates_types');

        $this->createTable('{{%templates_types}}', [
            'name' => $this->string(50)->notNull(),
            'descr' => $this->string()->notNull(),
            'avail_fields' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_name', '{{%templates_types}}', ['name']);
    }

        public function CreateTemplatesThemesTable() {
        $this->dropIfExist('templates_themes');

        $this->createTable('{{%templates_themes}}', [
            'name' => $this->string(50)->notNull(),
            'descr' => $this->string()->notNull(),
            'version' => $this->string(40)->notNull(),
            'backend' => $this->integer()->notNull(), //int(11) NOT NULL,
            'frontend' => $this->integer()->notNull(), //int(11) NOT NULL,
            'created_at' => $this->integer()->notNull(), //int(11) NOT NULL,
            'created_by' => $this->integer()->notNull(), //int(11) NOT NULL,
            'updated_at' => $this->integer()->notNull(), //int(11) NOT NULL,
            'updated_by' => $this->integer()->notNull(), //int(11) NOT NULL,
            'locked' => $this->integer()->notNull(), // int(11) DEFAULT NULL                        
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_name', '{{%templates_themes}}', ['name']);
    }

    
    
    
    public function CreateTemplatesTable() {
        $this->dropIfExist('templates');

        $this->createTable('{{%templates}}', [
            'id' => $this->integer(11)->notNull(),
            'type' => $this->string(50)->notNull(),
            'descr' => $this->string(255)->notNull(),
            'text' => $this->string()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk_id', '{{%templates}}', ['id']);
        $this->addForeignKey('fk_type', '{{%templates}}', 'type', '{{%templates_types}}', 'name', 'CASCADE', 'CASCADE');
    }

    public function dropIfExist($tableName) {
        if (in_array($this->db->tablePrefix .$tableName, $this->getDb()->schema->tableNames)) {
            $this->dropTable($this->db->tablePrefix .$tableName);
        }
    }

}
