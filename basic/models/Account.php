<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property int $user_id
 * @property string $account_number
 * @property double $available_balance
 * @property double $current_balance
 * @property string $created_at
 * @property string $update_at
 * @property int $is_deleted
 *
 * @property User $user
 * @property Transaction[] $transactions
 * @property Transaction[] $transactions0
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    // public function rules()
    // {
    //     return [
    //         [['user_id'], 'required'],
    //         [['user_id'], 'integer'],
            // [['available_balance', 'current_balance'], 'number'],
            // [['created_at', 'update_at'], 'safe'],
            // [['account_number'], 'string', 'max' => 255],
    //         [['is_deleted'], 'string', 'max' => 1],
    //         [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
    //     ];
    // }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'account_number' => 'Account Number',
            'available_balance' => 'Available Balance',
            'current_balance' => 'Current Balance',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['from_account' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions0()
    {
        return $this->hasMany(Transaction::className(), ['to_account' => 'id']);
    }
}
