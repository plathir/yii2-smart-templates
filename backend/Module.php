<?php

namespace plathir\templates\backend;

use Yii;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'plathir\templates\backend\controllers';
  //  public $defaultRoute = 'templates';
  //  public $modulename = '';
    public $Theme = 'smart';
    public $mediaPath = '';
    public $mediaUrl = '';    

    public function init() {
       
        parent::init();

        $path = Yii::getAlias('@vendor') . '/plathir/yii2-smart-templates/backend/themes/' . $this->Theme . '/views';
        $this->setViewPath($path);                
        $this->registerTranslations();     
        
        $this->mediaPath = $this->settings->getSettings('TemplatesMediaPath');
        $this->mediaUrl = $this->settings->getSettings('TemplatesMediaUrl');

        $this->controllerMap = [
            'elfinder' => [
                'class' => 'mihaildev\elfinder\Controller',
                'access' => ['@'],
                'disabledCommands' => ['netmount'],
                'roots' => [
                    [
                        'baseUrl' => $this->mediaUrl,
                        'basePath' => $this->mediaPath,
                        'path' => '',
                        'name' => 'Global'
                    ],
                ],
            ],
        ];        
        
        
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
