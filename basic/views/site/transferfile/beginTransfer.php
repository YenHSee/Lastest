<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = 'Transaction';
$this->params['breadcrumbs'][] = $this->title;
?>


<div>
	<h1><?= Html::encode($this->title) ?></h1>

	<?php $form = ActiveForm::begin(['id' => 'form-begintransfer']); ?>

		<div class="row">
			<div class="col-lg-3">
				<?= $form->field($model, 'from_account') -> label('From Account') -> textInput(['readonly' => true]) ?>
			</div>
		    <div class="col-lg-3">
		    	<?= $form->field($model, 'available_balance')-> label('Available Balance') -> textInput(['readonly' => true]) ?>
		    </div>
		</div>

		<div class="row">
			<div class="col-lg-3">
				<?= $form->field($model, 'to_account') -> label('To Account') -> textInput() ?>
			</div>
		    <div class="col-lg-3">
		    	<?= $form->field($model, 'amount')-> label('Amount') -> textInput() ?>
		    </div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<?= $form->field($model, 'details') -> label('Details') -> textarea(array('rows'=>4,'cols'=>5)); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="pull-right">
					<?= Html::submitButton('Submit', ['class'=> 'btn btn-primary']); ?>
				</div>
			</div>
		</div>

	<?php ActiveForm::end(); ?>

</div>