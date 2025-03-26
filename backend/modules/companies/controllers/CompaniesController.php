<?php

namespace backend\modules\companies\controllers;

use backend\modules\address\models\Address;
use backend\modules\contracts\models\Contracts;
use backend\modules\inventoryItemQuantities\models\InventoryItemQuantities;
use backend\modules\inventoryStockLocations\models\InventoryStockLocations;
use backend\modules\notification\models\Notification;
use common\models\Model;
use Yii;
use backend\modules\companies\models\Companies;
use backend\modules\companies\models\CompaniesSearch;
use \backend\modules\companyBanks\models\CompanyBanks;
use \backend\modules\companyBanks\models\CompanyBanksSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CompaniesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Companies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompaniesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchCounter = $searchModel->searchCounter(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchCounter' => $searchCounter

        ]);
    }


    /**
     * Displays a single Companies model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Companies #" . $id,
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
     * Creates a new Companies model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Companies();
        $modelsCompanieBanks = [new CompanyBanks];

        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post())) {

            $model->created_by = Yii::$app->user->id;
            $model->logo = UploadedFile::getInstance($model, 'logo');
            if (!empty($model->logo)) {
                if ($model->logo->saveAs('images/' . $model->logo->baseName . '.' . $model->logo->extension)) {
                    $model->logo = 'images/' . $model->logo->baseName . '.' . $model->logo->extension;
                    $model->created_by = Yii::$app->user->id;
                    $model->save();
                }
            }

            $modelsCompanieBanks = Model::createMultiple(CompanyBanks::classname());
            Model::loadMultiple($modelsCompanieBanks, Yii::$app->request->post());
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsCompanieBanks);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    if ($flag = $model->save(false)) {
                        foreach ($modelsCompanieBanks as $modelsCompanieBank) {
                            $modelsCompanieBank->company_id = $model->id;

                            if (!($companieBankFlag = $modelsCompanieBank->save())) {
                                $transaction->rollBack();
                                var_dump($modelsCompanieBank->getErrors());
                                break;
                            }
                        }

                        if ($flag && $companieBankFlag) {

                            $transaction->commit();
                        }
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                    var_dump($model->getErrors());
                }
            }

            Yii::$app->cache->set(Yii::$app->params['key_company'], Yii::$app->db->createCommand(Yii::$app->params['company_query'])->queryAll(), Yii::$app->params['time_duration']);
            Yii::$app->cache->set(Yii::$app->params['key_company_name'], Yii::$app->db->createCommand(Yii::$app->params['company_name_query'])->queryAll(), Yii::$app->params['time_duration']);

            $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsCompanieBanks' => (empty($modelsCompanieBanks)) ? [new CompanyBanks] : $modelsCompanieBanks,
            ]);
        }


    }

    /**
     * Updates an existing Companies model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsCompanieBanks = CompanyBanks::find()->where(['company_id' => $id])->all();
        $logo = $model->logo;
        $createdBy = $model->created_by;
        if ($model->load($request->post())) {
            $model->logo = UploadedFile::getInstance($model, 'logo');
            if (!empty($model->logo)) {
                if ($model->logo->saveAs('images/' . $model->logo->baseName . '.' . $model->logo->extension)) {
                    $model->logo = 'images/' . $model->logo->baseName . '.' . $model->logo->extension;
                    $model->created_by = Yii::$app->user->id;
                    $model->save();
                }
            } else {
                $model->logo = $logo;
            }


            $oldIDs = yii\helpers\ArrayHelper::map($modelsCompanieBanks, 'id', 'id');

            $modelsCompanieBanks = Model::createMultiple(CompanyBanks::classname(), $modelsCompanieBanks);

            Model::loadMultiple($modelsCompanieBanks, Yii::$app->request->post());

            $deletedIDs = array_diff($oldIDs, array_filter(yii\helpers\ArrayHelper::map($modelsCompanieBanks, 'id', 'id')));

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsCompanieBanks) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            CompanyBanks::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsCompanieBanks as $modelsCompanieBank) {

                            $modelsCompanieBank->company_id = $model->id;

                            if (!($companieBankFlag = $modelsCompanieBank->save())) {

                                $transaction->rollBack();
                                var_dump($modelsCompanieBank->getErrors());
                                break;
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['index']);
                        }

                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

            Yii::app()->cache->set(Yii::$app->params['key_company'], Yii::$app->db->createCommand(Yii::$app->params['company_query'])->queryAll(), Yii::$app->params['time_duration']);
            Yii::app()->cache->set(Yii::$app->params['key_company_name'], Yii::$app->db->createCommand(Yii::$app->params['company_name_query'])->queryAll(), Yii::$app->params['time_duration']);

            $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsCompanieBanks' => (empty($modelsCompanieBanks)) ? [new CompanyBanks] : $modelsCompanieBanks,

            ]);
        }

    }

    /**
     * Delete an existing Companies model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();
        CompanyBanks::updateAll(['is_deleted' => 1], ['company_id' => $id]);
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


    public function actionGetItems($company_id, $model_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $arr = [];
        $selected = [];
        $quantitiesItems = InventoryItemQuantities::find()
            ->joinWith(['locations'])
            ->andWhere(['company_id' => $company_id])
            ->all();
        if ($quantitiesItems) {
            foreach ($quantitiesItems as $quantitiesItem) {
                if (isset($quantitiesItem->item)) {
                    $arr[$quantitiesItem->item->id] = $quantitiesItem->item->item_name;
                }
            }
        }
        if ($model_id) {
            $contract = Contracts::find()->andWhere(['id' => $model_id])->one();
            if (isset($contract->inventoryItemValue) && !empty($contract->inventoryItemValue)) {
                $selected = $contract->inventoryItemValue;
            }
        }
        return [
            'items' => $arr,
            'selected' => $selected
        ];

    }

    /**
     * Delete multiple existing Companies model.
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
     * Finds the Companies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Companies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Companies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
