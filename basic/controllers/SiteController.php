<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\ExportForm;
use app\models\TransactionForm;
use app\forms\TransferForms\TransferForm;
use app\models\User;
use app\models\UpdateForm;
use Exception;
use yii\data\ActiveDataProvider;
use kartik\base\Widget;
use kartik\dialog\DialogAsset;
use yii\web\ForbiddenHttpException;
use yii\db\ActiveRecord;
use app\models\SearchForm;
use kartik\export\ExportMenu;
use kartik\mpdf\Pdf;
use mPDF;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //if post will error
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        //throw new Exception(Yii::$app->params['randomKey']);
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                Yii::$app->session->setFlash('signupSuccess');
                return $this->redirect(['view']);
            }
            else {
                throw new Exception(current($model->getFirstErrors()));
            }
        }   
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionView()
    {
        Yii::$app->session->setFlash('successs', 'You have signup success');
        if (Yii::$app->user->can('view_profile'))
        {
            $searchModel = new SearchForm();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('view', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionTransfer()
    {
        $model = new TransactionForm();
        $model->getAccount(Yii::$app->user->identity->id);
        $model->to_account = "123431";
        // $model->getAccountNumber();
        // $model->getAccountBalance();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->transaction()) {
                return $this->redirect(['transaction']);
            }
            else {
                // throw new Exception(current($model->getFirstErrors()));
            }
        }
        return $this->render('transaction', [
            'model' => $model,
        ]);
    }

    public function actionSendMoney()
    {
        $model = new TransferForm();
        // $receiver = $model->findReceiver($model->to_account);

        $model->getAccount(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validateBalance($model->available_balance, $model->amount)) {
                if( $model->findReceiver($model->to_account)) {
                    
                    switch (\Yii::$app->request->post('submit')) {
                        case 'getPin':
                            // throw new Exception(var_export($user,1));
                            // $model->sendEmail();
                            // throw new Exception("Go get Pin", 1);
                        case 'transfer':
                            // throw new Exception("Go to transfer", 1);
                    }
                    $model->pendingSender();                      
                    return $this->render('Transferfile\duringTransfer', [
                    'model' => $model]);
                }
            }
        }
        return $this->render('transferfile\beginTransfer', [
            'model' => $model,
        ]);

        // $model = new TransferForm();
        // $model->getAccount(Yii::$app->user->identity->id);

        // if ($model->load(Yii::$app->request->post())) {
        //     if ($model->validateBalance($model->available_balance, $model->amount)) {
        //         if( $model->findReceiver($model->to_account)) {
                      // if (Yii::$app->request->post('submit') === 'getPin') {
                      //   throw new Exception("Go get Pin", 1);
                      // }
                      // if (Yii::$app->request->post('submit') === 'transfer') {
                      //   throw new Exception("Go Transfer", 1);
                      // }
        //             return $this->render('Transferfile\duringTransfer', [
        //             'model' => $model,]);
        //         }
        //     }
        // }
        // return $this->render('transferfile\beginTransfer', [
        //     'model' => $model,
        // ]);        
    }

    public function actionDelete($id)
    {
        $user = User::findOne($id);
        $user->is_deleted = 1;
        $user->save(false);
        return $this->redirect(['view']);
    }

    public function actionUpdate($id)
    {
        $model = new UpdateForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->update($id)) {
                    return $this->redirect(['view' , 'id' => Yii::$app->user->identity->id]);
                }
            else {
                    throw new Exception("Update Problem", 1);
                }
        }        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function findModel($id)
    {
        if (($model = User::findOne($id)) !== null)
            {
                return $model;
            }
            throw NotFoundHttpException('Nothing');
    }
}
