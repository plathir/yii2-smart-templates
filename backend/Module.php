<?php

namespace plathir\templates\backend;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\templates\backend\controllers';
  //  public $defaultRoute = 'templates';
  //  public $modulename = '';
    public $Theme = 'smart';

    public function init() {
       
        parent::init();

        $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-templates/backend/themes/' . $this->Theme . '/views';
        $this->setViewPath($path);                
        $this->registerTranslations();       
    }

    public function registerTranslations() {
        /*         * This registers translations for the widgets module * */
        Yii::$app->i18n->translations['templates'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => Yii::getAlias('@vendor/plathir/yii2-smart-templates/backend/messages'),
        ];
    }

}
