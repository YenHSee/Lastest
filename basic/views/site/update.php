<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = 'Update';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-update">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'form-update']); ?>
				<?= $form->field($model, 'name') -> label('Name') -> textInput() ?>
				<?= $form->field($model, 'email')-> input('email') ?>
				<div class="form-group">
					<?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>