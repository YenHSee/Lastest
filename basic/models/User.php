<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string $name
 * @property string $email
 * @property string $security_question
 * @property string $security_answer
 * @property string $last_logging
 * @property int $is_deleted
 * @property string $updated_at
 * @property string $created_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $auth_key;
    const SCENARIO_CREATE = 'create';

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    // public function rules()
    // {
    //     return [
    //         [['email'], 'required'],
    //         [['last_logging', 'updated_at', 'created_at'], 'safe'],
    //         [['username', 'password', 'role', 'name', 'email', 'security_question', 'security_answer'], 'string', 'max' => 255],
    //         [['is_deleted'], 'number'],
    //         [['email'], 'unique'],
    //     ];
    // }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'password'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'role' => 'Role',
            'name' => 'Name',
            'email' => 'Email',
            'security_question' => 'Security Question',
            'security_answer' => 'Security Answer',
            'last_logging' => 'Last Logging',
            'is_deleted' => 'Is Deleted',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    // public static function findByRole($role)
    // {
    //     return static::findOne(['role' => $role]);
    // }

    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    { 
        if ($this->password === crypt($password, 'DontTry')) {
            return true;
        }
        else {
            throw new \Exception("Password Incorrect", 1);
        }
       //return $this->password == ($password);
       //return ($this->password === crypt($password,'DontTry'));
    }

    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }



}
