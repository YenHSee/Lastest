<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `account`
 * - `account`
 */
class m180312_094445_create_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'to_account' => $this->integer()->notNull(),
            'from_account' => $this->integer()->notNull(),
            'name' => $this->string(),
            'amount' => $this->double(),
            'last_balance' => $this->double(),
            'status' => $this->string(),
            'details' => $this->string(),
            'remark' => $this->string(),
            'verify_code' => $this->string(),
            'created_at' => $this->timestamp()->defaultValue(null),
            'update_at' => 'timestamp on update current_timestamp',
            'is_deleted' => $this->boolean()->defaultValue(false),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-transaction-user_id',
            'transaction',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-transaction-user_id',
            'transaction',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `to_account`
        $this->createIndex(
            'idx-transaction-to_account',
            'transaction',
            'to_account'
        );

        // add foreign key for table `account`
        $this->addForeignKey(
            'fk-transaction-to_account',
            'transaction',
            'to_account',
            'account',
            'accountnumber',
            'CASCADE'
        );

        // creates index for column `from_account`
        $this->createIndex(
            'idx-transaction-from_account',
            'transaction',
            'from_account'
        );

        // add foreign key for table `account`
        $this->addForeignKey(
            'fk-transaction-from_account',
            'transaction',
            'from_account',
            'account',
            'accountnumber',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-transaction-user_id',
            'transaction'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-transaction-user_id',
            'transaction'
        );

        // drops foreign key for table `account`
        $this->dropForeignKey(
            'fk-transaction-to_account',
            'transaction'
        );

        // drops index for column `to_account`
        $this->dropIndex(
            'idx-transaction-to_account',
            'transaction'
        );

        // drops foreign key for table `account`
        $this->dropForeignKey(
            'fk-transaction-from_account',
            'transaction'
        );

        // drops index for column `from_account`
        $this->dropIndex(
            'idx-transaction-from_account',
            'transaction'
        );

        $this->dropTable('transaction');
    }
}
