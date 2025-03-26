<?php

namespace backend\modules\judiciary\controllers;

use \backend\modules\contractDocumentFile\models\ContractDocumentFile;
use \backend\modules\contracts\models\Contracts;
use \backend\modules\contractCustomers\models\ContractsCustomers;
use backend\modules\customers\models\Customers;
use backend\modules\expenses\models\Expenses;
use \backend\modules\judiciaryCustomersActions\models\JudiciaryCustomersActions;
use Yii;
use \backend\modules\judiciary\models\Judiciary;
use \backend\modules\judiciary\models\JudiciarySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use \backend\modules\followUpReport\models\FollowUpReport;
use yii\helpers\Html;
use backend\modules\contractInstallment\models\ContractInstallment;
/**
 * JudiciaryController implements the CRUD actions for Judiciary model.
 */
class JudiciaryController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['add-print-case','print-case','logout', 'index', 'update', 'create', 'delete', 'view', 'customer-action', 'delete-customer-action','report'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

   /**
     * Lists all Judiciary models.
     * @return mixed
     */
    public function actionReport()
    {
        $searchModel = new JudiciarySearch();
        $search = $searchModel->report();
        $dataProvider = $search['dataProvider'];
        $counter = $search['count'];

        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'counter' => $counter,
        ]);
    }
    
     /**
     * Lists all Judiciary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request=Yii::$app->request->queryParams;
        //$db=Yii::$app->db;
           $searchModel = new JudiciarySearch();
        //  $search = $db->cache(function($db) use ($searchModel,$request){
            
        //       return $searchModel->search($request);
        //  });
        $search= $searchModel->search($request);


        $dataProvider = $search['dataProvider'];
        $counter = $search['count'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'counter' => $counter,
        ]);
    }
    

    /**
     * Displays a single Judiciary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Judiciary #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    
    public function actionPrintCase($id)
    {
        $request = Yii::$app->request;
        $this->layout = '/print_cases';
        $model =  $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "contracts #" . $id,
                'content' => $this->renderAjax('print_case', [
                    'model' => $model,
                    'id' => $id
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('print_case', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Judiciary model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($contract_id)
    {
        $request = Yii::$app->request;
        $model = new Judiciary();
            if ($model->load($request->post())) {
               $model->contract_id = $contract_id;
               if($model->input_method == 1){

                    $total_amount = Contracts::findOne(['id'=>$contract_id]);
                    $total_amount = $total_amount->total_value;
                    $paid_amount = ContractInstallment::find()
                        ->andWhere(['contract_id' => $contract_id])
                        ->sum('amount');

                    $paid_amount = ($paid_amount > 0) ? $paid_amount : 0;
                    $custamer_referance = (empty($custamer_referance)) ? 0 : $custamer_referance;

                    $amount =  ($total_amount + $custamer_referance) - $paid_amount;

                    $model->lawyer_cost = $amount * ($model->lawyer_cost /100);
                }

                if ($model->save()) {
                    \backend\modules\contracts\models\Contracts::updateAll(['company_id'=>$model->company_id,'status' => 'judiciary'], ['id' => $contract_id]);
               
                    $contractCustamersMosels = \backend\modules\customers\models\ContractsCustomers::find()->where(['contract_id' => $model->contract_id])->all();
                    foreach ($contractCustamersMosels as $contractCustamersMosel) {
                        $judicaryCustamerAction = new \backend\modules\judiciaryCustomersActions\models\JudiciaryCustomersActions();
                        $judicaryCustamerAction->judiciary_id = $model->id;
                        $judicaryCustamerAction->customers_id = $contractCustamersMosel->customer_id;
                        $judicaryCustamerAction->judiciary_actions_id = 1;
                        $judicaryCustamerAction->note = null;
                        $judicaryCustamerAction->action_date = $model->income_date;
                        $judicaryCustamerAction->save();
                    }
                }
                $modelContractDocumentFile = new \backend\modules\contractDocumentFile\models\ContractDocumentFile;
                $modelContractDocumentFile->document_type = 'judiciary file';
                $modelContractDocumentFile->contract_id = $model->id;
                $modelContractDocumentFile->save();
                Yii::$app->cache->set(Yii::$app->params['key_judiciary_contract'],Yii::$app->db->createCommand(Yii::$app->params['judiciary_contract_query'])->queryAll(), Yii::$app->params['time_duration']);
                Yii::$app->cache->set(Yii::$app->params['key_judiciary_year'],Yii::$app->db->createCommand(Yii::$app->params['judiciary_year_query'])->queryAll(), Yii::$app->params['time_duration']);
                if (isset($_POST['print'])) {
                    return $this->redirect(['print-case', 'id' => $model->id]);
                }else{
                    $this->redirect('index');
                }
      
            } else {
                $queryParams = Yii::$app->request->queryParams;
                $contract_model = \backend\modules\contracts\models\Contracts::findOne($contract_id);
                if ($contract_model->is_locked()) {
                    throw new \yii\web\HttpException(403, 'هذا العقد مقفل ومتابع من قبل موظف اخر.');
                } else {
                    $contract_model->unlock();
                    $contract_model->lock();
                }
                return $this->render('create', [
                    'model' => $model,
                    'contract_id' => $contract_id,
                    'contract_model' => $contract_model,
                    'modelsPhoneNumbersFollwUps' => [new \backend\modules\followUpReport\models\FollowUpReport],
                ]);

            }
    }
   

    /**
     * Updates an existing Judiciary model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelCustomerAction = new JudiciaryCustomersActions();

        if ($model->load($request->post()) ) {
            if($model->input_method == 1){

                $total_amount = Contracts::findOne(['id'=>$model->contract_id]);
                $total_amount = $total_amount->total_value;
                $paid_amount = ContractInstallment::find()
                    ->andWhere(['contract_id' => $model->contract_id])
                    ->sum('amount');

                $paid_amount = ($paid_amount > 0) ? $paid_amount : 0;
                $custamer_referance = (empty($custamer_referance)) ? 0 : $custamer_referance;

                $amount =  ($total_amount + $custamer_referance) - $paid_amount;

                $model->lawyer_cost = $amount * ($model->lawyer_cost /100);
            }
            $model->save();
               
            \backend\modules\contracts\models\Contracts::updateAll(['company_id'=>$model->company_id], ['id' => $model->contract_id]);
           Yii::$app->cache->set(Yii::$app->params['key_judiciary_contract'],Yii::$app->db->createCommand(Yii::$app->params['judiciary_contract_query'])->queryAll(), Yii::$app->params['time_duration']);
           Yii::$app->cache->set(Yii::$app->params['key_judiciary_year'],Yii::$app->db->createCommand(Yii::$app->params['judiciary_year_query'])->queryAll(), Yii::$app->params['time_duration']);

            $this->redirect('index');

        }
        return $this->render('update', [
            'model' => $model,
            'modelCustomerAction' => $modelCustomerAction,
            'contract_id' => $model->contract_id
        ]);


    }

    /**
     * Delete an existing Judiciary model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $contract_id = null)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();
        $judicarysCustamer = JudiciaryCustomersActions::find()->where(['judiciary_id' => $id])->all();
        $conection = Yii::$app->getDb();
        $conection->createCommand('UPDATE `os_judiciary_customers_actions` SET `is_deleted`=1 WHERE `judiciary_id`=' . $id)->execute();
        if ($contract_id != null) {
            $judicarys = Judiciary::find()->where(['contract_id' => $contract_id])->all();
            if (empty($judicarys)) {
                Contracts::updateAll(['status' => 'active'], ['id' => $contract_id]);
            }
        }


        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing Judiciary model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Judiciary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Judiciary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Judiciary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCustomerAction($judiciary, $contract_id)
    {
        $modelCustomerAction = new JudiciaryCustomersActions();
        $request = Yii::$app->request;
        $modelCustomerAction->judiciary_id = $judiciary;
        if ($modelCustomerAction->load($request->post()) && $modelCustomerAction->save()) {
            $this->redirect(['update', 'id' => $judiciary, 'contract_id' => $contract_id]);
        }


    }

    public function actionDeleteCustomerAction($id, $judiciary)
    {
        $request = Yii::$app->request;
        $model = JudiciaryCustomersActions::findOne($id);
        $model->delete();
        $this->redirect(['update', 'id' => $judiciary]);

    }
}
