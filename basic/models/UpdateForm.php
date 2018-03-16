<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Exception;


class UpdateForm extends Model
{
    public $name;
    public $email;
    public $updated_at;

    protected $_user;

	public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Please Enter a Name'],
            ['email', 'email'],
        ];
    }

    public function update($id)
    {
        if(!$this->validate()) 
        {
            throw new  Exception("Error Processing Request Due to Violation of Rules", 1);
        } 
        else
        {
            $db = Yii::$app->db->beginTransaction();
            try 
            {   
                $user = User::findOne($id);
                $user->name = $this->name;
                $user->email = $this->email;
                $user->updated_at = new Expression('NOW()');
                if (!$user->save()) {
                    throw new Exception(current($user->getFirstError));
                }
                else {
                    $db->commit();
                    return $user;
                }
            } catch (Exception $e) 
              {
                $db->rollback();
                throw new Exception($e, 1);
              }
        }
    }
}