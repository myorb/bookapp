<?php

use yii\db\Schema;
use yii\db\Migration;

class m150803_210410_create_book_table extends Migration
{
    public function up()
    {
        $this->createTable('book', [
            'id' => Schema::TYPE_PK,

            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'preview' => Schema::TYPE_STRING . ' NULL DEFAULT NULL',
            'author_id' => Schema::TYPE_SMALLINT . ' NULL DEFAULT 0',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function down()
    {
        $this->dropTable('book');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
