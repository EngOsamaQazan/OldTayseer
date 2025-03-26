<?php

namespace backend\modules\financialTransaction\controllers;


use backend\modules\companyBanks\models\CompanyBanks;
use backend\modules\incomeCategory\models\IncomeCategory;
use Yii;
use backend\modules\financialTransaction\models\FinancialTransaction;
use backend\modules\financialTransaction\models\FinancialTransactionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use backend\modules\expenseCategories\models\ExpenseCategories;
use backend\modules\contracts\models\Contracts;
use backend\modules\companies\models\Companies;
use yii\helpers\ArrayHelper;

/**
 * FinancialTransactionController implements the CRUD actions for FinancialTransaction model.
 */
class FinancialTransactionController extends Controller
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
                        'actions' => ['logout', 'save-notes', 'find-notes', 'update-company', 'transfer-data-to-expenses', 'index', 'create', 'contract', 'update-category', 'transfer-data', 'update-type-income', 'update-type', 'import-file', 'delete', 'update-document', 'update'],
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
     * Lists all FinancialTransaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinancialTransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataTransfer = $searchModel->CountDataTransfer();
        $dataTransferExpenses = $searchModel->CountDataTransferExpenses();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataTransfer' => $dataTransfer,
            'dataTransferExpenses' => $dataTransferExpenses,
        ]);
    }

    /**
     * Displays a single FinancialTransaction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "FinancialTransaction #" . $id,
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
     * Creates a new FinancialTransaction model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new FinancialTransaction();
        $model->setScenario('others');
        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new ExpensFinancialTransactiones",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Create new FinancialTransaction",
                    'content' => '<span class="text-success">Create FinancialTransaction success</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Create new FinancialTransaction",
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
            $model->setScenario('createAndUpadte');
            if ($model->load($request->post())) {
                $model->document_number = time();
                $model->is_transfer = 0;
                $model->date = date('Y-m-d H-m-s');
                $model->save();
                 Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

                $this->redirect('index');
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing FinancialTransaction model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->setScenario('others');

        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update FinancialTransaction #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "FinancialTransaction #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update FinancialTransaction #" . $id,
                    'content' => $this->renderAjax('update', [
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
            $model->setScenario('createAndUpadte');
            $isTransfer = $model->is_transfer;
            if ($model->load($request->post())) {
                $model->is_transfer = $isTransfer;
                $model->date = date('Y-m-d H-m-s');
                $model->save();
                Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

                $this->redirect('index');
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing FinancialTransaction model.
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
     * Delete multiple existing FinancialTransaction model.
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
     * Finds the FinancialTransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinancialTransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinancialTransaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionImportFile()
    {
        $financialTransaction = new FinancialTransaction();
        $notImportedRecords = [];
        $request = Yii::$app->request;
        if ($financialTransaction->load($request->post())) {
            $excelFileObj = UploadedFile::getInstance($financialTransaction, 'excel_file');
            $company = $financialTransaction->company_id;
            $bank_id = $financialTransaction->bank_id;
            $bank_number = CompanyBanks::findOne(['bank_id'=>$bank_id,'company_id'=>$company]);
            $bank_number = $bank_number->bank_number;

            if (!empty($excelFileObj)) {
                $financialTransaction = new FinancialTransaction();
                $extension = $excelFileObj->extension;
                $filePath = $excelFileObj->tempName;

                if ($extension == 'xlsx') {
                    $objReader = new \PHPExcel_Reader_Excel2007();
                } elseif ($extension == 'xls') {
                    $objReader = new \PHPExcel_Reader_Excel5();
                } else {
                    $objReader = \PHPExcel_IOFactory::createReader($extension);
                }
                $objPHPExcel = @$objReader->load($filePath);
                $objPHPExcel->setActiveSheetIndex(0);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                $sheetDataCount = count($sheetData);
                //@todo add file format validation

                $documentNumber = time();
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    echo "<pre>";

                        for ($i = 3; $i < $sheetDataCount; $i++) {

                            //replaced D with E
                            if (empty(trim($sheetData[$i]['D']))) {
                                continue;
                            }
                            $model = new FinancialTransaction();
                            $model->setScenario('ImportFile');
                            //replaced D with E
                            $model->bank_description = trim($sheetData[$i]['C']);
                            $model->receiver_number = 0;
                            //replaced D with F
                            $dateStr = str_replace("/", "-", $sheetData[$i]['D']);
                            $model->date = date('Y-m-d', strtotime($dateStr));
                            $model->document_number = $documentNumber;
                            $model->company_id = $company;
                            $model->is_transfer = 0;
                            $model->bank_id = $bank_id;
                            $model->bank_number = $bank_number ;
                            //replaced C with D
                            if (!empty((float)($sheetData[$i]['B']))) {
                                //replaced C with D
                                $model->amount = (float)($sheetData[$i]['B']);
                                $model->type = 2;
                            }
                            //replaced B with C
                            if (!empty((float)($sheetData[$i]['A']))) {
                                $model->amount = (float)($sheetData[$i]['A']);
                                $model->type = 1;
                            }
                            //replaced D with E
                            //replaced C with D
                            if (empty(($sheetData[$i]['A'])) && empty(($sheetData[$i]['B']))) {
                                $model->amount = 0;
                            }

                            if (!$model->validate()) {
                                throw new \Exception('Data not valid');
                            }

                            if (!$model->save()) {
                                throw new \Exception('Data not save');
                            }
                        }
                    
                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception('Something Went Wrong');
                }
               
                if (count($notImportedRecords) == 0) {
                    Yii::$app->session->addFlash('success', 'All Data Has Been Imported');
                }
                Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

                $this->redirect('index');
            }
        }
        return $this->render('import', [
            'model' => $financialTransaction,
            'notImportedRecords' => $notImportedRecords,
        ]);

    }

    public function actionUpdateCategory()
    {
        $id = @Yii::$app->request->post('id');
        $category_id = @Yii::$app->request->post('category_id');
        if ($id > 0 && $category_id > 0 && FinancialTransaction::updateAll(['category_id' => $category_id], ['id' => $id]) > 0) {
            Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

            return Yii::t('app', 'Category updated.');
        }
        return Yii::t('app', 'Cannot update category.');
    }

    public function actionUpdateType()
    {
        $id = @Yii::$app->request->post('id');
        $type = @Yii::$app->request->post('type');
        if ($id > 0 && $type > 0 && FinancialTransaction::updateAll(['type' => $type], ['id' => $id]) > 0) {
            if ($type == 2) {
                FinancialTransaction::updateAll(['income_type' => null], ['id' => $id]);
                FinancialTransaction::updateAll(['contract_id' => null], ['id' => $id]);
            } else {
                FinancialTransaction::updateAll(['category_id' => null], ['id' => $id]);
            }
            Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

            return Yii::t('app', 'Type updated.');
        }

        return Yii::t('app', 'Cannot update type.');
    }

    public function actionUpdateTypeIncome()
    {
        $id = @Yii::$app->request->post('id');
        $typeIncome = @Yii::$app->request->post('type_income');
        if ($id > 0 && $typeIncome > 0 && FinancialTransaction::updateAll(['income_type' => $typeIncome], ['id' => $id]) > 0) {
            if ($typeIncome != 8) {
                FinancialTransaction::updateAll(['contract_id' => null], ['id' => $id]);
            }
            Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

            return Yii::t('app', 'Income type  updated.');
        }
        return Yii::t('app', 'Cannot update type.');
    }

    public function actionContract()
    {
        $id = @Yii::$app->request->post('id');
        $contract = @Yii::$app->request->post('contract');
        if ($id > 0 && $contract > 0 && FinancialTransaction::updateAll(['contract_id' => $contract], ['id' => $id]) > 0) {
            Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);
            return Yii::t('app', 'contract updated.');
        }
        return Yii::t('app', 'Cannot update contract.');
    }

    public function actionUpdateCompany()
    {
        $id = @Yii::$app->request->post('id');
        $company = @Yii::$app->request->post('company');
        if ($id > 0 && $company > 0 && FinancialTransaction::updateAll(['company_id' => $company], ['id' => $id]) > 0) {
            Yii::app()->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

            return Yii::t('app', 'company updated.');
        } else {

            return Yii::t('app', 'Cannot update company.');
        }
    }

    public function actionSaveNotes()
    {
        $id = @Yii::$app->request->post('id');
        $text = @Yii::$app->request->post('text');
        if ($id > 0 && !empty($text) && FinancialTransaction::updateAll(['notes' => $text], ['id' => $id]) > 0) {
            Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);

            return Yii::t('app', 'Notes updated.');
        } else {

            return Yii::t('app', 'Cannot update notes.');
        }
    }

    public function actionUpdateDocument()
    {
        $id = @Yii::$app->request->post('id');
        $number = (int)(@Yii::$app->request->post('number'));


        if ($id > 0 && !empty($number) && FinancialTransaction::updateAll(['document_number' => $number], ['id' => $id]) > 0) {
            Yii::$app->cache->set(Yii::$app->params['key_document_number'],Yii::$app->db->createCommand(Yii::$app->params['document_number_query'])->queryAll(), Yii::$app->params['time_duration']);
            return Yii::t('app', 'update document updated.');
        } else {

            return Yii::t('app', 'Cannot update update document.');
        }
    }

    public function actionFindNotes()
    {
        $id = @Yii::$app->request->post('id');
        if ($id > 0) {
            $not = FinancialTransaction::findOne($id);
            return $not->notes;
        } else {

            return ' ';
        }
    }

    public function actionTransferData()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("START TRANSACTION;
                    INSERT INTO {{%income}} (
                    SELECT 
                    null as id,
                    contract_id,
                    date,
                    amount,
                    " . Yii::$app->user->id . " as created_by,
                    '2' as payment_type,
                    bank_description as _by,
                    null as receipt_bank,
                    'monthly_payment' as payment_purpose,
                    id as financial_transaction_id,
                    income_type as type,
                    notes as notes,
                    document_number as document_number,
                    bank_number as bank_number
                    FROM {{%financial_transaction}} WHERE type=1 AND  income_type = 8 AND contract_id > 0 AND is_transfer = 0);
                    
                  INSERT INTO {{%income}} (
                    SELECT 
                    null as id,
                    contract_id,
                    date,
                    amount,
                    " . Yii::$app->user->id . " as created_by,
                    '2' as payment_type,
                     bank_description as _by,
                    null as receipt_bank,
                    'monthly_payment' as payment_purpose,
                    id as financial_transaction_id,
                    income_type as type,
                      notes as notes,
                    document_number as document_number,
                     bank_number as bank_number
                    FROM {{%financial_transaction}} WHERE 
                     type=1 AND income_type!=8 AND is_transfer = 0);
                     
                    update {{%financial_transaction}} set is_transfer =1 WHERE type=1 AND  income_type = 8 AND contract_id > 0 AND is_transfer = 0; 
                    update {{%financial_transaction}} set is_transfer =1 WHERE type=1 AND income_type!=8 AND is_transfer = 0;
                    COMMIT;")->execute();
       Yii::$app->cache->set(Yii::$app->params['key_income_by'],Yii::$app->db->createCommand(Yii::$app->params['income_by_query'])->queryAll(), Yii::$app->params['time_duration']);

        $this->redirect('index');
    }

    public function actionTransferDataToExpenses()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("START TRANSACTION ;
INSERT INTO {{%expenses}}(
    SELECT 
      null as  id,
        category_id,
        created_at,
        " . Yii::$app->user->id . " as created_by,
        updated_at,
       " . Yii::$app->user->id . "  as last_updated_by,
        is_deleted,
        bank_description as description ,
        amount,
        receiver_number,
        id as financial_transaction_id,
         date as expenses_date,
         notes as notes,
         document_number as document_number,
          contract_id
    FROM {{%financial_transaction}}
    WHERE type = 2 AND is_transfer = 0 AND category_id > 0
);
UPDATE {{%financial_transaction}} set  is_transfer = 1 WHERE type = 2 AND category_id > 0 AND is_transfer = 0;
COMMIT; ")->execute();
        $this->redirect('index');
    }

}
