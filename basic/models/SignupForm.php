<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\models\User;
use app\models\Account;    
use Exception;

class SignupForm extends Model
{
	public $username;
	public $password;
    public $confirm_password;
	public $role;
    public $name;
    public $email;
    public $security_question;
    public $security_answer;
    public $last_logging;
    public $account_number;
    public $available_balance;
    public $is_deleted;
    public $updated_at;
    public $created_at;

	public function rules()
    {
        return [
            ['username', 'required'],
            ['password', 'required'],
            ['confirm_password', 'required'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message' => 'Passwords no match'],
            ['name', 'required', 'message' => 'Please Enter a Name'],
            ['email', 'email'],
            [['available_balance'], 'number'],
            [['account_number'], 'number'],
            [['security_question', 'security_answer'], 'required', 'message' => 'Please Enter for Security Purpose'],
        ];
    }

    public function signup()
    {
        if(!$this->validate()) 
        {
            throw new  Exception("Error Processing Request Due to Violation of Rules", 1);
        } 
        else
        {
            $user = new User();
            $db = Yii::$app->db->beginTransaction();
            try 
            {
                $user->username = $this->username;
                //$user->password = $this->password;
                $user->password = crypt($this->password, 'DontTry');
                //$user->role = $this->role;
                $user->name = $this->name;
                $user->email = $this->email;
                $user->security_question = $this->security_question;
                $user->security_answer = $this->security_answer;
                $user->created_at = date('Y-m-d H:i:s');
                $user->updated_at = new Expression('NOW()');
                $user->is_deleted = 0;
                if(!$user->save()) 
                {
                    throw new Exception(current($user->getFirstErrors()), 1);
                }
                else 
                {
                    $account = new Account();
                    $account->user_id = $user->id;
                    $account->account_number = $this->account_number;
                    $account->available_balance = $this->available_balance-20;
                    $account->current_balance = $this->available_balance;
                    $account->created_at = date('Y-m-d H:i:s');
                    $account->update_at = date('Y-m-d H:i:s');
                    $account->is_deleted = 0;
                    if(!$account->save())
                    {
                        throw new Exception(current($account->getFirstErrors()), 1);
                    }
                    else
                    {
                        $db->commit();
                        return $user;
                    }
                }
            } catch (Exception $e) 
                {
                    $db->rollback();
                    throw new Exception($e, 1);
                }
        }
    }
}