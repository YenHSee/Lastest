<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

    <style>
        form#multiphase > #phase2, #phase3, #show_all_data{ display:none; }
    </style>
    <script>
    	function _(x) {
            return document.getElementById(x);
        }

        function processPhase1() {
            username = _("username").value;
            password = _("password").value;
            confirm_password = _("confirm_password").value;
            security_question = _("signupform-security_question").value;
            security_answer = _("security_answer").value;
            _("phase1").style.display = "none";
            _("phase2").style.display = "block";
            _("progressBar").style.width = 25 + "%";
            _("status").innerHTML = "Phase 2 of 4";
        }

        function processBack1() {
            _("phase1").style.display = "block";
            _("phase2").style.display = "none";
            _("progressBar").style.width = 0 + "%";
            _("status").innerHTML = "Phase 1 of 4";
        }

        function processPhase2() {
            name = _("name").value;
            email = _("signupform-email").value;
            _("phase2").style.display = "none";
            _("phase3").style.display = "block";
            _("progressBar").style.width = 50 + "%";
            _("status").innerHTML = "Phase 3 of 4";
        }

        function processBack2() {
            _("phase2").style.display = "block";
            _("phase3").style.display = "none";
            _("progressBar").style.width = 25 + "%";
            _("status").innerHTML = "Phase 2 of 4";
        }

        function processPhase3() {
            accountnumber = _("account_number").value;
            balance = _("available_balance").value;
            _("phase3").style.display = "none";
            _("show_all_data").style.display = "block";
            _("progressBar").style.width = 75 + "%";
            _("status").innerHTML = "Phase 4 of 4";
        }

        function processBack3() {
            _("phase3").style.display = "block";
            _("show_all_data").style.display = "none";
            _("progressBar").style.width = 50 + "%";
            _("status").innerHTML = "Phase 3 of 4";
        }

        function processPhase4() {
            // postcode = _("postcode").value;
            // country = _("signupform-country").value;
            // city = _("signupform-city").value;
            // state = _("signupform-state").value;
            // address = _("address").value;
            _("show_all_data").style.display = "block";
            _("phase3").style.display = "none";
            _("progressBar").style.width = 100 + "%";
            _("status").innerHTML = "Phase 4 of 4";
        }

        function processBack4() {
            _("phase3").style.display = "block";
            _("show_all_data").style.display = "none";
            _("progressBar").style.width = 75 + "%";
            _("status").innerHTML = "Phase 3 of 4";
        }

        function submitForm() {
            _("multiphase").method = "post";
            _("multiphase").action = "signup";
            _("multiphase").submit();
        }
    </script>

<body>
    <div class="progress">
        <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <h3 id="status">Phase 1 of 4 </h3>

    <?php $form = ActiveForm::begin([
        'id' => 'multiphase',
        'options' => [
                'onsubmit' => 'return false'
            ]
        ]); ?>

        <!-- <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->getCsrfToken()?>" /> -->
        <div id="phase1" class="form-group" >
            <div class="form-group">
                <?= $form->field($model, 'username')->textInput([
                    'maxlength' => true,
                    'id' => 'username',
                    'placeholder' => 'Please Enter Username'
                    ]) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput([
                    'maxlength' => true,
                    'id' => 'password',
                    'placeholder' => 'Please Enter Password'
                    ]) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'confirm_password')->passwordInput([
                    'maxlength' => true,
                    'id' => 'confirm_password'
                    ]) ?>
            </div>
            
            <div class="form-group">
                <?= $form->field($model, 'security_question')->dropDownList([
                    'Are you dog?' => 'Are you dog?', 
                    'Are you cat?' => 'Are you cat?'],
                    ['prompt' => '---Select Data---'
                    ]) ?>
            </div>
           
            <div class="form-group">
                <?= $form->field($model, 'security_answer')->textInput([
                    'maxlength' => true,
                    'id' => 'security_answer'
                    ]) ?>
            </div>

            <div>
                <span class="pull-right">
                    <?= Html::submitButton('Continue', ['class' => 'btn btn-success', 'onclick' => 'processPhase1()']) ?>
                </span>
            </div>    
        </div>

        <div id="phase2" class="form-group">
            <div class="form-group">
                <?= $form->field($model, 'name')->textInput([
                    'maxlength' => true,
                    'id' => 'name',
                    'placeholder' => 'Enter Your Name'
                    ]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'email')-> input('email') ?>
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

        <div id="phase3" class="form-group">
            <div class="form-group">
                <?= $form->field($model, 'account_number')->textInput([
                    'maxlength' => true,
                    'id' => 'account_number'
                    ]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'available_balance')->textInput([
                    'maxlength' => true,
                    'id' => 'available_balance'
                    ]) ?>
            </div>
            <div>
                <span class="pull-left">
                    <?= Html::submitButton('Back', ['class' => 'btn btn-success', 'onclick' => 'processBack2()']) ?>
                </span>
                <span class="pull-right">
                    <?= Html::submitButton('Continue', ['class' => 'btn btn-success', 'onclick' => 'processPhase3()']) ?>
                </span>
            </div>
        </div>

        <div id="show_all_data">
            <table class="table table-striped">
                <tbody>
<!--                     <tr>
                        <td>Country: </td>
                        <td><span id="display_country"></span></td>
                    </tr>
                    <tr>
                        <td>City: </td>
                        <td><span id="display_city"></span></td>
                    </tr>
                    <tr>
                        <td>State: </td>
                        <td><span id="display_state"></span></td>
                    </tr>
                    <tr>
                        <td>Postcode: </td>
                        <td><span id="display_postcode"></span></td>
                    </tr> -->
                </tbody>
            </table>

            <div>
                <span class="pull-left">
                    <?= Html::submitButton('Back', ['class' => 'btn btn-success', 'onclick' => 'processBack3()']) ?>
                </span>
                <span class="pull-right">
                    <?= Html::submitButton('Continue', ['class' => 'btn btn-success', 'onclick' => 'submitForm()']) ?>
                </span>
            </div>
        </div>
    </form>
    <?php ActiveForm::end(); ?>
</body>