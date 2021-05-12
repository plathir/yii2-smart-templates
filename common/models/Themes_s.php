<?php

namespace plathir\templates\common\models;

use yii\data\ActiveDataProvider;
use plathir\templates\common\models\Themes;

class Themes_s extends Themes {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'string'],
            [['descr'], 'string'],
            [['backend'], 'integer'],
            [['frontend'], 'integer'],
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
        $query = Themes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'name' => $this->name,
            'descr' => $this->descr,
            'backend' => $this->backend,
            'frontend' => $this->frontend,
        ]);

        return $dataProvider;
    }

}
