<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $user_id
 * @property int $to_account
 * @property int $from_account
 * @property string $name
 * @property double $amount
 * @property double $last_balance
 * @property string $status
 * @property string $details
 * @property string $remark
 * @property string $created_at
 * @property string $update_at
 * @property int $is_deleted
 *
 * @property Account $fromAccount
 * @property Account $toAccount
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'to_account', 'from_account'], 'required'],
            [['user_id', 'to_account', 'from_account'], 'integer'],
            [['amount', 'last_balance'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'to_account' => 'To Account',
            'from_account' => 'From Account',
            'name' => 'Name',
            'amount' => 'Amount',
            'last_balance' => 'Last Balance',
            'status' => 'Status',
            'details' => 'Details',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'from_account']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'to_account']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
