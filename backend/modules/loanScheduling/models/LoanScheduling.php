<?php

namespace backend\modules\loanScheduling\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;
use \common\models\User;
/**
 * This is the model class for table "os_loan_scheduling".
 *
 * @property int $id
 * @property int $contract_id
 * @property string $new_installment_date
 * @property float $monthly_installment
 * @property string $first_installment_date
 * @property string $status
 * @property int $status_action_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int|null $last_update_by
 * @property int $is_deleted
 * @property int $number_row
 *
 * @property Contracts $contract
 * @property User $createdBy
 * @property User $lastUpdateBy
 * @property User $statusActionBy
 */
class LoanScheduling extends \yii\db\ActiveRecord
{
    public $number_row;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'os_loan_scheduling';
    }
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'last_update_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('UNIX_TIMESTAMP()'),
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_deleted' => true
                ],

                'replaceRegularDelete' => true // mutate native `delete()` method
            ],

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contract_id', 'new_installment_date', 'monthly_installment', 'first_installment_date', 'status', 'status_action_by'], 'required'],
            [['contract_id',  'status_action_by', 'created_by', 'last_update_by', 'is_deleted','number_row'], 'integer'],
            [[ 'monthly_installment'], 'number'],
            [['first_installment_date', 'created_at', 'updated_at'], 'safe'],
            [['status','new_installment_date'], 'string'],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\modules\contracts\models\Contracts::className(), 'targetAttribute' => ['contract_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['last_update_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['last_update_by' => 'id']],
            [['status_action_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['status_action_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contract_id' => Yii::t('app', 'Contract ID'),
            'new_installment_date' => Yii::t('app', 'New Installment Date'),
            'monthly_installment' => Yii::t('app', 'Monthly Installment'),
            'first_installment_date' => Yii::t('app', 'First Installment Date'),
            'status' => Yii::t('app', 'Status'),
            'status_action_by' => Yii::t('app', 'Status Action By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'last_update_by' => Yii::t('app', 'Last Update By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contracts::className(), ['id' => 'contract_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[LastUpdateBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdateBy()
    {
        return $this->hasOne(User::className(), ['id' => 'last_update_by']);
    }

    /**
     * Gets query for [[StatusActionBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatusActionBy()
    {
        return $this->hasOne(User::className(), ['id' => 'status_action_by']);
    }
    public static function find()
    {
        $query = parent::find();
        $query->attachBehavior('softDelete', SoftDeleteQueryBehavior::className());
        return $query->notDeleted();
    }
}
