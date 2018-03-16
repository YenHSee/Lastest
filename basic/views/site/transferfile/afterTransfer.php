<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Transaction Successful';
?>

<div>
	<h1><?= Html::encode($this->title) ?></h1>

	<?= DetailView::widget([
		'model' = $model,
		'attributes' => [
			'user_id',
			'to_account',
			'from_account',
			'name',
			'amount',
			'status',
			'details',
			'remark',
			'created_at',
		],
	]) ?>

</div>