<?php

namespace backend\modules\loanScheduling\controllers;

use backend\modules\notification\models\Notification;
use Yii;
use backend\modules\loanScheduling\models\LoanScheduling;
use backend\modules\loanScheduling\models\LoanSchedulingSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * LoanSchedulingController implements the CRUD actions for LoanScheduling model.
 */
class LoanSchedulingController extends Controller
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
                        'actions' => ['logout', 'index', 'update', 'create', 'delete','create-from-follow-up','delete-from-follow-up','update-follow-up'],
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
     * Lists all LoanScheduling models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new LoanSchedulingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single LoanScheduling model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "LoanScheduling #" . $id,
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
     * Creates a new LoanScheduling model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($contract_id)
    {
        $request = Yii::$app->request;
        $model = new LoanScheduling();
        if ($model->load($request->post())) {
            $model->contract_id = $contract_id;
            $model->status = 'pending';
            $model->status_action_by = Yii::$app->user->id;

            if ($model->save()) {
                Yii::$app->notifications->sendByRule(['Manager'], 'loan-scheduling/update?id='.$model->id, Notification::GENERAL,Yii::t('app', 'إنشاء عقد جدولة القرض') . $contract_id .'من قبل '.Yii::$app->user->identity['username'], Yii::t('app', 'إنشاء عقد جدولة القرض') . $contract_id, Yii::$app->user->id);
                Yii::app()->cache->set(Yii::$app->params['key_loan_contract'],yii\helpers\ArrayHelper::map(\backend\modules\loanScheduling\models\LoanScheduling::find()->all(), 'contract_id', 'contract_id'), Yii::$app->params['time_duration']);

                $this->redirect('index');
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

public function  actionCreateFromFollowUp ($contract_id)
{
    $request = Yii::$app->request;
    $model = new LoanScheduling();

    if($request->isAjax){
        /*
        *   Process for ajax request
        */
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){

            return [
                'title'=> "Create new LoanScheduling",
                'content'=>$this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

            ];
        }else if($model->load($request->post()) ){
            $model->contract_id = $contract_id;
            $model->status = 'pending';
            $model->status_action_by = Yii::$app->user->id;
             $model->save();
            return [
                'forceReload'=>'#table-crud-datatable-'.$contract_id.'-pjax',
                'title'=> "Create new LoanScheduling",
                'content'=>'<span class="text-success">Create LoanScheduling success</span>',
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

            ];
        }else{
            return [
                'title'=> "Create new LoanScheduling",
                'content'=>$this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

            ];
        }
    }else{
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
            Yii::app()->cache->set(Yii::$app->params['key_loan_contract'],yii\helpers\ArrayHelper::map(\backend\modules\loanScheduling\models\LoanScheduling::find()->all(), 'contract_id', 'contract_id'), Yii::$app->params['time_duration']);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

}
    /**
     * Updates an existing LoanScheduling model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateFollowUp($id,$contract_id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){

                return [
                    'title'=> "Update new LoanScheduling",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) ){
                $model->contract_id = $contract_id;
                $model->status = 'pending';
                $model->status_action_by = Yii::$app->user->id;
                $model->save();
                return [
                    'forceReload'=>'#table-crud-datatable-'.$contract_id.'-pjax',
                    'title'=> "Update new LoanScheduling",
                    'content'=>'<span class="text-success">Update LoanScheduling success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Update More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new LoanScheduling",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }

        }
    }
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){

                return [
                    'title'=> "Create new LoanScheduling",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) ){
            //    $model->contract_id = $contract_id;
                $model->status = 'pending';
                $model->status_action_by = Yii::$app->user->id;
                $model->save();
                return [
                   // 'forceReload'=>'#table-crud-datatable-'.$contract_id.'-pjax',
                    'title'=> "Create new LoanScheduling",
                    'content'=>'<span class="text-success">Create LoanScheduling success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new LoanScheduling",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                Yii::$app->cache->set(Yii::$app->params['key_loan_contract'],yii\helpers\ArrayHelper::map(\backend\modules\loanScheduling\models\LoanScheduling::find()->all(), 'contract_id', 'contract_id'), Yii::$app->params['time_duration']);

                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * Delete an existing LoanScheduling model.
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
    public function actionDeleteFromFollowUp($id,$contract_id)
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
            return $this->redirect(['/followUp/follow-up/index','contract_id'=>$contract_id]);
        }


    }

    /**
     * Delete multiple existing LoanScheduling model.
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
     * Finds the LoanScheduling model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoanScheduling the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoanScheduling::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
