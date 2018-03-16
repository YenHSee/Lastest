<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = 'Transaction Confirmation';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?= Html::encode($this->title) ?></h1>

	<?php $form = ActiveForm::begin(['id' => 'form-duringTransfer']); ?>

		<div><h4>Sender Information</h4>
			<div class="row">
				<div class="col-lg-3">
					<?= $form->field($model, 'from_account') -> label('From Account') -> textInput(['readonly' => true]) ?>
				</div>
			    <div class="col-lg-3">
			    	<?= $form->field($model, 'available_balance')-> label('Available Balance') -> textInput(['readonly' => true]) ?>
			    </div>
			</div>

		<div><h4>Security Purpose</h4>
			<div class="row">
				<div class="col-lg-3">
					<?= $form->field($model, 'pinNumber') -> label(false) -> textInput(['placeholder' => "Please Enter Pin Number"]) ?>
				</div>
				<div class="col-lg-3">
					<?= Html::submitButton('Request', ['name' => 'submit', 'value' => 'getPin','class'=> 'btn btn-info']); ?>
				</div>
			</div>
		</div>

		<div><h4>Receiver Information</h4>
			<div class="row">
				<div class="col-lg-3">
					<?= $form->field($model, 'to_account') -> label('To Account') -> textInput(['readonly' => true]) ?>
				</div>
			    <div class="col-lg-3">
			    	<?= $form->field($model, 'name')-> label('Name') -> textInput(['readonly' => true]) ?>
			    </div>
			</div>

			<div class="row">
				<div class="col-lg-3">
			    	<?= $form->field($model, 'amount')-> label('Amount') -> textInput(['readonly' => true]) ?>
			    </div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<?= $form->field($model, 'details') -> label('Details') -> textarea(['readonly' => true]); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="pull-right">
					<?= Html::submitButton('Transfer', ['name' => 'submit', 'value' => 'transfer', 'class'=> 'btn btn-primary']); ?>
				</div>
			</div>
		</div>

	<?php ActiveForm::end(); ?>

</div>