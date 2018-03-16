<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;



$this->title = 'Export';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-Export">
	<h1><?= Html::encode($this->title) ?></h1>
	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'form-Export']); ?>
				<?= $form->field($model, 'id') -> label('Please Enter ID') -> textInput() ?>
				<div class="form-group">
					<?= Html::submitButton('Export', ['class' => 'btn btn-primary', 'name' => 'export-button']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>