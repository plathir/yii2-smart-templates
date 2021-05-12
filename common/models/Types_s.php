<?php

namespace plathir\templates\common\models;

use yii\data\ActiveDataProvider;
use plathir\templates\common\models\Types;

class Types_s extends Types {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'integer'],
            [['descr'], 'string'],
            [['avail_fields'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Types::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'name' => $this->name,
            'descr' => $this->descr,
            'avail_fields' => $this->descr,
        ]);

        return $dataProvider;
    }

}
