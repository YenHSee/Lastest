<?php

use yii\db\Migration;

/**
 * Class m180227_021406_user
 */
class m180227_021406_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'password' => $this->string(),
            'verifycode' => $this->string(),
            'name' => $this->string(),
            'email' => $this->string()->notNull(),
            'security_question' => $this->string(),
            'security_answer' => $this->string(),
            'last_logging' => 'timestamp on update current_timestamp',
            'is_deleted' => $this->boolean()->defaultValue(false),
            'updated_at' => 'timestamp on update current_timestamp',
            'created_at' => $this->timestamp()->defaultValue(0),   
        ]);
        //$this->alterColumn('{{$user}}', 'id', $this->integer()->notNull(). 'AUTO_INCREMENT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

}
