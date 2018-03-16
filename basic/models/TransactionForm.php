<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Exception;
use app\models\Account;   


class TransactionForm extends Model
{
    public $user_id;
    public $to_account;
    public $from_account;
    public $name;
    public $available_balance;
    public $amount;
    public $last_balance;
    public $status;
    public $details;
    public $remark;
    public $pinNumber;
    public $email;
    public $is_deleted;
    public $updated_at;
    public $created_at;

    // public static function tableName()
    // {
    //     return 'transaction';
    // }
	public function rules()
    {
        return [
            [['to_account', 'amount', 'details'], 'safe'],
        ];
    }

    public function transaction()
    {
        //throw new Exception(var_export($this->to_account,1));
       if(!$this->validate()) 
        {
            throw new  Exception("Error Processing Request Due to Violation of Rules", 1);
        } 
        else
        {
            $db = Yii::$app->db->beginTransaction();
            try 
            {
                if ($this->available_balance < $this->amount)
                {
                    throw new Exception("Your Balance Is Not Enough", 1);
                }
                else
                {
                    $sender = new Transaction();
                    $sender->user_id = Yii::$app->user->identity->id;
                    // throw new Exception(var_export($sender->user,1));
                    $sender->to_account = $this->to_account;
                    $sender->from_account = $this->from_account;
                    $sender->name = $this->name;
                    $sender->amount = $this->amount;
                    $sender->last_balance = $this->getLastBalance($sender->user_id);
                    // throw new Exception(var_export($sender->last_balance,1));
                    $sender->status = 'OUT';
                    $sender->details = $this->details;
                    $sender->remark = 'Pending';
                    $sender->created_at = date('Y-m-d H:i:s');
                    if (!$sender->save())
                    {
                        throw new Exception(current($sender->getFirstErrors()));
                    }
                    else
                    {
                        $receiver = new Transaction();
                        // throw new Exception(var_export($sender->to_account,1));
                        $receiver->user_id = $this->getReceiverId($sender->to_account);
                        $receiver->from_account = $sender->to_account;
                        $receiver->to_account = $this->from_account;
                        $receiver->name = $this->name;
                        $receiver->amount = $this->amount;
                        // throw new Exception(var_export($this->available_balance,1));
                        $receiver->last_balance = $this->getLastBalance($receiver->user_id);
                        $receiver->status = 'IN';
                        $receiver->details = $this->details;
                        $receiver->remark = 'Pending';
                        $receiver->created_at = date('Y-m-d H:i:s');
                        if(!$receiver->save())
                        {
                            throw new Exception(current($receiver->getFirstErrors()));
                        }
                        else
                        {
                            $this->changeAccountDetails($sender->user_id, $receiver->user_id, $receiver->amount);
                            $db->commit();
                        }
                    }
                }
            } catch (Exception $e) 
                {
                    $db->rollback();
                    throw new Exception($e, 1);
                }
        }
    }

    public function changeAccountDetails($senderAccount, $receiverAccount, $transactionAmount)
    {
        $db = Yii::$app->db->beginTransaction();
            try 
            {   
                $sender = Account::find()
                            ->where(['user_id' => $senderAccount])
                            ->one();
                // throw new Exception(var_export($sender,1));
                $sender->available_balance = ($sender->available_balance - $transactionAmount);
                $sender->current_balance = $sender->available_balance + 20;
                // throw new Exception(var_export($sender->current_balance,1));
                if(!$sender->save())
                {
                    throw new Exception(current($sender->getFirstErrors()));
                }
                else
                {
                    $receiver = Account::find()
                    ->where(['user_id' => $receiverAccount])
                    ->one();
                    $receiver->available_balance = ($receiver->available_balance + $transactionAmount);
                    $receiver->current_balance = $receiver->available_balance + 20;
                    // throw new Exception(var_export($receiver->current_balance,1));
                    if(!$receiver->save())
                    {
                        throw new Exception(current($receiver->getFirstErrors()));
                    }
                    else
                    {
                        $db->commit();
                    }
                }
            } catch (Exception $e) 
              {
                $db->rollback();
                throw new Exception($e, 1);
              }
    }

    // public function sendMail()
    // {
        
    //     $this->layout = '@app/mail/layouts/html';
    //     $recipient = [
    //         [
    //             'email' => 'email@pentajeu.com',
    //             'name' => 'NAME',
    //             'type' => 'to'
    //         ]
    //     ];

    //     $subject = "TESTING EMAIL";
    //     $message = "testing 123";

    //     $content = $this->render('@app/mail/html', ['model' => $model]);

    //     $mandrill = Yii::$app->mandrill->instance;
    //     $message = Yii::$app->mandrill->message;
    //     $message['to'] = $recipient;
    //     $message['html'] = $content;
    //     $message['subject'] = $subject;

    //     $status = $mandrill->messages->send($message, false, "Test", null);
    //     echo var_export($status,true) . "\n";
    // }

    public function getLastBalance($user_id)
    {
        $balance = Account::find()
                    ->select('available_balance')
                    ->where(['user_id' => $user_id])
                    ->one();
        return $this->available_balance = $balance->available_balance;
    }

    public function getReceiverId($to_account)
    {
        $account = Account::find()
                    ->select('user_id')
                    ->where(['account_number' => $to_account])
                    ->one();
        return $account->user_id;
    }

    public function getAccount($user_id)
    {
        $account = Account::find($user_id)
                    ->where(['user_id' => $user_id])
                    ->one();
        $this->from_account = $account->account_number;
        $this->available_balance = $account->available_balance;
        return $account;
    }

}