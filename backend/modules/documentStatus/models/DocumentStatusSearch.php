<?php

namespace backend\modules\documentStatus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\documentStatus\models\DocumentStatus;

/**
 * DocumentStatusSearch represents the model behind the search form about `backend\modules\documentStatus\models\DocumentStatus`.
 */
class DocumentStatusSearch extends DocumentStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'last_updated_by', 'is_deleted'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DocumentStatus::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'name', $this->name])->where(['is_deleted'=>0]);

        return $dataProvider;
    }
}
