<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Exception;
use yii\data\ActiveDataProvider;
use app\models\User;
	
class SearchForm extends Model
{
	public $id;
	public $username;
	public $role;
    public $name;
    public $email;

    public function rules()
    {
        return [
            // ... more stuff here
            [['username', 'role', 'name', 'email'], 'safe'],
            // ... more stuff here
        ];
    }

	public function search($params)
	{
	    $query = User::find()
	    ->where(['is_deleted' => 0])
	    ->orderBy('id');

	   	 $dataProvider = new ActiveDataProvider([
	        'query' => $query,
	    ]);

	    $this->load($params);

	    // if (!$this->validate()) {
	    // 	throw new Exception("Error Processing Request", 1);
	    // 	return $dataProvider;
	    // }


	    // $query->andFilterWhere([
	    // 	'like', 'username', $this->username ,
	    // 	'or', 'role', $this->username ,
	    // 	'or', 'name', $this->username ,
	    // 	'or', 'email', $this->username ,
	    // ]);



	    $query->andFilterWhere(['like', 'username', $this->username ])
	        ->orFilterWhere(['like ', 'role', $this->username])
	        ->orFilterWhere(['like', 'name', $this->username])
	        ->orFilterWhere(['like', 'email', $this->username]);

	 //    $query->andWhere('username LIKE "%' . $this->username . '%" '.
	 //    	'OR role LIKE "%' . $this->role . '%"'.
	 //    	'OR name LIKE "%' . $this->name . '%"'.
	 //    	'OR email LIKE "%' . $this->email . '%"'
		// );

	    return new ActiveDataProvider([
	    	'query' => $query,
	    ]);
	}
}
          // $query = User::find()
          //   ->where(['is_deleted' => 0])
          //   ->orderBy('id');
          //   $dataProvider = new ActiveDataProvider([
          //       'query' => $query,
          //       ]);