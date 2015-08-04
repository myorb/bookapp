<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;

/**
 * BookSearch represents the model behind the search form about `app\models\Book`.
 */
class BookSearch extends Book
{

    public $min_date;
    public $max_date;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_date', 'max_date', ], 'safe'],
            [['id', 'author_id', 'status'], 'integer'],
            [['name', 'preview', 'created_at', 'updated_at'], 'safe'],
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название книги',
            'author_id' => 'Автор',
            'status' => 'Status',
            'min_date'=> 'Дата выхода книги',
            'max_date'=> 'До',
            'created_at' => 'Дата',
        ];
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
        $query = Book::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'preview', $this->preview]);

        $query->andFilterWhere(['>', 'created_at', $this->min_date])
            ->andFilterWhere(['<', 'created_at', $this->max_date]);

        return $dataProvider;
    }
}
