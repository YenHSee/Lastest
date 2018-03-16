<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = 'Transaction';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
        form#multiphase > #phase2, #show_all_data{ display:none; }
    </style>
    <script>
    	function _(x) {
            return document.getElementById(x);
        }

        function processPhase1() {
            from_account = _("from_account").value;
            to_account = _("to_account").value;
            available_balance = _("available_balance").value;
            amount = _("amount").value;
            details = _("details").value;
            
            _("phase1").style.display = "none";
            _("phase2").style.display = "block";
            _("status").innerHTML = "Transaction Confirmation";
        }

        function processBack1() {
            _("phase1").style.display = "block";
            _("phase2").style.display = "none";
            _("status").innerHTML = "Transaction";
        }

        function processPhase2() {
            pinNumber = _("pinNumber").value;
            name = _("name").value;
            _("show_from_account").innerHTML = from_account;
            _("show_to_account").innerHTML = to_account;
            _("show_details").innerHTML = details;
            _("show_amount").innerHTML = amount;
            _("show_recipient").innerHTML = name;
            _("phase2").style.display = "none";
            _("show_all_data").style.display = "block";
            _("status").innerHTML = "Transaction Information";
        }

        function processBack2() {
            _("phase2").style.display = "block";
            _("show_all_data").style.display = "none";
            _("status").innerHTML = "Transaction Confirmation";
        }

        function processPhase3() {
            _("show_from_account").innerHTML = from_account;
            _("show_to_account").innerHTML = to_account;
            _("show_details").innerHTML = details;
            _("show_amount").innerHTML = amount;
            _("show_recipient").innerHTML = name;
            // _("phase2").style.display = "none";
            // _("show_all_data").style.display = "block";
            _("show_all_data").style.display = "block";
            _("status").innerHTML = "Transaction Information";
        }

        function submitForm() {
            _("multiphase").method = "post";
            _("multiphase").action = "transfer";
            _("multiphase").submit();
        }
    </script>
<body>
    <h3 id="status">Transaction</h3>

    <?php $form = ActiveForm::begin([
        'id' => 'multiphase',
        'options' => [
                'onsubmit' => 'return false'
            ]
        ]); ?>

        <div id="phase1" class="form-group" >
            <div class="form-group">
                <?= $form->field($model, 'from_account')->textInput([
                    'maxlength' => true,
                    'id' => 'from_account',
                    'value' => $model->from_account,
                    'readonly' => true
                    ]) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'available_balance')->textInput([
                    'maxlength' => true,
                    'id' => 'available_balance',
                    'value' => $model->available_balance,
                    'readonly' => true
                    ]) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'to_account')->textInput([
                    'maxlength' => true,
                    'id' => 'to_account'
                    ]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'amount')->textInput([
                    'maxlength' => true,
                    'id' => 'amount'
                    ]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'details')->textInput([
                    'maxlength' => true,
                    'id' => 'details'
                    ]) ?>
            </div>

            <div>
                <span class="pull-right">
                    <?= Html::submitButton('Next', ['class' => 'btn btn-success', 'onclick' => 'processPhase1()']) ?>
                </span>
            </div>    
        </div>

        <div id="phase2" class="form-group">
            <div class="form-group">
                <?= $form->field($model, 'from_account')->textInput([
                    'maxlength' => true,
                    'id' => 'from_account',
                    'readonly' => true
                    // 'value' => $model->from_account
                    ]) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'available_balance')->textInput([
                    'maxlength' => true,
                    'id' => 'available_balance',
                    // 'readonly' => true
                    //'value' => $model->current_balance
                    ]) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'to_account')->textInput([
                    'maxlength' => true,
                    'id' => 'to_account',
                    // 'value' => ,
                    // 'readonly' => true,
                    ]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'name')->textInput([
                    'maxlength' => true,
                    'id' => 'name',
                    // 'readonly' => true
                    ]) ?>
            </div>
           
            <div class="form-group">
                <?= $form->field($model, 'details')->textInput([
                    'maxlength' => true,
                    'id' => 'remark',
                    // 'readonly' => true
                    ]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'pinNumber')->textInput([
                    'maxlength' => true,
                    'id' => 'pinNumber'
                    ]) ?>
            </div>

            <div>
                <span class="pull-left">
                    <?= Html::submitButton('Back', ['class' => 'btn btn-success', 'onclick' => 'processBack1()']) ?>
                </span>
                <span class="pull-right">
                    <?= Html::submitButton('Continue', ['class' => 'btn btn-success', 'onclick' => 'processPhase2()']) ?>
                </span>
            </div>
        </div>

        <div id="show_all_data">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>From Account:</td>
                        <td><span id="show_from_account"></span></td>
                    </tr>
                    <tr>
                        <td>Amount:</td>
                        <td><span id="show_amount"></span></td>
                    </tr>
                    <tr>
                        <td>To Account</td>
                        <td><span id="show_to_account"></span></td>
                    </tr>
                    <tr>
                        <td>Name of Recipient:</td>
                        <td><span id="show_recipient"></span></td>
                    </tr>
                    <tr>
                        <td>Remark:</td>
                        <td><span id="show_details"></span></td>
                    </tr>
                </tbody>
            </table>

            <div>
                <span class="pull-right">
                    <?= Html::submitButton('Transfer', ['class' => 'btn btn-success', 'onclick' => 'submitForm()']) ?>
                </span>
            </div>
        </div>
    </form>
    <?php ActiveForm::end(); ?>
</body>
