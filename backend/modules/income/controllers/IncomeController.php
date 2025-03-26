<?php

namespace backend\modules\income\controllers;

use common\models\Expenses;
use backend\modules\financialTransaction\models\FinancialTransaction;
use Yii;
use backend\modules\income\models\Income;
use backend\modules\income\models\IncomeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * IncomeController implements the CRUD actions for Installment model.
 */
class IncomeController extends Controller
{
    public $customer_ids;

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
                        'actions' => ['logout', 'index', 'update', 'update-income', 'create', 'delete', 'income-list', 'back-to-financial-transaction'],
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
     * Lists all Installment models.
     * @return mixed
     */
    public function actionIndex($customer_id)
    {
        $customer_ids = $customer_id;
        $searchModel = new IncomeSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = Income::find()->andFilterWhere(['customer_id' => $customer_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $incomeSummary = Income::findOne(['customer_id' => $customer_id]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'incomeSummary' => $incomeSummary,
            'customer_id' => $customer_id
        ]);
    }


    /**
     * Displays a single Installment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Installment #" . $id,
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

    /**
     * Creates a new Installment model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Income();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new Installment",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new Installment",
                    'content' => '<span class="text-success">Create Installment success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])

                ];
            } else {
                return [
                    'title' => "Create new Installment",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                Yii::$app->cache->set(Yii::$app->params['key_income_by'],Yii::$app->db->createCommand(Yii::$app->params['income_by_query'])->queryAll(), Yii::$app->params['time_duration']);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Installment model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);


        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->cache->set(Yii::$app->params['key_income_by'],Yii::$app->db->createCommand(Yii::$app->params['income_by_query'])->queryAll(), Yii::$app->params['time_duration']);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Delete an existing Installment model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

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
     * Delete multiple existing Installment model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
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
     * Finds the Installment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Income the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Income::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIncomeList()
    {
        $searchModel = new IncomeSearch();
        $dataProvider = $searchModel->incomeListSearch(Yii::$app->request->queryParams);
        $totalAmount = $searchModel->getTotalAmount(Yii::$app->request->queryParams);
        return $this->render('income-item-list', [
            'searchModel' => $searchModel,
            'totalAmount' => (float)($totalAmount),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBackToFinancialTransaction($id, $financial)
    {
        if (!empty($id) && !empty($financial)) {
            Income::deleteAll(['id' => $id]);
            FinancialTransaction::updateAll(['is_transfer' => 0], ['id' => $financial]);
        }

        $this->redirect('income-list');

    }

    public function actionUpdateIncome($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);


        if ($model->load($request->post()) && $model->save()) {
            $this->redirect('income-list');
        } else {
            return $this->render('income_list_form', [
                'model' => $model,
            ]);
        }
        
    }

}
