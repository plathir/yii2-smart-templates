<?php

namespace plathir\templates\components;

use yii\base\Component;
use Yii;
use yii\base\InvalidParamException;
use plathir\templates\common\models\Templates as TemplatesModel;

/**
 *  @property \plathir\settings\Module $module
 */
class Templates extends Component {

    public $modelClass = 'plathir\templates\models\Templates';
    protected $model;

    public function init() {
        parent::init();
    }

    public function getTemplate($id, $params) {
        $template = TemplatesModel::find()->where(['id' => $id])->one();

        if ($template == null) {
            throw new InvalidParamException('Template id with value ' . $id . ' cannot exist !');
        }
        $templ = $template->text;
        foreach ($params as $key => $param) {
            //echo $key. '-->'. $param . '<br>';
            $templ = str_replace($key, $param, $templ);
        }
        return $templ;
    }

}
