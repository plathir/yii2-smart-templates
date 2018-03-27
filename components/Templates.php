<?php

namespace plathir\templates\components;

use yii\base\Component;
use Yii;
use yii\base\InvalidParamException;
use plathir\settings\models\Templates as TemplatesModel;

/**
 *  @property \plathir\settings\Module $module
 */
class Templates extends Component {

    public $modelClass = 'plathir\templates\models\Templates';
    protected $model;

    public function init() {
        parent::init();
    }

    public function getTemplate($id) {
        $template = TemplatesModel::find()->where(['id' => $key])->one();
        if ($setting == null) {
            throw new InvalidParamException('Template id with value ' . $id . ' cannot exist !');
        }
        return $setting->text;
    }

}
